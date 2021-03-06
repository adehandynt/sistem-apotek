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
use App\Models\notification;
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
        $penjualan=Penjualan::leftjoin(DB::raw('(SELECT no_transaksi, sum(retur_nominal) as retur_nominal FROM retur_penjualan GROUP BY no_transaksi) AS retur_penjualan'),
       'retur_penjualan.no_transaksi', '=', 'transaksi.no_transaksi')
       ->select(DB::raw('sum(transaksi.total) as penjualan'),DB::raw('coalesce(sum(retur_penjualan.retur_nominal),0) as retur'))
        // ->where('transaksi.tgl_transaksi','like', $date.'%')
        ->where(function ($query) use ($date) {
            $query->where('transaksi.tgl_transaksi','like', $date.'%')
                ->orWhere('transaksi.created_at','like', $date.'%')
                ->orWhere('transaksi.updated_at','like', $date.'%');
        })
        ->where(function ($query) {
            $query->where('transaksi.status_transaksi','=','lunas')
                ->orWhere('transaksi.status_transaksi','=',null);
        })
        ->get();
        $ret['penjualan']=$penjualan;

        $piutang = Penjualan::select('transaksi.*',DB::raw('coalesce(bank,bpjs,"cash") as pembayaran'))
        ->where(function ($query) {
            $query->where('status_transaksi','=','piutang');
        })
        ->get();

        $ret['piutang']=$piutang;


        $terjual=Penjualan::join('item_penjualan', 'transaksi.no_transaksi', '=', 'item_penjualan.no_transaksi')
        ->select(DB::raw('count(item_penjualan.id) as terjual'))
        ->where('tgl_transaksi','like', $date.'%')
        ->get();
        $ret['terjual']=$terjual;

        $pasien=RekamMedis::select(DB::raw('coalesce(count(distinct(id_rekam_medis)),0) as pasien'))
        ->where('tgl_rekam','like',$date.'%')
        //  ->groupBy('id_rekam_medis')
        ->get();
     
        $ret['pasien']=$pasien;
        
        $date = \Carbon\Carbon::now()->add(120, 'day')->timezone('Asia/Jakarta')->format('Y-m-d');
        $datenow = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
        // $kadaluwarsa = DB::select("SELECT
        // count(t.kode_barang) as kadaluwarsa,
        // t.tgl_exp
        // FROM
        // ( SELECT kode_barang, MAX( created_at ) AS MaxTime,created_at FROM stok GROUP BY kode_barang ) r
        // INNER JOIN stok t ON t.kode_barang = r.kode_barang 
        // AND t.created_at = r.MaxTime 
        // where t.tgl_exp < '".$date."' and t.tgl_exp > '".$datenow."'" );
        $kadaluwarsa = DB::select("SELECT
        count(t.kode_barang) as kadaluwarsa,
        t.tgl_exp
        FROM
        stok t
        where t.tgl_exp < '".$date."' and t.tgl_exp > '".$datenow."'" );
         $ret['kadaluwarsa']=$kadaluwarsa;

         $expiredlist =  DB::select("SELECT
         a.*,b.nama_barang
            FROM
            stok a
            join barang b 
            on a.kode_barang = b.kode_barang
            where a.tgl_exp < '".$date."' and a.tgl_exp > '".$datenow."'
            ORDER BY a.tgl_exp asc" );

            $ret['expiredlist']=$expiredlist;

         $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
         $produk = Penjualan::select('transaksi.*',DB::raw('coalesce(bank,bpjs,"cash") as pembayaran'))
         ->where('tgl_transaksi','like', $date.'%')
         ->get();

         $ret['produk']=$produk;
         $terlaris = Obat::join(DB::raw('(SELECT
         t.kode_barang,
         t.sisa 
            FROM
         ( SELECT kode_barang, MAX( created_at ) AS MaxTime, created_at FROM history_barang GROUP BY kode_barang ) r
         INNER JOIN history_barang t ON t.kode_barang = r.kode_barang 
         AND t.created_at = r.MaxTime) AS history_barang'),
        'history_barang.kode_barang', '=', 'barang.kode_barang')
         ->select('history_barang.sisa','barang.*')
         ->groupBy('barang.kode_barang')
         ->orderBy('sisa','DESC')
         ->get();
         $ret['terlaris']=$terlaris;


         $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
         $year=$date->format('Y');
         $lastYear=$date->format('Y');
         $lastMonth=$date->subMonth()->format('m');
        
         $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
         $thisMonth=$date->format('m');
         if($thisMonth=='01'){
            $lastYear=$date->subYears()->format('Y');
        }

         $pendapatan_lalu = Penjualan::leftjoin(DB::raw('(SELECT no_transaksi, sum(retur_nominal) as retur_nominal FROM retur_penjualan GROUP BY no_transaksi) AS retur_penjualan'),
         'retur_penjualan.no_transaksi', '=', 'transaksi.no_transaksi')
         ->select(DB::raw('MONTHNAME(transaksi.tgl_transaksi) as date'),DB::raw('coalesce(SUM(transaksi.total),0)-coalesce(sum(retur_penjualan.retur_nominal),0) as total'))
         ->where('transaksi.tgl_transaksi','like',$lastYear.'-'.$lastMonth.'%')
         ->where(function ($query) {
            $query->where('transaksi.status_transaksi','=','lunas')
                ->orWhere('transaksi.status_transaksi','=',null);
        })

         
         ->groupBy('date')
         ->get();

         $pendapatan_ini = Penjualan:: leftjoin(DB::raw('(SELECT no_transaksi, sum(retur_nominal) as retur_nominal FROM retur_penjualan GROUP BY no_transaksi) AS retur_penjualan'),
         'retur_penjualan.no_transaksi', '=', 'transaksi.no_transaksi')
         ->select(DB::raw('MONTHNAME(transaksi.tgl_transaksi) as date'),DB::raw('coalesce(SUM(transaksi.total),0)-coalesce(sum(retur_penjualan.retur_nominal),0) as total'))
         ->where('transaksi.tgl_transaksi','like',$year.'-'.$thisMonth.'%')
         ->where(function ($query) {
            $query->where('transaksi.status_transaksi','=','lunas')
                ->orWhere('transaksi.status_transaksi','=',null);
        })
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

    $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
    $pendapatanStaf = Penjualan::leftjoin('retur_penjualan', 'retur_penjualan.no_transaksi', '=', 'transaksi.no_transaksi')
    ->join('staf', 'staf.nip', '=', 'transaksi.nip')
    ->where('transaksi.tgl_transaksi','like', $date.'%')
    ->select('staf.*',DB::raw('sum(transaksi.total) as pendapatan'),DB::raw('coalesce(sum(retur_penjualan.retur_nominal),0) as retur'))
    ->groupBy('transaksi.nip')
    ->get();
 
         $ret['lalu']=$pendapatan_lalu;
         $ret['sekarang']=$pendapatan_ini;
         $ret['rata']=$rata[0]->total;
         $ret['pendapatan_staf']=$pendapatanStaf;
        // dd($ret);
        return view('dashboard/dashboard',$ret);
    }
    public function GraphData()
    {
        $terjual= Penjualan::
        leftjoin(DB::raw('(SELECT no_transaksi, sum(retur_nominal) as retur_nominal FROM retur_penjualan GROUP BY no_transaksi) AS retur_penjualan'),
       'retur_penjualan.no_transaksi', '=', 'transaksi.no_transaksi')
       ->select('transaksi.*',DB::raw('MONTHNAME(transaksi.tgl_transaksi) as date'),DB::raw('MONTH(transaksi.tgl_transaksi) as dateAngka'),DB::raw('SUM(transaksi.total) - coalesce(sum(retur_penjualan.retur_nominal),0) as total'))
        ->where(function ($query) {
            $query->where('status_transaksi','=','lunas')
                ->orWhere('status_transaksi','=',null);
        })
        
            ->groupBy('date')
            ->orderBy('dateAngka')
            ->get()
            ->take(7);
                
            $arr_label = [];
            $val_data = [];
            $arr_val=[];
            foreach($terjual as $key =>$val){
                $name = $val->date;
               

                    array_push($arr_label,$val->date);
                    array_push($arr_val,$val->total);
               
                }
                $val_data[]=[
                  'name' => 'Pendapatan',
                  'type'=>'line',
                  'data' => $arr_val
                ];

            $ret['labels']=array_values(array_unique($arr_label));
            $ret['series']=$val_data; 
            //dd($ret);
        return json_encode($ret);
    }

    public function set_lunas(Request $request){
        $transaksi = Penjualan::where('no_transaksi', $request->id)
            ->firstOrFail();
        $transaksi->status_transaksi='lunas';
        $transaksi->save();
        if($transaksi->save()){
            return 'success';
        }else{
            return 'error';
        }
    }

    public function hapus_transaksi(Request $request){
        
        DB::beginTransaction();   
        try { 
            $transaksi = Penjualan::where('no_transaksi', $request->id)
            ->first();
        $transaksi->delete();
        $penjualan = ItemPenjualan::where('no_transaksi', $request->id)
            ->first();
        $penjualan->delete();
        $history = HistoryBarang::where('id_referensi', $request->id)
            ->first();
        $history->delete();
      
            DB::commit();
            return 'success';
       
      
        }catch (Exception $e) {     
            DB::rollback();
            return 'error';
          }
       
    }

    public function pendapatan_staf(Request $request){
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
        $pendapatan = Penjualan::join('staf', 'staf.nip', '=', 'transaksi.nip')
        ->where('tgl_transaksi','like', $date.'%')
        ->select('transaksi.*',DB::raw('sum(transaksi.total) as pendapatan'))
        ->groupBy('staf.nip');

    }

    public function notif_list(Request $request){
        $data = notification::
        where('status','=',0)
        ->orderBy('id','desc')
        ->get()->take(10);
        return json_encode($data);
    }
}
