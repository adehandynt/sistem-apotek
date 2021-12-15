<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satuan;
use Validator;
use Hash;
use Session;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class SatuanController extends Controller
{
    public function v_satuan()
    {
        return view('data-master/satuan');
    }
    public function v_list_satuan()
    {
        $data = Satuan::orderby('created_at', 'DESC')
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
    public function add_satuan(Request $request)
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

        $id = IdGenerator::generate(['table' => 'satuan','field'=>'kode_satuan', 'length' => 9, 'prefix' =>'STN-']);
        $list = Satuan::updateOrCreate(['kode_satuan' => $id], [
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

    function list_satuan(Request $request)
    {
        $res['data'] = Satuan::orderby('created_at', 'DESC')
            ->get();
        return json_encode($res['data']);
    }

    function edit_satuan(Request $request)
    {
        $satuan = Satuan::where('id', $request->id)
            ->firstOrFail();

        return json_encode($satuan);
    }

    function update_satuan(Request $request)
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

        $satuan = Satuan::findOrFail($request->id);
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

    function delete_satuan(Request $request){
        $list = Satuan::findOrFail($request->id);
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
