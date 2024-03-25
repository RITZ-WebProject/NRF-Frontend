<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempInvoice extends Model
{
    use HasFactory;
    protected $table = 'temp_invoices';
    protected $fillable = ['id','customer_id','status','payment_method','total_price'];
    
    public function order()
    {
        return $this->hasMany('App\Models\Order','invoice_id','id');
    }
    public function customer()
    {
        return $this->hasOne('App\Models\Customer','id','customer_id');
    }
}
