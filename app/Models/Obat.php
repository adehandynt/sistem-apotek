<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $primarykey='id';
    protected $fillable=['kode_barang','nama_barang','produsen','kode_tipe','kode_satuan','jml_per_satuan','status_ecer','penyimpanan','konsinyasi'];
}
