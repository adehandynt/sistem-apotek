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
use App\Models\ListJasa;
use App\Models\Margin;
use Validator;
use Hash;
use DB;
use Auth;
use Session;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PenjualanController extends Controller
{
    public function v_penjualan()
    {
        $res['jasa']=ListJasa::orderby('created_at', 'DESC')->get();
        $res['rekam']=RekamMedis::Join('resep', 'rekam_medis.id_rekam_medis', '=', 'resep.id_rekam_medis')
        ->Join('pasien', 'rekam_medis.medical_record_id', '=', 'pasien.medical_record_id')
        ->groupBy('rekam_medis.id_rekam_medis')
        ->where('resep.status_resep',0)
        ->select('rekam_medis.id_rekam_medis','rekam_medis.tgl_rekam','resep.*','pasien.nama_pasien')
        ->orderBy('rekam_medis.id_rekam_medis','desc')
        ->get();
        $res['staf']=Staf::where('nip','=',Auth::user()->nip)->select('nama_staf')->get();
        $res['obat']= Obat::Join('tipe', 'barang.kode_tipe', '=', 'tipe.kode_tipe')
        ->leftJoin(DB::raw('(SELECT
        t.kode_barang,
        min(t.sisa) as sisa
           FROM
        ( SELECT kode_barang, MAX( created_at ) AS MaxTime, created_at FROM history_barang GROUP BY kode_barang ) r
        INNER JOIN history_barang t ON t.kode_barang = r.kode_barang 
        AND t.created_at = r.MaxTime GROUP BY t.kode_barang) AS history_barang'),
       'history_barang.kode_barang', '=', 'barang.kode_barang')
        ->where('barang.kode_barang','!=',"")->where('tipe.jenis_barang','obat')
        ->select('barang.*',DB::raw('coalesce(history_barang.sisa,0) as sisa'))
        ->get();
        $res['barang']= Obat::Join('tipe', 'barang.kode_tipe', '=', 'tipe.kode_tipe')
        ->leftJoin(DB::raw('(SELECT
        t.kode_barang,
        min(t.sisa) as sisa
           FROM
        ( SELECT kode_barang, MAX( created_at ) AS MaxTime, created_at FROM history_barang GROUP BY kode_barang ) r
        INNER JOIN history_barang t ON t.kode_barang = r.kode_barang 
        AND t.created_at = r.MaxTime GROUP BY t.kode_barang) AS history_barang'),
       'history_barang.kode_barang', '=', 'barang.kode_barang')
        ->where('barang.kode_barang','!=',"")
        ->where('tipe.jenis_barang','barang_lain')
        ->select('barang.*',DB::raw('coalesce(history_barang.sisa,0) as sisa'))
        ->get();
        $res['margin'] = Margin::get();
        return view('penjualan/penjualan',$res);
    }
    public function v_list_penjualan()
    {
        $data = Penjualan::leftJoin('stok', 'barang.kode_barang', '=', 'stok.kode_barang')
            ->Join('set_harga', 'barang.kode_barang', '=', 'set_harga.kode_barang')
            ->Join('harga', 'set_harga.id_harga', '=', 'harga.id_harga')
            ->Join('tipe', 'barang.kode_tipe', '=', 'tipe.kode_tipe')
            ->Join('satuan', 'barang.kode_satuan', '=', 'satuan.kode_satuan')
            ->select('barang.*','harga.diskon','harga.harga_jual','harga.harga_beli','harga.harga_eceran','satuan.satuan','satuan.kode_satuan','tipe.nama_tipe','tipe.kode_tipe')
            ->get();
        //        return view('data-master/tipe', $res);
        for($i=0;$i<count($data);$i++){
            $data[$i]->action='<a href="javascript:void(0);" data-id="'.$data[$i]->id.'"
            class="btn-delete action-icon"> <i
                class="mdi mdi-delete"></i></a>';
        }
        return json_encode($data);
    }
    public function get_produk(Request $request)
    {
        $data = Obat::where('barang.kode_barang',$request->kode)
        ->leftJoin('stok', 'barang.kode_barang', '=', 'stok.kode_barang')
        ->leftJoin(DB::raw('(SELECT
                t.kode_barang,
                min(t.sisa) as sisa
                   FROM
                ( SELECT kode_barang, MAX( created_at ) AS MaxTime, created_at FROM history_barang GROUP BY kode_barang ) r
                INNER JOIN history_barang t ON t.kode_barang = r.kode_barang 
                AND t.created_at = r.MaxTime GROUP BY t.kode_barang) AS history_barang'),
               'history_barang.kode_barang', '=', 'barang.kode_barang')
        ->Join('set_harga', 'barang.kode_barang', '=', 'set_harga.kode_barang')
        ->Join('harga', 'set_harga.id_harga', '=', 'harga.id_harga')
        ->Join('tipe', 'barang.kode_tipe', '=', 'tipe.kode_tipe')
        ->Join('satuan', 'barang.kode_satuan', '=', 'satuan.kode_satuan')
        ->select('barang.*','harga.diskon','harga.harga_jual','harga.harga_beli','harga.harga_eceran','harga.margin','satuan.satuan','satuan.kode_satuan','tipe.nama_tipe','tipe.kode_tipe',DB::raw('COALESCE(COALESCE(history_barang.sisa, stok.jml_masuk ),0) AS sisa'))
        ->where('sisa','!=','0')
        ->where('jenis_barang','=','obat')
        ->get();
        //        return view('data-master/tipe', $res);
        for($i=0;$i<count($data);$i++){
            $data[$i]->action='<a href="javascript:void(0);" data-id="'.$data[$i]->id.'"
            class="btn-delete action-icon"> <i
                class="mdi mdi-delete"></i></a>';
        }
        return json_encode($data);
    }

    public function get_produk_other(Request $request)
    {
        $data = Obat::where('barang.kode_barang',$request->kode)
        ->leftJoin('stok', 'barang.kode_barang', '=', 'stok.kode_barang')
        ->leftJoin(DB::raw('(SELECT
                t.kode_barang,
                min(t.sisa) as sisa
                   FROM
                ( SELECT kode_barang, MAX( created_at ) AS MaxTime, created_at FROM history_barang GROUP BY kode_barang ) r
                INNER JOIN history_barang t ON t.kode_barang = r.kode_barang 
                AND t.created_at = r.MaxTime GROUP BY t.kode_barang) AS history_barang'),
               'history_barang.kode_barang', '=', 'barang.kode_barang')
        ->Join('set_harga', 'barang.kode_barang', '=', 'set_harga.kode_barang')
        ->Join('harga', 'set_harga.id_harga', '=', 'harga.id_harga')
        ->Join('tipe', 'barang.kode_tipe', '=', 'tipe.kode_tipe')
        ->Join('satuan', 'barang.kode_satuan', '=', 'satuan.kode_satuan')
        ->select('barang.*','harga.diskon','harga.harga_jual','harga.harga_beli','harga.harga_eceran','harga.margin','satuan.satuan','satuan.kode_satuan','tipe.nama_tipe','tipe.kode_tipe',DB::raw('COALESCE(COALESCE(history_barang.sisa, stok.jml_masuk ),0) AS sisa'))
        ->where('sisa','!=','0')
        ->where('jenis_barang','!=','obat')
        ->get();
        //        return view('data-master/tipe', $res);
        for($i=0;$i<count($data);$i++){
            $data[$i]->action='<a href="javascript:void(0);" data-id="'.$data[$i]->id.'"
            class="btn-delete action-icon"> <i
                class="mdi mdi-delete"></i></a>';
        }
        return json_encode($data);
    }
    public function add_penjualan(Request $request)
    {
        $rules = [
            'satuan'              => 'required|string',
            'akronim'              => 'required'
        ];

        $messages = [
            'satuan.required'              => 'Nama wajib diisi',
            'akronim.required'       => 'Akronim wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return json_encode($validator);
        }

        $id = IdGenerator::generate(['table' => 'satuan','field'=>'kode_penjualan', 'length' => 8, 'prefix' =>'STN-']);
        $list = Penjualan::updateOrCreate(['kode_penjualan' => $id], [
            'satuan' => $request->satuan,
            'akronim' =>  $request->akronim,
        ]);
        $simpan = $list->save();

        if ($simpan) {
            Session::flash('success', 'Input berhasil! Silahkan periksa data terbaru');
            return true;
        } else {
            Session::flash('errors', ['' => 'Input gagal! Silahkan ulangi kembali']);
            return false;
        }
    }

    function list_penjualan(Request $request)
    {
        $res['data'] = Penjualan::orderby('created_at', 'DESC')
            ->get();
        return json_encode($res['data']);
    }

    function edit_penjualan(Request $request)
    {
        $satuan = Penjualan::where('id', $request->id)
            ->firstOrFail();

        return json_encode($satuan);
    }

    function update_penjualan(Request $request)
    {
        $rules = [
            'satuan'              => 'required|string',
            'akronim'              => 'required'
        ];

        $messages = [
            'satuan.required'              => 'Nama wajib diisi',
            'akronim.required'       => 'Akronim wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return json_encode($validator);
        }

        $satuan = Penjualan::findOrFail($request->id);
        $satuan->satuan = $request->satuan;
        $satuan->akronim = $request->akronim;
        $simpan = $satuan->save();

        if ($simpan) {
            Session::flash('success', 'Update berhasil! Silahkan periksa data terbaru');
            return true;
        } else {
            Session::flash('errors', ['' => 'Update gagal! Silahkan ulangi kembali']);
            return false;
        }
    }

    function delete_penjualan(Request $request){
        $list = Penjualan::findOrFail($request->id);
        $simpan = $list->delete();
        if ($simpan) {
            Session::flash('success', 'Hapus berhasil! Silahkan periksa data terbaru');
            return true;
        } else {
            Session::flash('errors', ['' => 'Hapus gagal! Silahkan ulangi kembali']);
            return false;
        }
    }

    public function v_retur_penjualan()
    {
        return view('penjualan/retur-penjualan');
    }

    public function list_transaksi(){
        $data = Penjualan::Join('staf', 'transaksi.nip', '=', 'staf.nip')
        ->select('transaksi.*','staf.nama_staf')
        ->orderBy('transaksi.created_at','DESC')
        ->get();
    //        return view('data-master/tipe', $res);
    for($i=0;$i<count($data);$i++){
        $data[$i]->action='<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#custom-modal-retur" data-id="' . $data[$i]->no_transaksi . '"
        class="btn-detail action-icon"> <i
            class="mdi mdi-eye"></i></a>';
    }
    return json_encode($data);
    }

    public function list_produk(Request $request){
        $data = ItemPenjualan::Join('transaksi', 'item_penjualan.no_transaksi', '=', 'transaksi.no_transaksi')
        ->Join('barang', 'item_penjualan.kode_barang', '=', 'barang.kode_barang')
        ->Join('satuan', 'barang.kode_satuan', '=', 'satuan.kode_satuan')
        ->leftJoin('retur_penjualan', 'transaksi.no_transaksi', '=', 'retur_penjualan.no_transaksi')
        ->where('transaksi.no_transaksi',$request->id)
        ->select('item_penjualan.*','barang.kode_barang','barang.nama_barang','satuan.satuan','retur_penjualan.tgl_retur',DB::raw('(select count(id_retur_jual) from retur_penjualan where no_transaksi = "'.$request->id.'") as jml_retur'))
        ->get();
    //        return view('data-master/tipe', $res);
    for($i=0;$i<count($data);$i++){
        $data[$i]->action='<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#custom-modal-retur-item" data-id="' . $data[$i]->id_item . '"
        class="btn-detail-item action-icon"> <i
            class="mdi mdi-cash-refund"></i></a>';
    }
    return json_encode($data);
    }

    public function detail_order(Request $request){
        $data = ItemPenjualan::Join('transaksi', 'item_penjualan.no_transaksi', '=', 'transaksi.no_transaksi')
        ->Join('barang', 'item_penjualan.kode_barang', '=', 'barang.kode_barang')
        ->Join('satuan', 'barang.kode_satuan', '=', 'satuan.kode_satuan')
        ->leftJoin('retur_penjualan', 'transaksi.no_transaksi', '=', 'retur_penjualan.no_transaksi')
        ->where('item_penjualan.id_item',$request->id)
        ->select('item_penjualan.*','barang.kode_barang','barang.nama_barang','satuan.satuan','retur_penjualan.tgl_retur')
        ->get();
    return json_encode($data);
    }

    public function add_retur(Request $request){
        $id = IdGenerator::generate(['table' => 'retur_penjualan','field'=>'id_retur_jual', 'length' => 8, 'prefix' =>'RTJ-']);
        $item = new ReturJual;
        $item->id_retur_jual=$id;
        $item->no_transaksi=$request->no_transaksi;
        $item->kode_barang=$request->kode_barang;
        $item->jumlah=$request->jml_retur;
        $item->tgl_retur= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        $item->retur_nominal=$request->nominal_retur;
        $item->deskripsi=$request->deskripsi;
        if($item->save()){
            $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
            $id_history = IdGenerator::generate(['table' => 'history_barang','field'=>'id_history', 'length' => 15, 'prefix' =>'HIS-'. $year . '-']);
            $data = HistoryBarang::where('kode_barang', '=', $request->kode_barang)
                    ->orderBy('id_history', 'desc')
                    ->take(1)
                    ->get();

                $sisa = $data[0]->sisa==0||null? $data[0]->jml_akumulasi:$data[0]->sisa;
                $history = new HistoryBarang;
                $history->id_history=$id_history;
                $history->kode_barang=$request->kode_barang;
                $history->tgl_keluar=\Carbon\Carbon::now()->timezone('Asia/Jakarta');
                $history->jml_keluar=$request->jml_retur;
                $history->jenis_history='retur_jual';
                $history->id_referensi=$id;
                $history->pic=Auth::user()->nip;
                $history->sisa = $sisa + $request->jml_retur;
                $history->save();
            return true;
        }else{
            return false;
        }

    }

}
