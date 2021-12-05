<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staf;
use Validator;
use Hash;
use Session;
use Carbon\Carbon;

class StafController extends Controller
{
    public function v_add_staf()
    {
        return view('data-master/add-staf');
    }
    public function v_list_staf()
    {
        $res['data'] = Staf::orderby('created_at', 'DESC')
            ->get();
        return view('data-master/staf', $res);
    }
    public function add_staf(Request $request)
    {
        $rules = [
            'nik'                 => 'required|numeric',
            'nama'              => 'required|string',
            'tempat_lahir'              => 'required|string',
            'tgl_lahir'              => 'required|date',
            'jenis_kelamin'              => 'required|string',
            'umur'              => 'required|numeric',
            'alamat'              => 'required|string',
            'email'              => 'required|email',
            'no_telp'              => 'required|numeric',
            'pendidikan'              => 'required|string',
            'no_telp_kerabat'              => 'required|numeric'
        ];

        $messages = [
            'nik.required'               => 'Nik wajib diisi',
            'nama.required'              => 'Nama wajib diisi',
            'tempat_lahir.required'       => 'Tempat Lahir wajib diisi',
            'tgl_lahir.required'         => 'Tanggal Lahir wajib diisi',
            'jenis_kelamin.required'     => 'Jenis Kelamin wajib diisi',
            'umur.required'              => 'Umur wajib diisi',
            'alamat.required'            => 'Alamat wajib diisi',
            'email.required'             => 'Email wajib diisi',
            'no_telp.required'           => 'No Telp wajib diisi',
            'pendidikan.required'        => 'Pendidikan wajib diisi',
            'no_telp_kerabat.required'   => 'No Telp Kerabat wajib diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('add-data-staf')->withErrors($validator)->withInput($request->all);
        }
        $kode = null;
        $date = Carbon::now()->timestamp;
        if ($request->posisi == 'owner') {
            $kode='0101';
        } elseif ($request->posisi == 'manager') {
            $kode='0102';
        } elseif ($request->posisi == 'apoteker') {
            $kode='0103';
        } elseif ($request->posisi == 'dokter') {
            $kode='0104';
        }
        $nip = $kode.''.$date;

        $staf = Staf::updateOrCreate([
            'nip' => $nip,
            'nik' => $request->nik,
            'nama_staf' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'umur' => $request->umur,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'pend_terakhir' => $request->pendidikan,
            'no_kerabat' => $request->no_telp_kerabat,
            'posisi' => $request->posisi
        ]);

        $simpan = $staf->save();

        if ($simpan) {
            Session::flash('success', 'Input berhasil! Silahkan periksa data terbaru');
            return redirect()->route('data-staf');
        } else {
            Session::flash('errors', ['' => 'Input gagal! Silahkan ulangi kembali']);
            return redirect()->route('add-data-staf');
        }
    }

    function list_staf(Request $request)
    {
        $res['data'] = Staf::orderby('created_at', 'DESC')
            ->get();
        return json_encode($res['data']);
    }

    function edit_staf(Request $request)
    {
        $staf = Staf::where('id', $request->id)
            ->firstOrFail();

        return json_encode($staf);
    }

    function update_staf(Request $request)
    {
        $rules = [
            'nik'                 => 'required|numeric',
            'nama'              => 'required|string',
            'tempat_lahir'              => 'required|string',
            'tgl_lahir'              => 'required|date',
            'jenis_kelamin'              => 'required|string',
            'umur'              => 'required|numeric',
            'alamat'              => 'required|string',
            'email'              => 'required|email',
            'no_telp'              => 'required|numeric',
            'pendidikan'              => 'required|string',
            'no_telp_kerabat'              => 'required|numeric'
        ];

        $messages = [
            'nik.required'               => 'nik wajib diisi',
            'nama.required'              => 'Nama wajib diisi',
            'tempat_lahir.required'       => 'Tempat Lahir wajib diisi',
            'tgl_lahir.required'         => 'Tanggal Lahir wajib diisi',
            'jenis_kelamin.required'     => 'Jenis Kelamin wajib diisi',
            'umur.required'              => 'Umur wajib diisi',
            'alamat.required'            => 'Alamat wajib diisi',
            'email.required'             => 'Email wajib diisi',
            'no_telp.required'           => 'No Telp wajib diisi',
            'pendidikan.required'        => 'Pendidikan wajib diisi',
            'no_telp_kerabat.required'   => 'No Telp Kerabat wajib diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('add-data-staf')->withErrors($validator)->withInput($request->all);
        }

        $staf = Staf::findOrFail($request->id);
        $staf->nik = $request->nik;
        $staf->nama_staf = $request->nama;
        $staf->tempat_lahir = $request->tempat_lahir;
        $staf->tgl_lahir = $request->tgl_lahir;
        $staf->jenis_kelamin = $request->jenis_kelamin;
        $staf->umur = $request->umur;
        $staf->alamat = $request->alamat;
        $staf->email = $request->email;
        $staf->no_telp = $request->no_telp;
        $staf->pend_terakhir = $request->pendidikan;
        $staf->no_kerabat = $request->no_telp_kerabat;
        $staf->posisi = $request->posisi;
        $simpan = $staf->save();

        if ($simpan) {
            Session::flash('success', 'Update berhasil! Silahkan periksa data terbaru');
            return redirect()->route('data-staf');
        } else {
            Session::flash('errors', ['' => 'Update gagal! Silahkan ulangi kembali']);
            return redirect()->route('data-staf');
        }
    }
}
