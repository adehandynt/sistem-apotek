<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Validator;
use Hash;
use Session;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class SupplierController extends Controller
{
    public function v_supplier()
    {
        return view('data-master/supplier');
    }
    public function v_list_supplier()
    {
        $data = Supplier::orderby('created_at', 'DESC')
            ->get();
        //        return view('data-master/tipe', $res);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->action = ' <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#custom-modal" data-id="' . $data[$i]->id . '"
            class="btn-update action-icon"> <i
                class="mdi mdi-square-edit-outline"></i></a><a href="javascript:void(0);" data-id="' . $data[$i]->id . '"
            class="btn-delete action-icon"> <i
                class="mdi mdi-delete"></i></a>';
        }
        return json_encode($data);
    }
    public function add_supplier(Request $request)
    {
        $rules = [
            'alamat'              => 'required',
            'no_telp_supplier'              => 'required',
            'email_supplier'                 => 'required',
            'pic'              => 'required',
            'nama_supplier'              => 'required'
        ];

        $messages = [
            'alamat.required'               => 'Alamat wajib diisi',
            'no_telp_supplier.required'              => 'Nomor wajib diisi',
            'email_supplier.required'       => 'Email wajib diisi',
            'pic.required'              => 'PIC wajib diisi',
            'nama_supplier.required'       => 'Nama wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return json_encode($validator);
        }

        if(!isset($request->id_hide)){
            $id = IdGenerator::generate(['table' => 'supplier','field'=>'id_supplier', 'length' => 9, 'prefix' =>'SPL-']);
    
            $list = Supplier::updateOrCreate(['id_supplier' => $id], [
                'alamat' => $request->alamat,
                'no_telp_supplier' =>  $request->no_telp_supplier,
                'email_supplier' =>  $request->email_supplier,
                'pic' =>  $request->pic,
                'nama_supplier' =>  $request->nama_supplier,
            ]);
        }else{
            $list = Supplier::findOrFail($request->id_hide);
            $list->alamat = $request->alamat;
            $list->no_telp_supplier = $request->no_telp_supplier;
            $list->email_supplier = $request->email_supplier;
            $list->pic = $request->pic;
            $list->nama_supplier = $request->nama_supplier;
        }

        $simpan = $list->save();

        if ($simpan) {
            Session::flash('success', 'Input berhasil! Silahkan periksa data terbaru');
            return true;
        } else {
            Session::flash('errors', ['' => 'Input gagal! Silahkan ulangi kembali']);
            return false;
        }
    }

    function list_supplier(Request $request)
    {
        $res['data'] = Supplier::orderby('created_at', 'DESC')
            ->get();
        return json_encode($res['data']);
    }

    function edit_supplier(Request $request)
    {
        $satuan = Supplier::where('id', $request->id)
            ->firstOrFail();

        return json_encode($satuan);
    }

    function update_supplier(Request $request)
    {
        $rules = [
            'kode_supplier'                 => 'required|string',
            'satuan'              => 'required|string',
            'akronim'              => 'required'
        ];

        $messages = [
            'kode_supplier.required'               => 'Kode wajib diisi',
            'satuan.required'              => 'Nama wajib diisi',
            'akronim.required'       => 'Akronim wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return json_encode($validator);
        }

        $satuan = Supplier::findOrFail($request->id);
        $satuan->kode_supplier = $request->nama;
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

    function delete_supplier(Request $request)
    {
        $list = Supplier::findOrFail($request->id);
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
