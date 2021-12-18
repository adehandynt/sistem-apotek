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
use App\Models\Antrian;
use App\Models\Tindakan;
use Validator;
use Hash;
use Session;
use DB;
use Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;
class DokterController extends Controller
{
    public function v_obat()
    {
        $res['satuan'] = Satuan::get();
        $res['tipe'] = Tipe::get();
        
        return view('dokter/data-obat',$res);
    }

    public function list_obat()
    {
        $data = Obat::Join('tipe', 'barang.kode_tipe', '=', 'tipe.kode_tipe')
            ->Join('satuan', 'barang.kode_satuan', '=', 'satuan.kode_satuan')
            ->Join('stok', 'barang.kode_barang', '=', 'stok.kode_barang')
            ->join(DB::raw('(SELECT
            t.kode_barang,
            min(t.sisa) as sisa
               FROM
            ( SELECT kode_barang, MAX( created_at ) AS MaxTime, created_at FROM history_barang GROUP BY kode_barang ) r
            INNER JOIN history_barang t ON t.kode_barang = r.kode_barang 
            AND t.created_at = r.MaxTime GROUP BY t.kode_barang) AS history_barang'),
           'history_barang.kode_barang', '=', 'barang.kode_barang')
            ->select('barang.*','stok.tgl_exp','history_barang.sisa','satuan.satuan','satuan.kode_satuan','tipe.nama_tipe','tipe.kode_tipe')
            ->where('tipe.jenis_barang','obat')
            ->get();
        return json_encode($data);
    }

    public function list_pasien(){
        $data = Pasien::get();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->action = '<a href="javascript:void(0);" class="action-icon btn-edit" data-id="' . $data[$i]->id . '" data-bs-toggle="modal" data-bs-target="#custom-modal-edit"> <i class="mdi mdi-square-edit-outline"></i></a>
            <a href="javascript:void(0);" class="action-icon btn-antrian" data-id="' . $data[$i]->nik . '"> <i class="mdi mdi-human-queue"></i></a>';
        }
    return json_encode($data);
    }

    public function add_pasien(Request $request){
        $pasien=new Pasien;
        $pasien->nik=$request->nik;
        $pasien->nama_pasien=$request->nama_pasien;
        $pasien->tgl_lahir=$request->tgl_lahir;
        $pasien->jenis_kelamin=$request->jenis_kelamin;
        $pasien->umur_pasien=$request->umur_pasien;
        $pasien->alamat_pasien=$request->alamat_pasien;
        $pasien->no_telp_pasien=$request->no_telp_pasien;
        $pasien->golongan_darah=$request->golongan_darah;
        $pasien->no_bpjs=$request->no_bpjs;
        if(!$pasien->save()){
            return false;
        }else{
            return true;
        }

    }

    public function edit_pasien(Request $request){
        $pasien = Pasien::where('id', $request->id)
            ->firstOrFail();

        return json_encode($pasien);
    }

    public function update_pasien(Request $request){
        $pasien = Pasien::where('nik', $request->nik)
            ->firstOrFail();
            $pasien->nik=$request->nik;
            $pasien->nama_pasien=$request->nama_pasien;
            $pasien->tgl_lahir=$request->tgl_lahir;
            $pasien->jenis_kelamin=$request->jenis_kelamin;
            $pasien->umur_pasien=$request->umur_pasien;
            $pasien->alamat_pasien=$request->alamat_pasien;
            $pasien->no_telp_pasien=$request->no_telp_pasien;
            $pasien->golongan_darah=$request->golongan_darah;
            $pasien->no_bpjs=$request->no_bpjs;
            if(!$pasien->save()){
                return false;
            }else{
                return true;
            }
    }

    public function list_tindakan(){
        $data = Tindakan::get();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->action = '<a href="javascript:void(0);" class="action-icon btn-edit" data-id="' . $data[$i]->id . '" data-bs-toggle="modal" data-bs-target="#custom-modal-edit"> <i class="mdi mdi-square-edit-outline"></i></a>';
        }
    return json_encode($data);
    }

    public function add_tindakan(Request $request){
        $id = IdGenerator::generate(['table' => 'tindakan','field'=>'id_tindakan', 'length' => 8, 'prefix' =>'TND-']);
        $tindakan=new Tindakan;
        $tindakan->id_tindakan=$id;
        $tindakan->tindakan=$request->tindakan;
        $tindakan->biaya=$request->biaya;
        if(!$tindakan->save()){
            return false;
        }else{
            return true;
        }

    }

    public function edit_tindakan(Request $request){
        $pasien = Tindakan::where('id', $request->id)
            ->firstOrFail();

        return json_encode($pasien);
    }

    public function update_tindakan(Request $request){
        $tindakan = Tindakan::where('id', $request->id)
            ->firstOrFail();
        $tindakan->tindakan=$request->tindakan;
        $tindakan->biaya=$request->biaya;
        if(!$tindakan->save()){
            return false;
        }else{
            return true;
        }
    }

    public function v_medis()
    {
        $res['satuan'] = Satuan::get();
        $res['tipe'] = Tipe::get();
        $res['pasien'] = Pasien::get();
        $res['penyakit'] = Penyakit::get();
        $res['obat'] =  Obat::Join('tipe', 'barang.kode_tipe', '=', 'tipe.kode_tipe')
        ->Join('satuan', 'barang.kode_satuan', '=', 'satuan.kode_satuan')
        ->Join('stok', 'barang.kode_barang', '=', 'stok.kode_barang')
        ->leftJoin(DB::raw('(SELECT * FROM barang_keluar order by created_at desc limit 1) AS barang_keluar'),
        'barang_keluar.stock_id', '=', 'stok.stock_id')
        ->select('barang.*','stok.tgl_exp','barang_keluar.sisa','satuan.satuan','satuan.kode_satuan','tipe.nama_tipe','tipe.kode_tipe')
        ->get();
        $res['tindakan'] = Tindakan::get();
        return view('dokter/rekam',$res);
    }
    
    public function add_rekam(Request $request){
        $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
        $id = IdGenerator::generate(['table' => 'rekam_medis','field'=>'id_rekam_medis', 'length' => 15, 'prefix' =>'RKM-'. $year . '-']);
        $rekam=new RekamMedis;
        $rekam->id_rekam_medis=$id;
        $rekam->tekanan_darah=$request->tekanan_darah;
        $rekam->saturasi_oksigen=$request->saturasi_oksigen;
        $rekam->tgl_rekam=\Carbon\Carbon::now()->timezone('Asia/Jakarta');
        $rekam->nip=Auth::user()->nip;
        $rekam->nik=$request->nik;
        if(!$rekam->save()){
            return false;
        }else{
            $id_list_penyakit = IdGenerator::generate(['table' => 'list_penyakit','field'=>'id_list_penyakit', 'length' => 15, 'prefix' =>'IPN-'. $year . '-']);
            foreach ($request->penyakit as $idx => $val) {
            $ListPenyakit=new ListPenyakit;
            $ListPenyakit->id_list_penyakit=$id_list_penyakit;
            $ListPenyakit->id_rekam_medis=$id;
            $ListPenyakit->id_penyakit=$request->penyakit[$idx];
            $ListPenyakit->save();
            }
            $id_list_tindakan = IdGenerator::generate(['table' => 'list_tindakan','field'=>'id_list_tindakan', 'length' => 15, 'prefix' =>'ITN-'. $year . '-']);
            foreach ($request->tindakan as $idx => $val) {
                $ListTindakan=new ListTindakan;
                $ListTindakan->id_list_tindakan=$id_list_tindakan;
                $ListTindakan->id_rekam_medis=$id;
                $ListTindakan->id_tindakan=$request->tindakan[$idx];
                $ListTindakan->save();
                }

                $id_resep = IdGenerator::generate(['table' => 'resep','field'=>'id_resep', 'length' => 15, 'prefix' =>'RSP-'. $year . '-']);
                foreach ($request->kode_barang as $idx => $val) {
                    $resep=new Resep;
                    $resep->id_resep=$id_resep;
                    $resep->id_rekam_medis=$id;
                    $resep->kode_barang=$request->kode_barang[$idx];
                    $resep->dosis=$request->dosis[$idx];
                    $resep->save();
                    }

                    return true;
        }

    }

    public function list_pasien_rekam(){
        $data = Pasien::get();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->action = '<a href="javascript:void(0);" class="action-icon btn-rekam" data-id="' . $data[$i]->nik . '" data-bs-toggle="modal" data-bs-target="#custom-modal-rekam"> <i class="mdi mdi-book-open-variant"></i></a>';
        }
    return json_encode($data);
    }

    public function list_rekam_medis(Request $request){
        $data = RekamMedis::Join('pasien', 'rekam_medis.nik', '=', 'pasien.nik')
        ->Join('staf', 'rekam_medis.nip', '=', 'staf.nip')
        ->select('rekam_medis.*','staf.nama_staf','pasien.nik','pasien.nama_pasien')
        ->get();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->action = '<a href="javascript:void(0);" class="action-icon btn-rekam-detail" data-id="' . $data[$i]->id_rekam_medis . '" data-bs-toggle="modal" data-bs-target="#custom-modal-detail"> <i class="mdi mdi-eye"></i></a>';
        }
        return json_encode($data);
    }

    public function detail_rekam_medis(Request $request){
        $data = RekamMedis::where('rekam_medis.id_rekam_medis',$request->id)
        ->Join('pasien', 'rekam_medis.nik', '=', 'pasien.nik')
        ->Join('list_tindakan', 'rekam_medis.id_rekam_medis', '=', 'list_tindakan.id_rekam_medis')
        ->Join('tindakan', 'list_tindakan.id_tindakan', '=', 'tindakan.id_tindakan')
        ->Join('list_penyakit', 'rekam_medis.id_rekam_medis', '=', 'list_penyakit.id_rekam_medis')
        ->Join('penyakit', 'list_penyakit.id_penyakit', '=', 'penyakit.id_penyakit')
        ->Join('resep', 'rekam_medis.id_rekam_medis', '=', 'resep.id_rekam_medis')
        ->Join('barang', 'resep.kode_barang', '=', 'barang.kode_barang')
        ->select('rekam_medis.*','penyakit.*','tindakan.*','resep.*','pasien.nama_pasien','barang.nama_barang')
        ->get();
        
        return json_encode($data);
    }
    
    public function get_detail_resep(Request $request)
    {
        $data=RekamMedis::Join('resep', 'rekam_medis.id_rekam_medis', '=', 'resep.id_rekam_medis')
        ->Join('barang', 'resep.kode_barang', '=', 'barang.kode_barang')
        ->Join('set_harga', 'barang.kode_barang', '=', 'set_harga.kode_barang')
        ->Join('harga', 'set_harga.id_harga', '=', 'harga.id_harga')
        ->Join('list_tindakan', 'list_tindakan.id_rekam_medis', '=', 'rekam_medis.id_rekam_medis')
        ->Join('tindakan', 'list_tindakan.id_tindakan', '=', 'tindakan.id_tindakan')
        ->where('resep.id_rekam_medis',$request->id)
        ->orderBy('harga.created_at','DESC')
        ->select('rekam_medis.id_rekam_medis','barang.nama_barang','harga.margin','harga.harga_beli','resep.*','harga.harga_eceran','harga.harga_jual',DB::raw('SUM(tindakan.biaya) as total_dokter'))
        ->groupBy('rekam_medis.id_rekam_medis')
        ->get();

        return json_encode($data);
    }

    public function add_antrian(Request $request){
        $antrian = new Antrian;
        $antrian->nik=$request->id;
        $antrian->save();
        return true;
    }

    public function get_antrian(Request $request){
        $date=\Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
        $data = Antrian::join('pasien', 'pasien.nik', '=', 'antrian.nik')
        ->where('antrian.created_at','like','%'.$date.'%')
        ->select('antrian.*','pasien.nama_pasien')
        ->get();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->action = '<a href="javascript:void(0);" class="action-icon btn-terima" data-id="' . $data[$i]->id . '"> <i class="mdi mdi-check-bold"></i></a>';
        }
        return json_encode($data);
    }

    public function reset_antrian(Request $request){
        $reset=Antrian::truncate();
        return true;
    }
    public function remove_antrian(Request $request ){
        $remove =  Antrian::where('id',$request->id)->delete();
        return true;
    }


}
