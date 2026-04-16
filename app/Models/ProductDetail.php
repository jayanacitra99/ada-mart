<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $table = 'product_details';

    protected $fillable = [
        'product_id',
        'promo_id',
        'unit_type',
        'price',
        'quantity',
        'min_order',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($productDetail) {
            $productDetail->openedProducts()->delete();
            $productDetail->convertedToProducts()->delete();
            $productDetail->shoppingCarts()->delete();
        });
    }

    public function promo(){
        return $this->belongsTo(Promo::class, 'promo_id');;
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class, 'product_detail_id');
    }

    public function openedProducts(){
        return $this->hasMany(RestockFromWarehouseLogs::class, 'opened_product_id');
    }

    public function convertedToProducts(){
        return $this->hasMany(RestockFromWarehouseLogs::class, 'converted_to_product_id');
    }

    public function shoppingCarts(){
        return $this->hasMany(ShoppingCart::class, 'product_detail_id');
    }

    public function getProductPromoAttribute(){
        return $this->product->productCategories()->whereHas('category',function($q){
            $q->whereNotNull('promo_id');
        })->first()->category->promo;
    }

    public function getSoldAttribute(){
        return $this->orderDetails->count();
    }

    public function getFirstImageAttribute()
    {
        $images = json_decode($this->product->image, true);
        $firstImage = 'products/no-image.png';
        if (is_array($images)) {
            foreach ($images as $image) {
                if (!is_null($image) && $image !== '') {
                    $firstImage = $image;
                    break;
                }
            }
        }
        return $firstImage;
    }

    public function getPromoDetailAttribute(){
        $promo = $this->loadMissing('promo');
        $promo = $this->promo;

        if (!is_null($promo)) {
            if ($promo->active) {
                if ($promo->type == 'voucher') {
                    return $promo->name.' ( Voucher : Rp.'.$promo->amount.')';
                } else {
                    return $promo->name.' ( Disc : '.$promo->amount.'%'.' | Max : '.$promo->max_amount.')';
                }
            }
        }
        return null;
    }

    public function getPromoPriceAttribute(){
        $promo = $this->promo;

        if (!is_null($promo)) {
            if ($promo->active){
                if ($promo->type == 'voucher') {
                    return $this->price - $promo->amount;
                } else {
                    $disc = ($this->price / 100) * $promo->amount;
                    return $this->price - (($disc > $promo->max_amount) ? $promo->max_amount : $disc);
                }
            }
        }
        return null;
    }

    
    // SCOPES

    public function scopeOfUnitType($query, $type){
        return $query->where('unit_type', $type);
    }
}
