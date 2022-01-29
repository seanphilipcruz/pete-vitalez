<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
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

    public function Customer() {
        return $this->belongsTo(Customer::class);
    }
}
