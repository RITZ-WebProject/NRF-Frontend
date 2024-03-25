<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DeliveryInfo extends Model
{
    use HasFactory;
    protected $table = 'delivery_info';
    protected $fillable = ['id','invoice_id','customer_id','division_id','district_id','township_id','delivery_address'];
    public function division()
    {
        return $this->hasOne(Division::class,'id','division_id');
    }
    public function district()
    {
        return $this->hasOne(District::class,'id','district_id');
    }
    public function township()
    {
        return $this->hasOne(Township::class,'id','township_id');
    }
}
