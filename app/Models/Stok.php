<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;
    protected $table = 'stok';
    protected $primarykey='id';
    protected $fillable=['stock_id','kode_barang','tgl_masuk','tgl_exp','jml_masuk','jml_akumulasi','sisa','id_supplier'];
}