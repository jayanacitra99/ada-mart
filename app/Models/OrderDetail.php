<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'product_detail_id',
        'product_price',
        'quantity',
        'subtotal',
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function productDetail(){
        return $this->belongsTo(ProductDetail::class, 'product_detail_id');
    }

    public function customerHistory(){
        return $this->belongsTo(CustomerHistory::class, 'order_id', 'order_id');
    }
}
