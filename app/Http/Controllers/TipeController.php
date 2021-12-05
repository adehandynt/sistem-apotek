<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipe;
use Validator;
use Hash;
use Session;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class TipeController extends Controller
{
    public function v_tipe()
    {
        return view('data-master/tipe');
    }
    public function v_list_tipe()
    {
        $data = Tipe::orderby('created_at', 'DESC')
            ->get();
        //        return view('data-master/tipe', $res);
        for($i=0;$i<count($data);$i++){
            $data[$i]->action=' <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#custom-modal" data-id="'.$data[$i]->id.'"
            class="btn-update action-icon"> <i
                class="mdi mdi-square-edit-outline"></i></a>
        <a href="javascript:void(0);" data-id="'.$data[$i]->id.'"
            class="btn-delete action-icon"> <i
                class="mdi mdi-delete"></i></a>';
            $data[$i]->simbol='<img style="width:50px;height:50px" src="'.$data[$i]->simbol.'" alt="table-user" class="me-2 rounded-circle">';
        }
        return json_encode($data);
    }
    public function add_tipe(Request $request)
    {
        $rules = [
            'nama_tipe'              => 'required|string',
            'jenis_barang'              => 'required',
            'simbol'              => 'required'
        ];

        $messages = [
            'nama_tipe.required'              => 'Nama wajib diisi',
            'jenis_barang.required'           => 'Jenis wajib diisi',
            'simbol.required'       => 'Simbol wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return json_encode($validator);
        }
        $id = IdGenerator::generate(['table' => 'tipe','field'=>'kode_tipe', 'length' => 6, 'prefix' =>'TP-']);
        $file = $request->file('simbol');
        $directory = 'document/simbol';
        $path = $directory . '/' . $file->getClientOriginalName();
        $file->move($directory, $file->getClientOriginalName());
        $list = Tipe::updateOrCreate(['kode_tipe' => $id], [
            'nama_tipe' => $request->nama_tipe,
            'jenis_barang' => $request->jenis_barang,
            'simbol' => $path,
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

    function list_tipe(Request $request)
    {
        $res['data'] = Tipe::orderby('created_at', 'DESC')
            ->get();
        return json_encode($res['data']);
    }

    function edit_tipe(Request $request)
    {
        $list = Tipe::where('id', $request->id)
            ->firstOrFail();

        return json_encode($list);
    }

    function update_tipe(Request $request)
    {
        $rules = [
            'kode_tipe'                 => 'required|string',
            'nama_tipe'              => 'required|string',
            'jenis_barang'              => 'required',
            'simbol'              => 'required'
        ];

        $messages = [
            'kode_tipe.required'               => 'Kode wajib diisi',
            'nama_tipe.required'              => 'Nama wajib diisi',
            'jenis_barang.required'           => 'Jenis wajib diisi',
            'simbol.required'       => 'Simbol wajib diisi',
        ];

         $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return json_encode($validator);
        }

        $file = $request->file('simbol');
        $directory = 'document/simbol';
        $path = $directory . '/' . $file->getClientOriginalName();
        $file->move($directory, $file->getClientOriginalName());

        $list = Tipe::findOrFail($request->id);
        $list->kode_tipe = $request->kode_tipe;
        $list->nama_tipe = $request->nama_tipe;
        $list->jenis_barang = $request->jenis_barang;
        $list->simbol = $path;

        $simpan = $list->save();

        if ($simpan) {
            Session::flash('success', 'Update berhasil! Silahkan periksa data terbaru');
            return redirect()->route('data-list');
        } else {
            Session::flash('errors', ['' => 'Update gagal! Silahkan ulangi kembali']);
            return redirect()->route('data-list');
        }
    }

    function delete_tipe(Request $request){
        $list = Tipe::findOrFail($request->id);
        $simpan = $list->delete();
        if ($simpan) {
            Session::flash('success', 'Hapus berhasil! Silahkan periksa data terbaru');
            return redirect()->route('data-list');
        } else {
            Session::flash('errors', ['' => 'Hapus gagal! Silahkan ulangi kembali']);
            return redirect()->route('data-list');
        }
    }
}
