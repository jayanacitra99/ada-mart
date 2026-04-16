<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use HasFactory;

    protected $table = 'shopping_carts';

    protected $fillable = [
        'user_id',
        'product_detail_id',
        'quantity',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function productDetail(){
        return $this->belongsTo(ProductDetail::class, 'product_detail_id');
    }
}
