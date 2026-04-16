<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class PaymentsFilter extends ApiFilter {

    protected $columnMap = [
        'orderId'           => 'order_id',
        'paymentReceipt'    => 'payment_receipt',
        'createdAt'         => 'created_at',
        'updatedAt'         => 'updated_at',
    ];

    public function __construct()
    {
        $this->safeParams = [
            'id'                => $this->numericOperator,
            'orderId'           => $this->numericOperator,
            'total'             => $this->numericOperator,
            'status'            => $this->stringOperator,
            'paymentReceipt'    => $this->stringOperator,
            'createdAt'         => $this->numericOperator,
            'updatedAt'         => $this->numericOperator,
        ];
    }
}