<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'sub_title',
        'description',
        'price',
        'frame_price',
        'image',
        'is_sold',
        'is_draft',
        'visits',
    ];

    public function Order() {
        return $this->hasMany(Order::class);
    }

    public function Photo() {
        return $this->hasMany(Photo::class);
    }
}
