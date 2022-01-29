<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'customer_id',
        'code',
        'total',
        'is_done'
    ];

    public function Product() {
        return $this->belongsTo(Product::class);
    }

    public function Customer() {
        return $this->belongsTo(Customer::class);
    }
}
