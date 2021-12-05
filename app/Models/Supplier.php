<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'supplier';
    protected $primarykey='id';
    protected $fillable=['id_supplier','nama_supplier','alamat','no_telp_supplier','email_supplier','pic'];
}
