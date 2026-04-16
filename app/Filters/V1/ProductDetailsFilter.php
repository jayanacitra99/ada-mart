<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class ProductDetailsFilter extends ApiFilter {

    protected $columnMap = [
        'productId' => 'product_id',
        'promoId'   => 'promo_id',
        'unitType'  => 'unit_type',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

    public function __construct()
    {
        $this->safeParams = [
            'id'            => $this->numericOperator,
            'productId'     => $this->numericOperator,
            'promoId'       => $this->numericOperator,
            'unitType'      => $this->stringOperator,
            'price'         => $this->numericOperator,
            'quantity'      => $this->numericOperator,
            'createdAt'     => $this->numericOperator,
            'updatedAt'     => $this->numericOperator,
        ];
    }
}