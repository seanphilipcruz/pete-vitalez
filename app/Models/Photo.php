<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'blog_id',
        'title',
        'description',
        'image',
    ];

    public function Product() {
        return $this->belongsTo(Product::class);
    }

    public function Blog() {
        return $this->belongsTo(Blog::class);
    }
}
