<?php

namespace App\Http\Controllers;

use App\Exports\ExportPembelian;
use App\Exports\ExportPembelianParams;
use App\Exports\ExportPenjualanParams;
use App\Exports\ExportLaba;
use App\Exports\ExportNarkotika;
use App\Exports\ExportBpjs;
use App\Exports\ExportKonsinyasi;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Obat;
use App\Models\Satuan;
use App\Models\Pembelian;
use App\Models\Harga;
use App\Models\ItemPenjualan;
use App\Models\SetHarga;
use App\Models\Stok;
use App\Models\Supplier;
use App\Models\ListItem;
use App\Models\Staf;
use App\Models\ReturJual;
use App\Models\HistoryBarang;
use App\Models\RekamMedis;
use Validator;
use Hash;
use DB;
use PDF;
use Auth;
use Session;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Exports\ExportPenjualan;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function view_pembelian(){
        $res['supplier']=Supplier::get();
        return view('laporan/pembelian',$res);
    }

    public function view_penjualan(){
        $res['supplier']=Supplier::get();
        return view('laporan/penjualan',$res);
    }

    public function view_labarugi(){
        $res['barang']=Obat::join('tipe','tipe.kode_tipe','=','barang.kode_tipe')->get();
        return view('laporan/laba-rugi',$res);
    }

    public function view_narkotika(){
        $res['barang']=Obat::join('tipe','tipe.kode_tipe','=','barang.kode_tipe')->where('tipe.nama_tipe','Narkotika')->select('tipe.*','barang.nama_barang','barang.kode_barang')->groupBy('barang.nama_barang')->get();
        return view('laporan/narkotika',$res);
    }

    public function view_bpjs(){
        $res['supplier']=Supplier::get();
        return view('laporan/bpjs',$res);
    }

    public function view_laba(){
        $res['supplier']=Supplier::get();
        return view('laporan/laba-rugi',$res);
    }


    public function view_konsinyasi(){
        $res['barang']=Obat::join('tipe','tipe.kode_tipe','=','barang.kode_tipe')
        ->where('tipe.nama_tipe','Jamu')
        ->whereNotNull('barang.konsinyasi')
        ->select('tipe.*','barang.nama_barang','barang.kode_barang')
        ->groupBy('barang.nama_barang')
        ->get();
        return view('laporan/konsinyasi',$res);
    }

    public function list_laporan(Request $request)
    {
        
        if($request->type=='pembelian'){
            $data=Pembelian::join('supplier', 'orders.id_supplier', '=', 'supplier.id_supplier')
            ->leftJoin('staf', 'orders.order_by', '=', 'staf.nip')
            ->select('orders.*','supplier.nama_supplier','staf.nama_staf')->get();
            for ($i = 0; $i < count($data); $i++) {
                    $data[$i]->action = '<a href="cetak-pdf?id=' . encrypt($data[$i]->id) . '" class="action-icon" data-id="' . $data[$i]->id . '"> <i class="mdi mdi-printer-check"></i></a><a href="export-excel-pembelian?id=' . encrypt($data[$i]->id) . '" class="action-icon" data-id="' . $data[$i]->id . '"> <i class="mdi mdi-file-excel"></i></i></a>';
            }
        }elseif($request->type=='penjualan'){
            $data=Penjualan::select('transaksi.*',DB::raw('DATE(transaksi.tgl_transaksi) as date'),DB::raw('SUM(transaksi.total) as total'))
            ->groupBy('date')
            ->get();
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]->no=$i+1;
                    $data[$i]->action = '<a href="cetak-pdf-penjualan?id=' . encrypt($data[$i]->date) . '" class="action-icon" data-id="' . $data[$i]->date . '"> <i class="mdi mdi-printer-check"></i></a><a href="export-excel-penjualan?id=' . encrypt($data[$i]->date) . '" class="action-icon" data-id="' . $data[$i]->date . '"> <i class="mdi mdi-file-excel"></i></i></a>';
            }
            
        }elseif($request->type=='narkotika'){
            $data=Penjualan:: join('item_penjualan', 'transaksi.no_transaksi', '=', 'item_penjualan.no_transaksi')
            ->join('barang','item_penjualan.kode_barang','=','barang.kode_barang')
            ->join('tipe','barang.kode_tipe','=','tipe.kode_tipe')
            ->select('transaksi.*','barang.nama_barang','barang.kode_barang')
            ->where('tipe.nama_tipe','like','%Narkotika%')
            ->orwhere('tipe.nama_tipe','like','%Psikotropika%')
            ->groupBy('barang.nama_barang')
            ->get();
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]->no=$i+1;
                    $data[$i]->action = '<a href="cetak-pdf-narkotika?id=' . encrypt($data[$i]->kode_barang) . '" class="action-icon" data-id="' . $data[$i]->kode_barang . '"> <i class="mdi mdi-printer-check"></i></a><a href="export-excel-narkotika?id=' .  encrypt($data[$i]->kode_barang) . '" class="action-icon" data-id="' . $data[$i]->kode_barang . '"> <i class="mdi mdi-file-excel"></i></i></a>';
            }
            
        }elseif($request->type=='konsinyasi'){
            $data=Obat::join('tipe','barang.kode_tipe','=','tipe.kode_tipe')
            ->leftJoin(DB::raw('(SELECT
            *,
            ( select x.sisa from (SELECT kode_barang, id_history, sisa FROM history_barang WHERE jenis_history = "barang_keluar" 
            ORDER BY
                id DESC limit 1) as x  GROUP BY x.kode_barang) AS sisa_brg,
            ( SELECT sum( jml_keluar ) FROM history_barang WHERE jenis_history = "barang_keluar" GROUP BY
            kode_barang
        ORDER BY
            id_history DESC LIMIT 1) AS jml_brg 
        FROM
            history_barang 
        WHERE
            jenis_history = "barang_keluar" 
            GROUP BY
            kode_barang
        ORDER BY
            id_history DESC) AS history_barang'),
        'history_barang.kode_barang', '=', 'barang.kode_barang')
            ->select('barang.nama_barang','barang.kode_barang','barang.konsinyasi',DB::raw('COALESCE(history_barang.jml_brg,"-")AS terjual'),DB::raw('COALESCE(history_barang.sisa_brg,0) AS sisa'))
            ->whereNotNull('barang.konsinyasi')
            ->groupBy('barang.nama_barang')
            ->get();
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]->no=$i+1;
                    $data[$i]->action = '<a href="cetak-pdf-konsinyasi?id=' . encrypt($data[$i]->kode_barang) . '" class="action-icon" data-id="' . $data[$i]->kode_barang . '"> <i class="mdi mdi-printer-check"></i></a><a href="export-excel-konsinyasi?id=' . encrypt($data[$i]->kode_barang) . '" class="action-icon" data-id="' . $data[$i]->kode_barang . '"> <i class="mdi mdi-file-excel"></i></i></a>';
            }
            
        }elseif($request->type=='bpjs'){
            $data=Penjualan::select('transaksi.*',DB::raw('DATE(transaksi.tgl_transaksi) as date'),DB::raw('SUM(transaksi.total) as total'))
            ->whereNotNull('bpjs')
            ->get();
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]->no=$i+1;
                    $data[$i]->action = '<a href="cetak-pdf-bpjs?id=' . encrypt($data[$i]->no_transaksi) . '" class="action-icon" data-id="' . $data[$i]->no_transaksi . '"> <i class="mdi mdi-printer-check"></i></a><a href="export-excel-bpjs?id=' . encrypt($data[$i]->no_transaksi) . '" class="action-icon" data-id="' . $data[$i]->no_transaksi . '"> <i class="mdi mdi-file-excel"></i></i></a>';
            }
        }elseif($request->type=='labarugi'){
            $data=Penjualan::select('transaksi.*',DB::raw('DATE(transaksi.tgl_transaksi) as dates'),DB::raw('MONTHNAME(transaksi.tgl_transaksi) as date'),DB::raw('YEAR(transaksi.tgl_transaksi) as year'),DB::raw('SUM(transaksi.total) as total'))
            ->groupBy('date','year')
            ->get();
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]->no=$i+1;
                    $data[$i]->action = '<a href="cetak-pdf-laba?id=' . encrypt($data[$i]->dates) . '" class="action-icon" data-id="' . $data[$i]->dates . '"> <i class="mdi mdi-printer-check"></i></a><a href="export-excel-labarugi?id=' . encrypt($data[$i]->dates) . '" class="action-icon" data-id="' . $data[$i]->dates . '"> <i class="mdi mdi-file-excel"></i></i></a>';
            }
            
        }
        return json_encode($data);
    }

    public function print_pembelian(Request $request){
        $data=Pembelian::join('list_order','list_order.id_order','=','orders.id_order')
        ->leftJoin('staf', 'orders.order_by', '=', 'staf.nip')
        ->join('supplier', 'orders.id_supplier', '=', 'supplier.id_supplier')
        ->leftjoin('barang','list_order.kode_barang','=','barang.kode_barang')
        ->select('orders.*','supplier.nama_supplier','staf.nama_staf','list_order.*',DB::raw('COALESCE(barang.nama_barang, list_order.kode_barang ) AS nama_barang'));

        if(isset($request->supplier)){
            $data->where('orders.id_supplier',$request->supplier);
        }
        else if(isset($request->tgl_awal)){
            $data->where('orders.created_at','>=',$request->tgl_awal.'%');
        }
        else if(isset($request->tgl_akhir)){
            $data->where('orders.created_at','<=',$request->tgl_akhir.'%');
        }
        $result = $data->groupby('orders.id_order')->get();
        $res['data']=$result;
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        $pdf = PDF::loadview('laporan/export_pdf_pembelian', $res);
        return $pdf->download('laporan-pembelian-'.$date.'-pdf');
    }

    public function print_penjualan(Request $request){
        $data=Penjualan:: join('item_penjualan', 'transaksi.no_transaksi', '=', 'item_penjualan.no_transaksi')
        ->join('barang','item_penjualan.kode_barang','=','barang.kode_barang')
        ->leftJoin('staf', 'transaksi.nip', '=', 'staf.nip')
        ->select('transaksi.*','barang.nama_barang','staf.nama_staf','item_penjualan.jumlah')
        ->where('tgl_transaksi','like',decrypt($request->input('id')).'%')
        ->get();
        $res['data']=$data;
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        $pdf = PDF::loadview('laporan/export_pdf_penjualan', $res);
        return $pdf->download('laporan-penjualan-'.$date.'-pdf');
    }

    public function print_narkotika(Request $request){
        $data=Penjualan:: join('item_penjualan', 'transaksi.no_transaksi', '=', 'item_penjualan.no_transaksi')
        ->join('barang','item_penjualan.kode_barang','=','barang.kode_barang')
        ->join('tipe','barang.kode_tipe','=','tipe.kode_tipe')
        ->leftJoin('staf', 'transaksi.nip', '=', 'staf.nip')
        ->select('transaksi.*','barang.nama_barang','staf.nama_staf','item_penjualan.jumlah')
        ->where('barang.kode_barang','like',decrypt($request->input('id')).'%')
        ->get();
        // ->leftJoin(DB::raw('(SELECT * FROM history_barang where kode_barang="'.decrypt($request->input('id')).'" and jenis_history="barang_keluar" order by id_history ) AS history_barang'),
        // 'history_barang.kode_barang', '=', 'barang.kode_barang')
        $res['data']=$data;
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        $pdf = PDF::loadview('laporan/export_pdf_penjualan_narkotika', $res);
        return $pdf->download('laporan-penjualan-narkotika-'.$date.'-pdf');
    }

    public function print_narkotika_param(Request $request){
        $data=Penjualan:: join('item_penjualan', 'transaksi.no_transaksi', '=', 'item_penjualan.no_transaksi')
        ->join('barang','item_penjualan.kode_barang','=','barang.kode_barang')
        ->join('tipe','barang.kode_tipe','=','tipe.kode_tipe')
        ->leftJoin('staf', 'transaksi.nip', '=', 'staf.nip')
        ->where('tipe.nama_tipe','like','%Narkotika%')
            ->orwhere('tipe.nama_tipe','like','%Psikotropika%')
        ->select('transaksi.*','barang.nama_barang','staf.nama_staf','item_penjualan.jumlah');
          
        if(isset($request->nama_barang)){
            $data->where('barang.kode_barang','like',$request->nama_barang);
        }
        if(isset($request->bulan)){
            $data->whereMonth('transaksi.tgl_transaksi','=',$request->bulan);
        }
        if(isset($request->tahun)){
            $data->whereYear('transaksi.tgl_transaksi','=',$request->tahun);
        }
    
        // ->leftJoin(DB::raw('(SELECT * FROM history_barang where kode_barang="'.decrypt($request->input('id')).'" and jenis_history="barang_keluar" order by id_history ) AS history_barang'),
        // 'history_barang.kode_barang', '=', 'barang.kode_barang')
        $result=$data->get();
        $res['data']=$result;
        //dd($res);
       
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        $pdf = PDF::loadview('laporan/export_pdf_penjualan_narkotika', $res);
        return $pdf->download('laporan-penjualan-narkotika-'.$date.'-pdf');
    }

    public function print_penjualan_param(Request $request){
        $data=Penjualan:: join('item_penjualan', 'transaksi.no_transaksi', '=', 'item_penjualan.no_transaksi')
        ->join('barang','item_penjualan.kode_barang','=','barang.kode_barang')
        ->leftJoin('staf', 'transaksi.nip', '=', 'staf.nip')
        ->select('transaksi.*','barang.nama_barang','staf.nama_staf','item_penjualan.jumlah');

        if(isset($request->bulan)){
            $data->whereMonth('transaksi.tgl_transaksi','=',$request->bulan);
        }
        if(isset($request->tahun)){
            $data->whereYear('transaksi.tgl_transaksi','=',$request->tahun);
        }
        $res['data']=$data->get();
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        $pdf = PDF::loadview('laporan/export_pdf_penjualan', $res);
        return $pdf->download('laporan-penjualan-'.$date.'-pdf');
    }

    public function print_konsinyasi(Request $request){
        $data=Penjualan:: join('item_penjualan', 'transaksi.no_transaksi', '=', 'item_penjualan.no_transaksi')
        ->join('barang','item_penjualan.kode_barang','=','barang.kode_barang')
        ->join('tipe','barang.kode_tipe','=','tipe.kode_tipe')
        ->join('history_barang','transaksi.no_transaksi','=','history_barang.id_referensi')
        ->leftJoin('staf', 'transaksi.nip', '=', 'staf.nip')
        ->select('transaksi.*','barang.nama_barang','history_barang.sisa','staf.nama_staf','item_penjualan.jumlah')
        ->where('barang.kode_barang','like',decrypt($request->input('id')).'%');
        
        $res['data']=$data->get();
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        $pdf = PDF::loadview('laporan/export_pdf_konsinyasi', $res);
        return $pdf->download('laporan-konsinyasi-'.$date.'-pdf');
    }

    public function print_konsinyasi_param(Request $request){
        $data=Penjualan:: join('item_penjualan', 'transaksi.no_transaksi', '=', 'item_penjualan.no_transaksi')
        ->join('barang','item_penjualan.kode_barang','=','barang.kode_barang')
        ->join('tipe','barang.kode_tipe','=','tipe.kode_tipe')
        ->join('history_barang','transaksi.no_transaksi','=','history_barang.id_referensi')
        ->leftJoin('staf', 'transaksi.nip', '=', 'staf.nip')
        ->select('transaksi.*','barang.nama_barang','history_barang.sisa','staf.nama_staf','item_penjualan.jumlah');

        if(isset($request->nama_barang)){
            $data->where('barang.kode_barang','like',$request->nama_barang);
        }
        if(isset($request->bulan)){
            $data->whereMonth('transaksi.tgl_transaksi','=',$request->bulan);
        }
        if(isset($request->tahun)){
            $data->whereYear('transaksi.tgl_transaksi','=',$request->tahun);
        }
        $data->whereNotNull('barang.konsinyasi');
        $res['data']=$data->get();
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        $pdf = PDF::loadview('laporan/export_pdf_konsinyasi', $res);
        return $pdf->download('laporan-konsinyasi-'.$date.'-pdf');
    }

    public function print_bpjs(Request $request){
        $data=Penjualan:: join('item_penjualan', 'transaksi.no_transaksi', '=', 'item_penjualan.no_transaksi')
        ->join('barang','item_penjualan.kode_barang','=','barang.kode_barang')
        ->leftJoin('staf', 'transaksi.nip', '=', 'staf.nip')
        ->select('transaksi.*','barang.nama_barang','staf.nama_staf','item_penjualan.jumlah')
        ->where('transaksi.no_transaksi','like',decrypt($request->input('id')).'%')
        ->whereNotNull('bpjs')
        ->get();
        $res['data']=$data;
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        $pdf = PDF::loadview('laporan/export_pdf_bpjs', $res);
        return $pdf->download('laporan-bpjs-'.$date.'-pdf');
    }

    public function print_bpjs_param(Request $request){
        $data=Penjualan:: join('item_penjualan', 'transaksi.no_transaksi', '=', 'item_penjualan.no_transaksi')
        ->join('barang','item_penjualan.kode_barang','=','barang.kode_barang')
        ->leftJoin('staf', 'transaksi.nip', '=', 'staf.nip')
        ->select('transaksi.*','barang.nama_barang','staf.nama_staf','item_penjualan.jumlah')
        ->whereNotNull('bpjs');
        if(isset($request->bulan)){
            $data->whereMonth('transaksi.tgl_transaksi','=',$request->bulan);
        }
        if(isset($request->tahun)){
            $data->whereYear('transaksi.tgl_transaksi','=',$request->tahun);
        }
        $res['data']=$data->get();
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        $pdf = PDF::loadview('laporan/export_pdf_bpjs', $res);
        return $pdf->download('laporan-bpjs-'.$date.'-pdf');
    }

    public function print_laba(Request $request){
        $tanggal = substr(decrypt($request->input('id')),0,7);
        $data = DB::select("SELECT
        COALESCE(labarugi.penjualan_barang,0) as penjualan_barang ,
        COALESCE(labarugi.penjualan_obat,0) as penjualan_obat ,
        COALESCE(labarugi.piutang_obat,0) as piutang_obat ,
        COALESCE(labarugi.pendapatan_jasa_lain,0) as pendapatan_jasa_lain,
        COALESCE(labarugi.pendapatan_jasa_dokter,0) as pendapatan_jasa_dokter,
        COALESCE(labarugi.pembelian_barang,0) as pembelian_barang,
        COALESCE(labarugi.pembelian_obat,0) as pembelian_obat,
        COALESCE(labarugi.barang_hilang,0) as barang_hilang,
        COALESCE(labarugi.obat_hilang,0) as obat_hilang,
        COALESCE(labarugi.pengembalian_barang,0) as pengembalian_barang
        FROM
        (
        SELECT
        ( SELECT
        sum(b.jumlah*c.harga_jual) as totalBarang

        FROM
        transaksi a
        JOIN item_penjualan b ON b.no_transaksi = a.no_transaksi
        JOIN (
        SELECT
        barang.*,
        harga.harga_jual
        FROM
        barang
        JOIN tipe ON barang.kode_tipe = tipe.kode_tipe
        JOIN set_harga ON set_harga.kode_barang = barang.kode_barang
        JOIN harga ON harga.id_harga = set_harga.id_harga
        WHERE
        tipe.jenis_barang = 'barang_lain'
        ) c ON b.kode_barang = c.kode_barang
        JOIN tipe d ON d.kode_tipe = c.kode_tipe
        WHERE
        a.tgl_transaksi LIKE '".$tanggal."%'
        AND ( a.bpjs IS NULL OR a.bpjs = 0 ) ) AS penjualan_barang,
        ( SELECT
        sum(b.jumlah*c.harga_jual) as totalBarang

        FROM
        transaksi a
        JOIN item_penjualan b ON b.no_transaksi = a.no_transaksi
        JOIN (
        SELECT
        barang.*,
        harga.harga_jual
        FROM
        barang
        JOIN tipe ON barang.kode_tipe = tipe.kode_tipe
        JOIN set_harga ON set_harga.kode_barang = barang.kode_barang
        JOIN harga ON harga.id_harga = set_harga.id_harga
        WHERE
        tipe.jenis_barang = 'obat'
        ) c ON b.kode_barang = c.kode_barang
        JOIN tipe d ON d.kode_tipe = c.kode_tipe
        WHERE
        a.tgl_transaksi LIKE '".$tanggal."%'
        AND ( a.bpjs IS NULL OR a.bpjs = 0 ) ) AS penjualan_obat,
        ( SELECT sum( total ) FROM transaksi WHERE tgl_transaksi LIKE '".$tanggal."%' AND bpjs IS NOT NULL AND bpjs != 0
        ) AS piutang_obat,
        ( SELECT sum( biaya ) FROM jasa_lain WHERE created_at LIKE '".$tanggal."%' ) AS pendapatan_jasa_lain,
        (
        SELECT
        sum( a.biaya )
        FROM
        tindakan a
        JOIN list_tindakan b ON a.id_tindakan = b.id_tindakan
        WHERE
        b.created_at LIKE '".$tanggal."%'
        ) AS pendapatan_jasa_dokter,
        ( SELECT sum( b.total ) FROM orders a
        JOIN list_order b ON b.id_order = a.id_order
        JOIN barang c ON b.kode_barang = c.kode_barang
        JOIN tipe d ON d.kode_tipe = c.kode_tipe
        WHERE a.tgl_order LIKE '".$tanggal."%' AND d.jenis_barang = 'barang_lain' ) AS pembelian_barang,
        ( SELECT sum( b.total ) FROM orders a
        JOIN list_order b ON b.id_order = a.id_order
        JOIN barang c ON b.kode_barang = c.kode_barang
        JOIN tipe d ON d.kode_tipe = c.kode_tipe
        WHERE a.tgl_order LIKE '".$tanggal."%' AND d.jenis_barang = 'obat' ) AS pembelian_obat,
        (
        SELECT
        ( sum( a.jml_keluar ) * d.harga_jual ) AS pengembalian
        FROM
        history_barang a
        JOIN barang b ON a.kode_barang = b.kode_barang
        JOIN set_harga c on c.kode_barang=b.kode_barang
        JOIN harga d on d.id_harga = c.id_harga
        WHERE
        a.tgl_keluar LIKE '".$tanggal."%'
        AND a.jenis_history = 'retur_beli'
        ) AS pengembalian_barang,
        (
            SELECT
            sum( a.retur_nominal ) AS pengembalian_jual
            FROM
            retur_penjualan a
            WHERE
            a.tgl_retur LIKE '".$tanggal."%'
            ) AS pengembalian_barang_jual,
        ( SELECT sum( jml_keluar ) FROM history_barang WHERE tgl_keluar LIKE '".$tanggal."%'
        AND jenis_history = 'obat_hilang' ) AS barang_hilang,
        ( SELECT sum( jml_keluar ) * d.harga_jual FROM
        history_barang a
        JOIN barang b ON a.kode_barang = b.kode_barang
        JOIN set_harga c on c.kode_barang=b.kode_barang
        JOIN harga d on d.id_harga = c.id_harga
        WHERE a.tgl_keluar LIKE '".$tanggal."%'
        AND a.jenis_history = 'barang_hilang' ) AS obat_hilang
        FROM
        transaksi
        ) labarugi");
        $res['data']=$data;
        $exp_tgl=explode('-', substr(decrypt($request->input('id')),0,7));
        $tanggal = \Carbon\Carbon::createFromDate($exp_tgl[0], $exp_tgl[1], 1)->format('F Y');
        $res['tanggal']= $tanggal;
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        $pdf = PDF::loadview('laporan/export_pdf_laba', $res);
        return $pdf->download('laporan-laba-'.$date.'-pdf');
    }

    public function export_excel_penjualan(Request $request) 
    {
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        return Excel::download(new ExportPenjualan($request), 'Data_penjualan- '.$date.'.xlsx');
    }

    public function export_excel_penjualan_params(Request $request) 
    {
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        return Excel::download(new ExportPenjualanParams($request), 'Data_penjualan_params- '.$date.'.xlsx');
    }
    

    public function export_excel_pembelian(Request $request) 
    {
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        return Excel::download(new ExportPembelian($request), 'Data_pembelian- '.$date.'.xlsx');
    }

    public function export_excel_pembelian_params(Request $request) 
    {
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        return Excel::download(new ExportPembelianParams($request), 'Data_pembelian_parameter- '.$date.'.xlsx');
    }

    public function export_excel_laba(Request $request) 
    {
        $exp_tgl=explode('-', substr(decrypt($request->input('id')),0,7));
        $tanggal = \Carbon\Carbon::createFromDate($exp_tgl[0], $exp_tgl[1], 1)->format('F Y');
        
        return Excel::download(new ExportLaba($request), 'Data_laba_rugi- '.$tanggal.'.xlsx');
    }
    public function export_excel_konsinyasi(Request $request) 
    {
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        return Excel::download(new ExportKonsinyasi($request), 'Data_konsinyasi- '.$date.'.xlsx');
    }

    public function export_excel_bpjs(Request $request) 
    {
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        return Excel::download(new ExportBpjs($request), 'Data_bpjs- '.$date.'.xlsx');
    }

    public function export_excel_narkotika(Request $request) 
    {
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        return Excel::download(new ExportNarkotika($request), 'Data_narkotika- '.$date.'.xlsx');
    }

}
