<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staf extends Model
{
    use HasFactory;
    protected $table = 'staf';
    protected $primarykey='id';
    protected $fillable=['nip','nik','nama_staf','tempat_lahir','tgl_lahir','jenis_kelamin','umur','alamat','email','no_telp','pend_terakhir','no_kerabat','posisi'];
}
