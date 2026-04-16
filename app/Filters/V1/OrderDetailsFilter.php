<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class OrderDetailsFilter extends ApiFilter {

    protected $columnMap = [
        'orderId'   => 'order_id',
        'productId' => 'product_id',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

    public function __construct()
    {
        $this->safeParams = [
            'id'        => $this->numericOperator,
            'orderId'   => $this->numericOperator,
            'productId' => $this->numericOperator,
            'quantity'  => $this->numericOperator,
            'subtotal'  => $this->numericOperator,
            'createdAt' => $this->numericOperator,
            'updatedAt' => $this->numericOperator,
        ];
    }
}