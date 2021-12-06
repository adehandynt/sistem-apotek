<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetHarga extends Model
{
    use HasFactory;
    protected $table = 'set_harga';
    protected $primarykey='id';
    protected $fillable=['kode_barang','id_harga'];
}
