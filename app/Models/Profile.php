<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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

    public function User() {
        return $this->belongsTo(User::class);
    }

    public function Customer() {
        return $this->hasMany(Customer::class);
    }
}
