<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\Order;
use App\Models\Satuan;
use App\Models\Tipe;
use App\Models\Obat;
use App\Models\ListItem;
use App\Models\Pasien;
use App\Models\Penyakit;
use App\Models\RekamMedis;
use App\Models\ListPenyakit;
use App\Models\ListTindakan;
use App\Models\Resep;
use App\Models\Tindakan;
use App\Models\ListJasa;
use App\Models\AlatJasa;
use Validator;
use Hash;
use Session;
use DB;
use Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class JasaController extends Controller
{
    public function v_jasa()
    {
        $res['obat'] =  Obat::Join('tipe', 'barang.kode_tipe', '=', 'tipe.kode_tipe')
        ->Join('satuan', 'barang.kode_satuan', '=', 'satuan.kode_satuan')
        ->Join('stok', 'barang.kode_barang', '=', 'stok.kode_barang')
        ->leftJoin(DB::raw('(SELECT * FROM barang_keluar order by created_at desc limit 1) AS barang_keluar'),
        'barang_keluar.stock_id', '=', 'stok.stock_id')
        ->select('barang.*','stok.tgl_exp','barang_keluar.sisa','satuan.satuan','satuan.kode_satuan','tipe.nama_tipe','tipe.kode_tipe')
        ->get();
        
        return view('data-master/jasa',$res);
    }

    public function v_list_jasa()
    {
        $data = ListJasa::orderby('created_at', 'DESC')->get();
        for($i=0;$i<count($data);$i++){
            $data[$i]->setelah=$data[$i]->harga-($data[$i]->harga*($data[$i]->diskon_jasa/100));
            $data[$i]->action=' <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#custom-modal-edit" data-id="'.$data[$i]->id_list_jasa.'"
            class="btn-update action-icon"> <i
                class="mdi mdi-square-edit-outline"></i></a><a href="javascript:void(0);" data-id="'.$data[$i]->id_list_jasa.'"
                class="btn-delete action-icon"> <i
                    class="mdi mdi-delete"></i></a>';
        }
        return json_encode($data);
    }

    
    public function add_jasa(Request $request){
        $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
        $id = IdGenerator::generate(['table' => 'list_jasa','field'=>'id_list_jasa', 'length' => 15, 'prefix' =>'LJS-'. $year . '-']);
        $jasa=new ListJasa;
        $jasa->id_list_jasa=$id;
        $jasa->nama=$request->nama_jasa;
        $jasa->diskon_jasa=$request->diskon_jasa;
        $jasa->harga=$request->harga_jasa;

        if(!$jasa->save()){
            return false;
        }else{
            $id_list_alat = IdGenerator::generate(['table' => 'alat_jasa','field'=>'id_alat_jasa', 'length' => 15, 'prefix' =>'ALT-'. $year . '-']);
            foreach ($request->alat as $idx => $val) {
                $alat_jasa=new AlatJasa;
                $alat_jasa->id_alat_jasa=$id_list_alat;
                $alat_jasa->id_list_jasa= $id;
                $alat_jasa->kode_barang=$request->alat[$idx];
                $alat_jasa->save();
                }
            return true;
        }

    }

    function edit_jasa(Request $request)
    {
        $jasa = ListJasa::join('alat_jasa','list_jasa.id_list_jasa', '=', 'alat_jasa.id_list_jasa')
        ->where('list_jasa.id_list_jasa', $request->id)
            ->get();
            
        return json_encode($jasa);
    }

    function update_jasa(Request $request){
        $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
        $jasa = ListJasa::where('id_list_jasa', $request->id_jasa)
        ->firstOrFail();
        $jasa->nama=$request->nama_jasa;
        $jasa->harga=$request->harga_jasa;
        $jasa->diskon_jasa=$request->diskon_jasa;
        if(!$jasa->save()){
            return false;
        }else{
            $list = AlatJasa::where('id_list_jasa',$request->id_jasa)->delete();
            foreach ($request->alat as $idx => $val) {
                $id_list_alat = IdGenerator::generate(['table' => 'alat_jasa','field'=>'id_alat_jasa', 'length' => 15, 'prefix' =>'ALT-'. $year . '-']);
                $alat_jasa=new AlatJasa;
                $alat_jasa->id_alat_jasa=$id_list_alat;
                $alat_jasa->id_list_jasa= $request->id_jasa;
                $alat_jasa->kode_barang=$request->alat[$idx];
                $alat_jasa->save();
                }
            return true;
        }
    }

    function delete_jasa(Request $request){
        $list = ListJasa::where('id_list_jasa', $request->id)
        ->first();
        $simpan = $list->delete();
        if ($simpan) {
            Session::flash('success', 'Hapus berhasil! Silahkan periksa data terbaru');
            return true;
        } else {
            Session::flash('errors', ['' => 'Hapus gagal! Silahkan ulangi kembali']);
            return false;
        }
    }

}
