<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JasaDokter extends Model
{
    use HasFactory;
    protected $table = 'jasa_dokter';
    protected $primarykey='id';
}
