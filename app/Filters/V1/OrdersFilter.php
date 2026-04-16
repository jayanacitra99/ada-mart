<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class OrdersFilter extends ApiFilter {

    protected $columnMap = [
        'userId'    => 'user_id',
        'promoId'   => 'promo_id',
        'billedAt'  => 'billed_at',
        'paidAt'    => 'paid_at',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

    public function __construct()
    {
        $this->safeParams = [
            'id'            => $this->numericOperator,
            'userId'        => $this->numericOperator,
            'promoId'       => $this->numericOperator,
            'status'        => $this->stringOperator,
            'total'         => $this->numericOperator,
            'billedAt'      => $this->numericOperator,
            'paidAt'        => $this->numericOperator,
            'createdAt'     => $this->numericOperator,
            'updatedAt'     => $this->numericOperator,
        ];
    }
}