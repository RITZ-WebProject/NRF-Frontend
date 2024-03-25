<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $table ='tbl_districts';
    protected $fillable = ['id','division_id','district_name','district_name_mm','del_status'];
}
