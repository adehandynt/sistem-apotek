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
use App\Models\Pembayaran;
use Validator;
use Hash;
use Session;
use DB;
use Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PembayaranController extends Controller
{
    public function data_pembayaran(Request $request){
        $data = Pembayaran::orderby('created_at', 'DESC')
        ->get();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->action = '<a href="javascript:void(0);" class="action-icon btn-edit" data-id="' . $data[$i]->id_pembayaran . '" data-bs-toggle="modal" data-bs-target="#custom-modal-edit"> <i class="mdi mdi-square-edit-outline"></i></a>';
        }
        return json_encode($data);
    }

    public function add_pembayaran(Request $request){
        $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
        $id = IdGenerator::generate(['table' => 'pembayaran','field'=>'id_pembayaran', 'length' => 15, 'prefix' =>'EXP-'. $year . '-']);
        $pembayaran=new Pembayaran;
        $pembayaran->id_referensi=$request->id_referensi;
        $pembayaran->id_pembayaran=$id;
        $pembayaran->metode_pembayaran=$request->metode_pembayaran;
        $pembayaran->status=$request->status;
        $pembayaran->jenis_bayar=$request->jenis_bayar;
        $pembayaran->tagihan=$request->tagihan;
        $pembayaran->terbayar=$request->terbayar;
        $pembayaran->tgl_bayar=$request->tgl_bayar;
        $pembayaran->deskripsi=$request->deskripsi;
        if($pembayaran->save()){
            return true;
        }else{
            return false;
        }

    }

    
    public function update_pembayaran(Request $request){
        $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
        $pembayaran=Pembayaran::where('id_pembayaran', $request->id_hidden)
        ->firstOrFail();;
        $pembayaran->id_referensi=$request->id_referensi;
        $pembayaran->metode_pembayaran=$request->metode_pembayaran;
        $pembayaran->status=$request->status;
        $pembayaran->jenis_bayar=$request->jenis_bayar;
        $pembayaran->tagihan=$request->tagihan;
        $pembayaran->terbayar=$request->terbayar;
        $pembayaran->tgl_bayar=$request->tgl_bayar;
        $pembayaran->deskripsi=$request->deskripsi;
        if($pembayaran->save()){
            return true;
        }else{
            return false;
        }

    }

    public function edit_pembayaran(Request $request){
        $pasien = Pembayaran::where('id_pembayaran', $request->id)
            ->firstOrFail();

        return json_encode($pasien);
    }
}
