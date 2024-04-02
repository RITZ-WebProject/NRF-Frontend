<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable;

    protected $table = 'customers';

    protected $fillable = ['id','customer_name','phone_primary','email','password','address','home_no','street_name','country_id','division_id','district_id','township_id','active_time','active_status'];

    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function township(): BelongsTo
    {
        return $this->belongsTo(Township::class, 'township_id');
    }
}
