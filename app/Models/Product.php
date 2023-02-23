<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_name',
        'product_price',
        'status',
    ];

    public function product_in_cart() {
        return $this->hasMany(Cart::class, 'product_id'); 
    }

    public function order_products() {
        return $this->hasMany(OrderProduct::class, 'product_id'); 
    }
}
