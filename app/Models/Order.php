<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
    
    const BILLED = 'billed';
    const PAID = 'paid';
    const CANCELED = 'canceled';
    const COMPLETED = 'completed';

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'promo_id',
        'status',
        'total',
        'total_final',
        'billed_at',
        'paid_at',
        'completed_at',
    ];

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment(){
        return $this->hasOne(Payment::class, 'order_id');
    }

    public function shipping(){
        return $this->hasOne(Shipping::class, 'order_id');
    }

    public function promo(){
        return $this->belongsTo(Promo::class, 'promo_id');
    }

    public function getTotalFinalAttribute(){
        $total = $this->total;
        if ($this->promo){
            if($this->promo->active){
                if ($this->promo->type == 'voucher') {
                    $total -= $this->promo->amount;
                } else {
                    $disc = ($total / 100) * $this->promo->amount;
                    $total -= (($disc > $this->promo->max_amount) ? $this->promo->max_amount : $disc);
                }
            }
        }
        return $total;
    }
}
