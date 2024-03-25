<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newletter extends Model
{
    use HasFactory;
    protected $table = 'newsletter';
    protected $fillable = ['id','email','name'];
}
