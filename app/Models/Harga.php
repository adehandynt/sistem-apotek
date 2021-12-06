<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    use HasFactory;
    protected $table = 'harga';
    protected $primarykey='id';
    protected $fillable=['id_harga','harga_jual','harga_beli','harga_eceran','tgl_harga','diskon','margin','kode_barang'];
}
