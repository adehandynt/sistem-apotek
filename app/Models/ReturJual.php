<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturJual extends Model
{
    use HasFactory;
    protected $table = 'retur_penjualan';
    protected $primarykey='id';
}
