<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    const VOUCHER = 'voucher';
    const DISCOUNT = 'discount';

    protected $table = 'promos';

    protected $fillable = [
        'name',
        'promo_code',
        'type',
        'amount',
        'max_amount',
        'valid_from',
        'valid_until',
    ];

    public function productDetails(){
        return $this->hasMany(ProductDetail::class, 'promo_id');
    }

    public function categories(){
        return $this->hasMany(Categories::class, 'promo_id');
    }

    public function orders(){
        return $this->hasMany(Order::class, 'promo_id');
    }

    public function getValidDateAttribute(){
        return Carbon::parse($this->valid_from)->format('D, d-M-Y H:i:s').' s/d '.Carbon::parse($this->valid_until)->format('D, d-M-Y H:i:s');
    }

    public function getPromoDetailAttribute(){
        if ($this->active) {
            if ($this->type == 'voucher') {
                return 'Voucher : Rp.'.number_format($this->amount,0,',','.');
            } else {
                return 'Disc : '.$this->amount.'%'.' | Max : '.number_format($this->max_amount,0,',','.');
            }
        }
        return null;
    }

    public function promo_price($amount){

        if (!is_null($this)) {
            if ($this->active){
                if ($this->type == 'voucher') {
                    return $this->amount;
                } else {
                    $disc = ($amount / 100) * $this->amount;
                    return ($disc > $this->max_amount) ? $this->max_amount : $disc;
                }
            }
        }
        return null;
    }

    public function getTagAttribute()
    {
        if ($this->type == 'voucher') {
            return 'Rp. '.$this->amount.' OFF';
        } else {
            return 'Disc : '.$this->amount.' %';
        }
    }

    public function getActiveAttribute()
    {
        $now = Carbon::now();
        
        return $now->between($this->valid_from, $this->valid_until);
    }

    public function scopeByPromoCode($query, $promoCode)
    {
        return $query->where('promo_code', $promoCode);
    }
    
    public function scopeByActive($query)
    {
        return $query->where('valid_from', '<=', Carbon::now())
                     ->where('valid_until', '>=', Carbon::now());
    }
}
