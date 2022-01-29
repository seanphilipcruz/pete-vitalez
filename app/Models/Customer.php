<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'profile_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone_number',
        'address',
        'zip_code',
        'city',
        'country',
        'state',
    ];

    public function Order() {
        return $this->hasMany(Order::class);
    }

    public function Shipping() {
        return $this->hasOne(Shipping::class);
    }

    public function Profile() {
        return $this->belongsTo(Profile::class);
    }

    public function Request() {
        return $this->hasMany(JobOrder::class);
    }
}
