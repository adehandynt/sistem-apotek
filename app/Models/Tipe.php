<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipe extends Model
{
    use HasFactory;
    protected $table = 'tipe';
    protected $primarykey='id';
    protected $fillable=['kode_tipe','nama_tipe','jenis_barang','simbol'];
}
