<?php

namespace App\Http\Controllers;

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
use App\Models\Pasien;
use Validator;
use Hash;
use DB;
use PDF;
use Auth;
use Session;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $position=Staf::where('nip',Auth::user()->nip)->get();
        $request->session()->put('position',$position[0]->posisi);
        if($position[0]->posisi=='apoteker'){
            return redirect('/pembelian');
        }elseif($position[0]->posisi=='dokter'){
            return redirect('/data-pasien');
        }elseif($position[0]->posisi=='kasir'){
            return redirect('/penjualan');
        }
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
        $penjualan=Penjualan::select(DB::raw('sum(total) as penjualan'))
        ->where('tgl_transaksi','like', $date.'%')
        ->get();
        $ret['penjualan']=$penjualan;

        $terjual=Penjualan::join('item_penjualan', 'transaksi.no_transaksi', '=', 'item_penjualan.no_transaksi')
        ->select(DB::raw('count(item_penjualan.id) as terjual'))
        ->where('tgl_transaksi','like', $date.'%')
        ->get();
        $ret['terjual']=$terjual;

        $pasien=RekamMedis::select(DB::raw('count(id) as pasien'))
        ->where('tgl_rekam','like', $date.'%')
        ->get();
        $ret['pasien']=$pasien;
        
        $date = \Carbon\Carbon::now()->add(120, 'day')->timezone('Asia/Jakarta')->format('Y-m-d');
        $datenow = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
        $kadaluwarsa = DB::select("SELECT
        count(t.kode_barang) as kadaluwarsa,
        t.tgl_exp
        FROM
        ( SELECT kode_barang, MAX( created_at ) AS MaxTime,created_at FROM stok GROUP BY kode_barang ) r
        INNER JOIN stok t ON t.kode_barang = r.kode_barang 
        AND t.created_at = r.MaxTime 
        where t.tgl_exp < '".$date."' and t.tgl_exp > '".$datenow."'" );
         $ret['kadaluwarsa']=$kadaluwarsa;

         $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
         $produk = Penjualan::select('transaksi.*',DB::raw('coalesce(bank,bpjs,"cash") as pembayaran'))
         ->where('tgl_transaksi','like', $date.'%')
         ->get();

         $ret['produk']=$produk;

         $terlaris = ItemPenjualan::join('barang', 'item_penjualan.kode_barang', '=', 'barang.kode_barang')
         ->join('tipe', 'tipe.kode_tipe', '=', 'barang.kode_tipe')
         ->join('set_harga', 'barang.kode_barang', '=', 'set_harga.kode_barang')
         ->join('harga', 'set_harga.id_harga', '=', 'harga.id_harga')
         ->join(DB::raw('(SELECT
         t.kode_barang,
         t.sisa 
            FROM
         ( SELECT kode_barang, MAX( created_at ) AS MaxTime, created_at FROM history_barang GROUP BY kode_barang ) r
         INNER JOIN history_barang t ON t.kode_barang = r.kode_barang 
         AND t.created_at = r.MaxTime) AS history_barang'),
        'history_barang.kode_barang', '=', 'barang.kode_barang')
         ->select('tipe.nama_tipe','history_barang.sisa','harga.harga_jual','barang.*',DB::raw('sum(item_penjualan.jumlah) as jumlah_produk'))
         ->groupBy('item_penjualan.kode_barang')
         ->orderBy('jumlah_produk','DESC')
         ->get();

         $ret['terlaris']=$terlaris;

         $date= \Carbon\Carbon::now();
         $year=$date->format('Y');
         $lastMonth=$date->subMonth()->format('m');
         $date= \Carbon\Carbon::now();
         $thisMonth=$date->format('m');

         $pendapatan_lalu = Penjualan::select(DB::raw('MONTHNAME(transaksi.tgl_transaksi) as date'),DB::raw('coalesce(SUM(transaksi.total),0) as total'))
         ->where('tgl_transaksi','like',$year.'-'.$lastMonth.'%')
         ->groupBy('date')
         ->get();

         $pendapatan_ini = Penjualan::select(DB::raw('MONTHNAME(transaksi.tgl_transaksi) as date'),DB::raw('coalesce(SUM(transaksi.total),0) as total'))
         ->where('tgl_transaksi','like',$year.'-'.$thisMonth.'%')
         ->groupBy('date')
         ->get();

         $dateBefore = \Carbon\Carbon::now()->subDays(30, 'day')->timezone('Asia/Jakarta')->format('Y-m-d');
         $date= \Carbon\Carbon::now();
        //  $rata = Penjualan::where('tgl_transaksi','>', $dateBefore)
        //  ->where('tgl_transaksi','<', $date)
        //  ->select(DB::raw('coalesce((SUM(total) / count(id)),0) as total'))
        //  ->get();
        $rata =DB::select('SELECT
        (
        sum( x.total )/ count( x.total )) as total
    FROM
        (
        SELECT
            sum( total ) AS total,
            DATE_FORMAT( tgl_transaksi, "%Y-%m" ) as tgl
        FROM
            transaksi 
    GROUP BY
        DATE_FORMAT( tgl_transaksi, "%Y-%m" )
        having
			tgl <
	DATE_FORMAT( NOW(), "%Y-%m" ) )x');
 
         $ret['lalu']=$pendapatan_lalu;
         $ret['sekarang']=$pendapatan_ini;
         $ret['rata']=$rata[0]->total;
        // dd($ret);
        return view('dashboard/dashboard',$ret);
    }
    public function GraphData()
    {
        $terjual= Penjualan::select('transaksi.*',DB::raw('MONTHNAME(transaksi.tgl_transaksi) as date'),DB::raw('SUM(transaksi.total) as total'))
            ->groupBy('date')
            ->get()
            ->take(7);
                
            $arr_label = [];
            $val_data = [];
            foreach($terjual as $key =>$val){
                $name = $val->date;
                $arr_val=[];

                    array_push($arr_label,$val->date);
                    array_push($arr_val,$val->total);
               
                $val_data[]=[
                  'name' => $name,
                  'type'=>'line',
                  'data' => $arr_val
                ];
            }

            $ret['labels']=array_values(array_unique($arr_label));
            $ret['series']=$val_data; 
           // dd($terjual);
        return json_encode($ret);
    }
}
