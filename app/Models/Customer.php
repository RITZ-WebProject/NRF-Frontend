<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = ['id','customer_name','phone_primary','email','password','address','home_no','street_name','division_id','township_id','active_time','active_status'];
    public function order(): HasMany
    {
        return $this->HasMany(Order::class);
    }
}
