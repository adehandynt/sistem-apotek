<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;
use PhpParser\Node\Stmt\Foreach_;
use App\Models\Transaksi;
use App\Models\ItemPenjualan;
use App\Models\JasaLain;
use App\Models\Stok;
use App\Models\Staf;
use App\Models\BarangKeluar;
use App\Models\HistoryBarang;
use App\Models\RekamMedis;
use App\Models\Resep;
use App\Models\AlatJasa;
use App\Models\JasaDokter;
use DB;
use Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ReceiptController extends Controller
{
    public function print(Request $request)
    {
        $id = IdGenerator::generate(['table' => 'transaksi', 'field' => 'no_transaksi', 'length' => 9, 'prefix' => 'TRX']);
        $id_jasa = IdGenerator::generate(['table' => 'jasa_lain', 'field' => 'id_jasa', 'length' => 9, 'prefix' => 'JSA']);
        DB::transaction(function() use ($id,$id_jasa,$request) {
        $transaksi = new Transaksi;
        $transaksi->no_transaksi = $id;
        $transaksi->tgl_transaksi = \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        $transaksi->total = $request->input('bill_grand_total');
        $transaksi->nip = Auth::user()->nip;
        $transaksi->uang_diterima = $request->input('uang_diterima');
        $transaksi->uang_kembalian = $request->input('uang_kembali')==null?0:$request->input('uang_kembali');
        $transaksi->metode_pembayaran = $request->input('metode_pembayaran');
        $transaksi->tuslah = $request->input('bill_tuslah_total');
        if(isset($request->no_kartu)){
            $transaksi->bank = $request->input('bank');
            $transaksi->no_kartu = $request->input('no_kartu');
        }
        if(isset($request->no_bpjs)){
            $transaksi->bpjs = $request->input('no_bpjs');
        }
        $transaksi->save();
        
        $saved = $transaksi->save();
        
        if (!$saved) {
            return false;
        } else {
            if ($request->input('kode_barang') != null) {
            foreach ($request->input('kode_barang') as $idx => $val) {
                $id_item = IdGenerator::generate(['table' => 'item_penjualan', 'field' => 'id_item', 'length' => 9, 'prefix' => 'ITM']);
                $item = new ItemPenjualan;
                $item->id_item = $id_item;
                $item->no_transaksi = $id;
                $item->kode_barang = $request->input('kode_barang')[$idx];
                $item->jumlah = $request->input('jml_barang')[$idx];

                $item->save();

                $data = Stok::leftJoin('history_barang', 'history_barang.kode_barang', '=', 'stok.kode_barang')
                    ->where('stok.kode_barang', '=', $request->input('kode_barang')[$idx])
                    ->select('stok.stock_id', 'stok.jml_akumulasi', DB::raw('COALESCE(COALESCE(history_barang.sisa, stok.jml_masuk ),0) AS sisa'))
                    ->orderBy('history_barang.created_at', 'desc')
                    ->orderBy('history_barang.sisa', 'asc')
                    ->take(1)
                    ->get();



                $sisa = $data[0]->sisa==0||$data[0]->sisa==null? $data[0]->jml_akumulasi:$data[0]->sisa;
                $id_keluar = IdGenerator::generate(['table' => 'barang_keluar', 'field' => 'id_keluar', 'length' => 9, 'prefix' => 'KLR-']);
                $keluar = new BarangKeluar;
                $keluar->id_keluar = $id_keluar;
                $keluar->stock_id = $data[0]->stock_id;
                $keluar->tgl_keluar = \Carbon\Carbon::now()->timezone('Asia/Jakarta');
                $keluar->jml_keluar = $request->input('jml_barang')[$idx];
                $keluar->nip = Auth::user()->nip;
                $keluar->sisa = $sisa - $request->input('jml_barang')[$idx];
                $keluar->save();

                $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
                $id_history = IdGenerator::generate(['table' => 'history_barang','field'=>'id_history', 'length' => 15, 'prefix' =>'HIS-'. $year . '-']);
                $history = new HistoryBarang;
                $history->id_history=$id_history;
                $history->kode_barang=$request->input('kode_barang')[$idx];
                $history->tgl_keluar=\Carbon\Carbon::now()->timezone('Asia/Jakarta');
                $history->jml_keluar=$request->input('jml_barang')[$idx];
                $history->jenis_history='barang_keluar';
                $history->id_referensi=$id;
                $history->pic=Auth::user()->nip;
                $history->sisa=$sisa - $request->input('jml_barang')[$idx];
                $history->save();
                
            }
        }
            $save['status_resep']=1;
            $resep=Resep::where('id_rekam_medis',$request->id_rekam_hidden)->update($save);
            if ($request->input('nama_jasa') != null) {
                foreach ($request->input('nama_jasa') as $idx => $val) {
                    $jasa = new JasaLain;
                    $jasa->id_jasa = $id_jasa;
                    $jasa->no_transaksi = $id;
                    $jasa->biaya = $request->input('biaya_jasa')[$idx];
                    $jasa->jml_jasa = $request->input('jml_jasa')[$idx];
                    $jasa->deskripsi = $request->input('nama_jasa')[$idx];

                    $jasa->save();

                    $list_alat=AlatJasa::where('id_list_jasa', '=', $request->input('nama_jasa')[$idx])->get();
                    foreach ($list_alat as $idx => $val) {
                        $data = Stok::leftJoin('history_barang', 'history_barang.kode_barang', '=', 'stok.kode_barang')
                        ->where('stok.kode_barang', '=',$val->kode_barang)
                        ->select('stok.stock_id', 'stok.jml_akumulasi', DB::raw('COALESCE(COALESCE(history_barang.sisa, stok.jml_masuk ),0) AS sisa'))
                        ->orderBy('history_barang.created_at', 'desc')
                        ->orderBy('history_barang.sisa', 'asc')
                        ->take(1)
                        ->get();

                        $sisa = $data[0]->sisa==0||$data[0]->sisa==null? $data[0]->jml_akumulasi:$data[0]->sisa;
    
                        $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
                        $id_history = IdGenerator::generate(['table' => 'history_barang','field'=>'id_history', 'length' => 15, 'prefix' =>'HIS-'. $year . '-']);
                        $history = new HistoryBarang;
                        $history->id_history=$id_history;
                        $history->kode_barang=$val->kode_barang;
                        $history->tgl_keluar=\Carbon\Carbon::now()->timezone('Asia/Jakarta');
                        $history->jml_keluar= $request->input('jml_jasa')[$idx];
                        $history->jenis_history='barang_keluar_jasa';
                        $history->id_referensi=$id;
                        $history->pic=Auth::user()->nip;
                        $history->sisa=$sisa - $request->input('jml_jasa')[$idx];
                        $history->save();
                    }

                }
            }

            if ($request->input('nama_racik')[0] != null) {
                foreach ($request->input('nama_racik') as $idx => $val) {
                    $id_item = IdGenerator::generate(['table' => 'item_penjualan', 'field' => 'id_item', 'length' => 9, 'prefix' => 'ITM']);
                    $item = new ItemPenjualan;
                    $item->id_item = $id_item;
                    $item->no_transaksi = $id;
                    $item->kode_barang = $request->input('id_obat_racik')[$idx];
                    $item->jumlah = $request->input('jml_racik')[$idx];
    
                    $item->save();
    
                    $data = Stok::leftJoin('history_barang', 'history_barang.kode_barang', '=', 'stok.kode_barang')
                        ->where('stok.kode_barang', '=', $request->input('id_obat_racik')[$idx])
                        ->select('stok.stock_id', 'stok.jml_akumulasi',DB::raw('COALESCE(COALESCE(history_barang.sisa, stok.jml_masuk ),0) AS sisa'))
                        ->orderBy('history_barang.created_at', 'desc')
                        ->orderBy('history_barang.sisa', 'asc')
                        ->take(1)
                        ->get();
                        
                    $sisa = $data[0]->sisa==0||$data[0]->sisa==null? $data[0]->jml_akumulasi:$data[0]->sisa;
                    // $sisa = 100;
                    $id_keluar = IdGenerator::generate(['table' => 'barang_keluar', 'field' => 'id_keluar', 'length' => 9, 'prefix' => 'KLR-']);
                  
                    $keluar = new BarangKeluar;
                    $keluar->id_keluar = $id_keluar;
                    $keluar->stock_id = $data[0]->stock_id;
                    $keluar->tgl_keluar = \Carbon\Carbon::now()->timezone('Asia/Jakarta');
                    $keluar->jml_keluar = $request->input('jml_racik')[$idx];
                    $keluar->nip = Auth::user()->nip;
                    $keluar->sisa = $sisa - $request->input('jml_racik')[$idx];
                    $keluar->save();
    
                    $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
                    $id_history = IdGenerator::generate(['table' => 'history_barang','field'=>'id_history', 'length' => 15, 'prefix' =>'HIS-'. $year . '-']);
                    $history = new HistoryBarang;
                    $history->id_history=$id_history;
                    $history->kode_barang=$request->input('id_obat_racik')[$idx];
                    $history->tgl_keluar=\Carbon\Carbon::now()->timezone('Asia/Jakarta');
                    $history->jml_keluar=$request->input('jml_racik')[$idx];
                    $history->jenis_history='barang_keluar';
                    $history->id_referensi=$id;
                    $history->pic=Auth::user()->nip;
                    $history->sisa=$sisa - $request->input('jml_racik')[$idx];
                    $history->save();

                    $id_jasa_dokter = IdGenerator::generate(['table' => 'jasa_dokter','field'=>'id_jasa_dokter', 'length' => 15, 'prefix' =>'JSD-'. $year . '-']);
                    $jasa_dokter = new JasaDokter;
                    $jasa_dokter->id_jasa_dokter=$id_jasa_dokter;
                    $jasa_dokter->no_transaksi=$id;
                    $jasa_dokter->biaya=$request->input('bill_grand_dokter');
                    $jasa_dokter->deskripsi="-";
                    $jasa_dokter->save();
                }
            }
        }
    });

        // Set params
        $staf=Staf::where('nip','=',Auth::user()->nip)->select('nama_staf')->get();
        $mid = $staf[0]->nama_staf;
        $store_name = 'APOTEK SINDANG SARI FARMA';
        $store_address = 'Jalan Sindang Sari 1, Antapani, Bandung';
        $store_phone = '';
        $store_email = '';
        $store_website = '';
        $tax_percentage = 10;
        $transaction_id = $id;

        // Set items

        $jmlItem=0;
        if ($request->input('nama_barang') != null) {
        foreach ($request->input('nama_barang') as $idx => $val) {
            $items[] = [
                'name' => $request->input('nama_barang')[$idx],
                'qty' => $request->input('jml_barang')[$idx],
                'price' => $request->input('hargabarang')[$idx],
            ];
            $jmlItem+=$request->input('jml_barang')[$idx];
        }
    }
        if ($request->input('nama_jasa') != null) {
            foreach ($request->input('nama_jasa') as $idx => $val) {
                $items[] = [
                    'name' => $request->input('nama_jasa')[$idx],
                    'qty' => $request->input('jml_jasa')[$idx],
                    'price' => $request->input('biaya_jasa')[$idx],
                ];
                $jmlItem+=$request->input('jml_jasa')[$idx];
            }
        }

        if ($request->input('id_obat_racik') != null || $request->input('id_obat_racik') != "") {
           $last_idx=max(array_keys($request->input('jasa_dokter')));
                $items[] = [
                    'name' => 'Dokter',
                    'qty' => '1',
                    'price' => $request->input('jasa_dokter')[$last_idx],
                ];
            
        }


        // Init printer
        $printer = new ReceiptPrinter;
        $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );

        // Set store info
        $printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);

        // Add items
        foreach ($items as $item) {
            $printer->addItem(
                $item['name'], 
                $item['qty'],
                $item['price']
            );
        }

        $printer->setBank($request->input('bank_pembayaran'), $request->input('no_kartu'));

        $printer->setCashIn($request->input('uang_diterima'));
        $printer->setChange($request->input('uang_kembali'));
        // Set tax
        $printer->setTax($tax_percentage);

        // Calculate total
        $printer->calculateSubTotal();
        $printer->calculateGrandTotal();

        // Set transaction ID
        $printer->setTransactionID($transaction_id);

        // Set qr code
        $printer->setQRcode([
            'tid' => $transaction_id,
        ]);

        $printer->setjmlItem($jmlItem);

        // Print receipt
        $printer->printReceipt();
        return true;
    }

    public function prints(Request $request)
    {
        $id = IdGenerator::generate(['table' => 'transaksi', 'field' => 'no_transaksi', 'length' => 9, 'prefix' => 'TRX']);
        $id_item = IdGenerator::generate(['table' => 'item_penjualan', 'field' => 'id_item', 'length' => 9, 'prefix' => 'ITM']);
        $transaksi = new Transaksi;
        $transaksi->no_transaksi = $id;
        $transaksi->tgl_transaksi = \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        $transaksi->total = $request->input('bill_grand_total');
        $transaksi->nip = "1";
        $transaksi->uang_diterima = $request->input('uang_diterima');
        $transaksi->uang_kembalian = $request->input('uang_kembali');
        $transaksi->metode_pembayaran = $request->input('no_kartu') == null || $request->input('no_kartu') == "" ? 'cash' : 'cashless';
        $transaksi->no_kartu = $request->input('no_kartu');
        $transaksi->save();

        foreach ($request->input('kode_barang') as $idx => $val) {
            $item = new ItemPenjualan;
            $item->id_item = $id_item;
            $item->no_transaksi = $id;
            $item->kode_barang = $request->input('kode_barang')[$idx];
            $item->jumlah = $request->input('jml_barang')[$idx];

            $item->save();
        }
    }
} 
