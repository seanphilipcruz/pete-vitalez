<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'requests';

    protected $fillable = [
        'customer_id',
        'product_id',
        'description',
        'is_done'
    ];

    public function Customer() {
        return $this->belongsTo(Customer::class);
    }

    public function Product() {
        return $this->belongsTo(Product::class);
    }
}
