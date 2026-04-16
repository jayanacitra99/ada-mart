<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class ShoppingCartsFilter extends ApiFilter {

    protected $columnMap = [
        'userId'            => 'user_id',
        'productDetailId'   => 'product_detail_id',
        'createdAt'         => 'created_at',
        'updatedAt'         => 'updated_at',
    ];

    public function __construct()
    {
        $this->safeParams = [
            'id'                => $this->numericOperator,
            'userId'            => $this->numericOperator,
            'productDetailId'   => $this->numericOperator,
            'quantity'          => $this->numericOperator,
            'createdAt'         => $this->numericOperator,
            'updatedAt'         => $this->numericOperator,
        ];
    }
}