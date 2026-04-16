<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestockLog extends Model
{
    use HasFactory;

    protected $table = 'restock_logs';

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'unit_type',
        'before_restock',
        'after_restock',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
