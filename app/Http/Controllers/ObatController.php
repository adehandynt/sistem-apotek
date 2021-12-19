<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Satuan;
use App\Models\Tipe;
use App\Models\Harga;
use App\Models\SetHarga;
use App\Models\Stok;
use App\Models\Margin;
use App\Models\ListItem;
use Validator;
use Hash;
use Session;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ObatController extends Controller
{
    public function v_obat()
    {
        $res['satuan'] = Satuan::get();
        $res['tipe'] = Tipe::get();
        $res['margin'] = Margin::get();
        
        return view('data-master/obat',$res);
    }
    public function v_list_obat()
    {
        $data = Obat::leftJoin('stok', 'barang.kode_barang', '=', 'stok.kode_barang')
            ->leftJoin('set_harga', 'barang.kode_barang', '=', 'set_harga.kode_barang')
            ->leftJoin('harga', 'set_harga.id_harga', '=', 'harga.id_harga')
            ->Join('tipe', 'barang.kode_tipe', '=', 'tipe.kode_tipe')
            ->Join('satuan', 'barang.kode_satuan', '=', 'satuan.kode_satuan')
            ->select('barang.*','harga.harga_jual','harga.harga_beli','harga.margin','harga.harga_eceran','satuan.satuan','satuan.kode_satuan','tipe.nama_tipe','tipe.kode_tipe')
            ->get();
        //        return view('data-master/tipe', $res);
        for($i=0;$i<count($data);$i++){
            $data[$i]->action=' <a href="javascript:void(0);" data-id="'.$data[$i]->id.'"
            class="btn-update action-icon"> <i
                class="mdi mdi-square-edit-outline"></i></a>
        <a href="javascript:void(0);" data-id="'.$data[$i]->id.'"
            class="btn-delete action-icon"> <i
                class="mdi mdi-delete"></i></a>';
        }
        return json_encode($data);
    }
    public function add_obat(Request $request)
    {
        $rules = [
            'kode_barang'                 => 'required',
            'nama_barang'              => 'required',
            'tipe_barang'              => 'required',
            'satuan'                 => 'required',
            'harga_beli'              => 'required',
            'kode_barang'                 => 'required',
            'harga_jual'              => 'required',
            'penyimpanan'              => 'required'
        ];

        $messages = [
            'kode_barang.required'               => 'Kode wajib diisi',
            'nama_barang.required'              => 'Nama wajib diisi',
            'tipe_barang.required'       => 'Tipe wajib diisi',
            'satuan.required'               => 'Satuan wajib diisi',
            'harga_beli.required'       => 'Harga wajib diisi',
            'kode_barang.required'               => 'Kode wajib diisi',
            'harga_jual.required'              => 'Harga wajib diisi',
            'penyimpanan.required'       => 'Penyimpanan wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return json_encode($validator);
        }

        $id_brg = IdGenerator::generate(['table' => 'barang','field'=>'kode_barang', 'length' => 8, 'prefix' =>'BRG-']);

        $list = Obat::updateOrCreate(['kode_barang' => str_replace(" ","",$request->kode_barang)], [
            'nama_barang' => $request->nama_barang,
            'produsen' => $request->produsen,
            'kode_tipe' =>  $request->tipe_barang,
            'kode_satuan' => $request->satuan,
            'jml_per_satuan' => $request->jml_per_satuan,
            'status_ecer' => $request->input('status_ecer')==null?0:1,
            'penyimpanan' => $request->penyimpanan,
            'konsinyasi' => $request->konsinyasi,
        ]);
        $simpan = $list->save();

        $id_harga = IdGenerator::generate(['table' => 'harga','field'=>'id_harga', 'length' => 8, 'prefix' =>'HRG-']);
        $list = Harga::updateOrCreate(['id_harga' => $id_harga], [
            'harga_jual' => (($request->harga_beli))+($request->harga_beli * ($request->margin/100)),
            'harga_beli' =>  $request->harga_beli,
            'harga_eceran' => $request->input('status_ecer')!=null ? ((((($request->harga_beli))+($request->harga_beli * ($request->margin/100))))/$request->jml_per_satuan):0,
            'tgl_harga' =>  \Carbon\Carbon::now(),
            'diskon' => 0,
            'margin' => $request->margin,
            'kode_barang' =>  str_replace(" ","",$request->kode_barang)
        ]);
        $simpan = $list->save();

        $list = SetHarga::updateOrCreate(['kode_barang' =>str_replace(" ","",$request->kode_barang)], [
            'id_harga' => $id_harga
        ]);
        $simpan = $list->save();

        if($request->input('inbound')==true){
            $list=ListItem::where('id_list_order', '=', str_replace(" ","",$request->kode_barang))->firstOrFail();
            $list->kode_barang=str_replace(" ","",$request->kode_barang);
            $list->save();
        }

        // $id_stok = IdGenerator::generate(['table' => 'stok','field'=>'stock_id', 'length' => 6, 'prefix' =>'STK-']);
        // $list = Stok::updateOrCreate(['stock_id' => $id_stok], [
        //     'kode_barang' =>  $id_brg,
        //     'tgl_' =>  $request->tipe_barang,
        //     'satuan' => $request->satuan,
        //     'jumlah' =>  $request->jumlah,
        //     'harga_beli' => $request->harga_beli,
        //     'kode_barang' =>  $request->kode_barang,
        //     'harga_jual' => $request->harga_jual,
        //     'penyimpanan' =>  $request->penyimpanan
        // ]);
        // $simpan = $list->save();

        if ($simpan) {
            Session::flash('success', 'Input berhasil! Silahkan periksa data terbaru');
            return true;
        } else {
            Session::flash('errors', ['' => 'Input gagal! Silahkan ulangi kembali']);
            return false;
        }
    }

    function list_obat(Request $request)
    {
        $res['data'] = Obat::orderby('created_at', 'DESC')
            ->get();
        return json_encode($res['data']);
    }
    function edit_obat(Request $request)
    {
        $data = Obat::where('barang.id', $request->id)
        ->leftJoin('stok', 'barang.kode_barang', '=', 'stok.kode_barang')
        ->leftJoin('set_harga', 'barang.kode_barang', '=', 'set_harga.kode_barang')
        ->leftJoin('harga', 'set_harga.id_harga', '=', 'harga.id_harga')
        ->Join('tipe', 'barang.kode_tipe', '=', 'tipe.kode_tipe')
        ->Join('satuan', 'barang.kode_satuan', '=', 'satuan.kode_satuan')
        ->select('barang.*','harga.harga_jual','harga.harga_beli','harga.margin','harga.harga_eceran','satuan.satuan','tipe.nama_tipe')
        ->firstOrFail();

        return json_encode($data);
    }

    function detail_barang_item(Request $request)
    {
        $data = Obat::where('barang.kode_barang', $request->id)
        ->leftJoin('set_harga', 'barang.kode_barang', '=', 'set_harga.kode_barang')
        ->leftJoin('harga', 'set_harga.id_harga', '=', 'harga.id_harga')
        ->Join('satuan', 'barang.kode_satuan', '=', 'satuan.kode_satuan')
        ->select('barang.*','satuan.satuan','harga.harga_jual','harga.harga_beli')
        ->orderby('harga.created_at','desc')
        ->firstOrFail();

        return json_encode($data);
    }

    function update_obat(Request $request)
    {
        $rules = [
            'kode_obat'                 => 'required|string',
            'obat'              => 'required|string',
            'akronim'              => 'required'
        ];

        $messages = [
            'kode_obat.required'               => 'Kode wajib diisi',
            'obat.required'              => 'Nama wajib diisi',
            'akronim.required'       => 'Akronim wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return json_encode($validator);
        }

        $obat = Obat::findOrFail($request->id);
        $obat->kode_obat = $request->nama;
        $obat->obat = $request->obat;
        $obat->akronim = $request->akronim;
        $simpan = $obat->save();

        if ($simpan) {
            Session::flash('success', 'Update berhasil! Silahkan periksa data terbaru');
            return true;
        } else {
            Session::flash('errors', ['' => 'Update gagal! Silahkan ulangi kembali']);
            return false;
        }
    }

    function delete_obat(Request $request){
        $list = Obat::findOrFail($request->id);
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
