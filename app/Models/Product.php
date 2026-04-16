<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {        
            if ($product->check_order_status) {
                throw new \Exception("Cannot delete product because it's still being ordered.");
            }
            // Delete the images from the public directory
            if (!$product->already_sold) {
                if ($product->image) {
                    $images = json_decode($product->image, true);
                    if ($images) {
                        $dirname = '';
                        foreach ($images as $image) {
                            $dirname = $image;
                            if (file_exists(public_path($image)) && !str_contains($image, 'no-image.png')) {
                                unlink(public_path($image));
                            }
                        }
                        // Remove the folder
                        $folderPath = dirname(public_path($dirname)); // Get the directory containing the first image
                        if (is_dir($folderPath)) {
                            rmdir($folderPath);
                        }
                    }
                }
            }
            $product->productDetails()->delete();        
            $product->restockLogs()->delete();
            $product->productCategories()->delete();
        });
    }

    public function restockLogs(){
        return $this->hasMany(RestockLog::class, 'product_id');
    }

    public function productCategories(){
        return $this->hasMany(ProductCategories::class, 'product_id');
    }

    public function productDetails(){
        return $this->hasMany(ProductDetail::class, 'product_id');
    }

    public function getStockPerUnitTypesAttribute(){
        $stockUnit = $this->productDetails()->pluck('unit_type','quantity');
        $formatted = $stockUnit->map(function ($item, $key) {
            return "$key $item";
        })->implode(' | ');

        return $formatted;
    }

    public function getTotalSoldAttribute()
    {
        $productDetails = $this->productDetails;
        $totalSold = 0;
        foreach($productDetails as $productDetail){
            $totalSold += $productDetail->sold;
        }
        return $totalSold;
    }

    public function getAlreadySoldAttribute(){
        $productDetails = $this->productDetails;
        foreach($productDetails as $productDetail){
            if($productDetail->sold > 0){
                return true;
            }
        }
        return false;
    }

    public function getPriceRangeAttribute()
    {
        $prices = $this->productDetails()->orderBy('price','asc')->pluck('price')->toArray();
        $first = reset($prices);
        $last = end($prices);
        return 'Rp '.number_format($first,0,',','.').' - '.'Rp '.number_format($last,0,',','.');
    }

    public function getCheckOrderStatusAttribute(){
        $productDetails = $this->productDetails->pluck('id')->toArray();
        
        $orderDetail = OrderDetail::whereIn('product_detail_id',$productDetails)->first();

        return $orderDetail?->order()->whereNotIn('status',[Order::CANCELED, Order::COMPLETED])->exists() ?? false;
    }
    public function hasActivePromo()
    {
        foreach ($this->productDetails as $productDetail) {
            if ($productDetail->promo && $productDetail->promo->active) {
                return true;
            }
        }
        return false;
    }
}
