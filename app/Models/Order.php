<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['id','invoice_id','customer_id','product_id','price','size','status'];
    protected $table = 'ordered_products';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
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
