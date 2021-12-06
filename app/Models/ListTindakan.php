<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListTindakan extends Model
{
    use HasFactory;
    protected $table = 'list_tindakan';
    protected $primarykey='id';
}
