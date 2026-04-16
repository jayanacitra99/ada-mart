<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'promo_id',
        'name',
        'image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            $category->productCategories()->delete();

            // Delete the images from the public directory
            if ($category->image) {
                if (file_exists(public_path($category->image)) && !str_contains($category->image, 'no-image.png')) {
                    unlink(public_path($category->image));
                }
            }
        });
    }

    public function productCategories(){
        return $this->hasMany(ProductCategories::class, 'category_id');
    }

    public function promo(){
        return $this->belongsTo(Promo::class, 'promo_id');
    }


}
