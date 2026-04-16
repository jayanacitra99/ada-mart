<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerHistory extends Model
{
    use HasFactory;

    protected $table = 'customer_histories';

    protected $fillable = [
        'user_id',
        'order_id',
        'products',
        'destination',
        'promo',
        'payment_receipt',
        'total_raw',
        'total_final',
    ];

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }
}
