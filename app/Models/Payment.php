<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    const WAITING = 'waiting';
    const PAID = 'paid';
    const CANCELED = 'canceled';
    const SUCCESS = 'success';
    const FAILED = 'failed';

    protected $table = 'payments';

    protected $fillable = [
        'order_id',
        'payment_receipt',
        'total',
        'status',
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
}
