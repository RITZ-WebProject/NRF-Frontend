<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $table= 'tbl_divisions';
    protected $fillable = ['id','division_name','division_name_mm','del_status'];
}
