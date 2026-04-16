<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class CustomerHistoriesFilter extends ApiFilter {

    protected $columnMap = [
        'userId'        => 'user_id',
        'orderId'       => 'order_id',
        'paymentReceipt'=> 'payment_receipt',
        'totalRaw'      => 'total_raw',
        'totalFinal'    => 'total_final',
        'createdAt'     => 'created_at',
        'updatedAt'     => 'updated_at',
    ];

    public function __construct()
    {
        $this->safeParams = [
            'id'            => $this->numericOperator,
            'userId'        => $this->numericOperator,
            'orderId'       => $this->numericOperator,
            'products'      => $this->stringOperator,
            'destination'   => $this->stringOperator,
            'paymentReceipt'=> $this->stringOperator,
            'promo'         => $this->stringOperator,
            'totalRaw'      => $this->numericOperator,
            'totalFinal'    => $this->numericOperator,
            'createdAt'     => $this->numericOperator,
            'updatedAt'     => $this->numericOperator,
        ];
    }
}