<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TempOrderProduct extends Model
{
    use HasFactory;
    protected $fillable = ['id','invoice_id','customer_id','product_id','price','size','status'];
    protected $table = 'temp_order_products';

    public function product(): HasMany
    {
        return $this->hasMany(Product::class, 'id','product_id');
    }
    public function invoice()
    {
        return $this->hasOne(Invoice::class,'id','invoice_id');
    }
    public function customer()
    {
        return $this->hasOne(Customer::class,'id','customer_id');
    }
    
    public function deli_info()
    {
        return $this->hasOne(DeliveryInfo::class,'invoice_id','invoice_id');
    }
}
