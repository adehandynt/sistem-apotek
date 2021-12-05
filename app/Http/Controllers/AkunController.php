<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Session;
use App\Models\Akun;
use App\Models\User;

class AkunController extends Controller
{
    public function v_akun()
    {
        $res['data'] = User::rightJoin('staf', 'staf.nip', '=', 'users.nip')
        ->select('staf.*')
        ->whereNull('users.nip')
        ->get();
        
        return view('data-master/akun',$res);
    }
    public function v_list_akun()
    {
        $data = User::leftJoin('staf', 'staf.nip', '=', 'users.nip')
        ->select('users.*','staf.nama_staf')
        ->get();
        //        return view('data-master/tipe', $res);
        for($i=0;$i<count($data);$i++){
            if($data[$i]->status==1){
                $data[$i]->action='<a href="javascript:void(0);" class="action-icon btn-reset" data-bs-toggle="modal" title="Reset Password" tabindex="0" data-plugin="tippy" data-tippy-animation="shift-toward" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true" data-bs-target="#custom-modal-reset" data-id="'.$data[$i]->id.'"> <i class="mdi mdi-key-variant"></i></a>
                <a href="javascript:void(0);" class="action-icon btn-disable" data-bs-toggle="modal" data-bs-target="#custom-modal-disable" title="Disable Akun" tabindex="0" data-plugin="tippy" data-tippy-animation="shift-toward" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true" data-bs-target="#custom-modal-disable" data-id="'.$data[$i]->id.'" data-status="'.$data[$i]->status.'"> <i class="mdi mdi-minus-circle"></i></a>';
            }else{
                $data[$i]->action='<a href="javascript:void(0);" class="action-icon btn-reset" data-bs-toggle="modal" title="Reset Password" tabindex="0" data-plugin="tippy" data-tippy-animation="shift-toward" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true" data-bs-target="#custom-modal-reset" data-id="'.$data[$i]->id.'"> <i class="mdi mdi-key-variant"></i></a>
                <a href="javascript:void(0);" class="action-icon btn-disable" data-bs-toggle="modal" data-bs-target="#custom-modal-disable" title="Disable Akun" tabindex="0" data-plugin="tippy" data-tippy-animation="shift-toward" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true" data-id="'.$data[$i]->id.'" data-status="'.$data[$i]->status.'"> <i class="mdi mdi-check-circle"></i></a>';
            }
            $data[$i]->status=$data[$i]->status==1?'<h5><span class="badge bg-soft-success text-success"><i class="mdi mdi-bitcoin"></i> Aktif</span></h5>':'<h5><span class="badge bg-soft-danger text-danger"><i class="mdi mdi-bitcoin"></i> Non-Aktif</span></h5>';
        }
        return json_encode($data);
    }
    public function add_akun(Request $request)
    {
           $rules = [
            'nip'                 => 'required',
            'username'              => 'required|unique:users',
            'password'              => 'required'
        ];
  
        $messages = [
            'nip.required'       => 'Nip wajib diisi',
            'username.required'         => 'Username Lengkap wajib diisi',
            'password.required'     => 'Password wajib diisi'
        ];
  

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return json_encode($validator);
        }

        $user = new User;
        $user->nip = $request->nip;
        $user->username = strtolower($request->username);
        $user->password = Hash::make($request->password);
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->status = 1;
        $simpan = $user->save();

        if ($simpan) {
            Session::flash('success', 'Input berhasil! Silahkan periksa data terbaru');
            return true;
        } else {
            Session::flash('errors', ['' => 'Input gagal! Silahkan ulangi kembali']);
            return false;
        }
    }

    function list_akun(Request $request)
    {
        $res['data'] = Akun::orderby('created_at', 'DESC')
            ->get();
        return json_encode($res['data']);
    }

    function edit_akun(Request $request)
    {
        $user = Akun::where('id', $request->id)
            ->firstOrFail();

        return json_encode($user);
    }

    function update_akun(Request $request)
    {
        $rules = [
            'password'              => 'required'
        ];
  
        $messages = [
            'password.required'     => 'Password wajib diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return json_encode($validator);
        }

        $user = User::findOrFail($request->id);
        $user->password = Hash::make($request->password);
        $simpan = $user->save();

        if ($simpan) {
            Session::flash('success', 'Update berhasil! Silahkan periksa data terbaru');
            return true;
        } else {
            Session::flash('errors', ['' => 'Update gagal! Silahkan ulangi kembali']);
            return false;
        }
    }

    function disable_akun(Request $request){
        $user = User::findOrFail($request->id);
        $user->status = $request->status;
        $simpan = $user->save();
        if ($simpan) {
            Session::flash('success', 'Disable berhasil! Silahkan periksa data terbaru');
            return true;
        } else {
            Session::flash('errors', ['' => 'Disable gagal! Silahkan ulangi kembali']);
            return false;
        }
    }

    function delete_akun(Request $request){
        $user = User::findOrFail($request->id);
        $simpan = $user->delete();
        if ($simpan) {
            Session::flash('success', 'Hapus berhasil! Silahkan periksa data terbaru');
            return true;
        } else {
            Session::flash('errors', ['' => 'Hapus gagal! Silahkan ulangi kembali']);
            return false;
        }
    }
}
