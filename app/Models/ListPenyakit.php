<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListPenyakit extends Model
{
    use HasFactory;
    protected $table = 'list_penyakit';
    protected $primarykey='id';
}
