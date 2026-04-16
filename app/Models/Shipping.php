<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    
    const WAITING = 'waiting';
    const ON_GOING = 'ongoing';
    const CANCELED = 'canceled';
    const ARRIVED = 'arrived';

    protected $table = 'shippings';

    protected $fillable = [
        'order_id',
        'address_id',
        'type',
        'shipping_number',
        'subtotal',
        'status',
        'proof_image',
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function address(){
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function getShippingTypeAttribute()
    {
        if ($this->type == 'pick-up') {
            return 'Pick Up';
        } else if ($this->type == 'delivery'){
            return 'Delivery';
        }
        return '-';
    }
}
