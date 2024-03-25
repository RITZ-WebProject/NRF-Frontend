<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Township extends Model
{
    use HasFactory;
    protected $table ='tbl_townships';
    protected $fillable = ['id','district_id','township_name','township_name_mm','del_status'];
}
