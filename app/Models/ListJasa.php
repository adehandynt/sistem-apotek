<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListJasa extends Model
{
    use HasFactory;
    protected $table = 'list_jasa';
    protected $primarykey='id';
}
