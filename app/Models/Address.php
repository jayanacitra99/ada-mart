<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    protected $fillable = [
        'user_id',
        'recipient_name',
        'recipient_phone_number',
        'city',
        'postal_code',
        'full_address',
        'additional_instructions',
        'is_default'
    ];

    public function shippings(){
        return $this->hasMany(Shipping::class, 'address_id');
    }

    public function getCombinedAddressAttribute(){
        $fullAddress = '';
        $fullAddress .= $this?->full_address ?? '-';
        $fullAddress .= ' | ' . $this?->city ?? '-';
        $fullAddress .= ' | ' . $this?->postal_code ?? '-';
        $fullAddress .= ' ( ' . $this?->additional_instructions .' )' ?? '-' ;

        return $fullAddress;
    }
}
