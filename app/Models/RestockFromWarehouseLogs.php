<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestockFromWarehouseLogs extends Model
{
    use HasFactory;

    protected $table = 'restock_from_warehouse_logs';

    protected $fillable = [
        'user_id',
        'opened_product_id',
        'converted_to_product_id',
        'opened_amount',
        'received_amount',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function openedProduct(){
        return $this->belongsTo(ProductDetail::class, 'opened_product_id');
    }

    public function convertedToProduct(){
        return $this->belongsTo(ProductDetail::class, 'converted_to_product_id');
    }
}
