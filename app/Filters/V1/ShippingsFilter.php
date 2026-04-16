<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class ShippingsFilter extends ApiFilter {

    protected $columnMap = [
        'orderId'           => 'order_id',
        'addressId'         => 'address_id',
        'shippingNumber'    => 'shipping_number',
        'createdAt'         => 'created_at',
        'updatedAt'         => 'updated_at',
    ];

    public function __construct()
    {
        $this->safeParams = [
            'id'                => $this->numericOperator,
            'orderId'           => $this->numericOperator,
            'addressId'         => $this->numericOperator,
            'type'              => $this->stringOperator,
            'shippingNumber'    => $this->stringOperator,
            'subtotal'          => $this->numericOperator,
            'status'            => $this->stringOperator,
            'createdAt'         => $this->numericOperator,
            'updatedAt'         => $this->numericOperator,
        ];
    }
}