<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class PromosFilter extends ApiFilter {

    protected $columnMap = [
        'promoCode'     => 'promo_code',
        'maxAmount'     => 'max_amount',
        'validFrom'     => 'valid_from',
        'validUntil'    => 'valid_until',
        'createdAt'     => 'created_at',
        'updatedAt'     => 'updated_at',
    ];

    public function __construct()
    {
        $this->safeParams = [
            'id'            => $this->numericOperator,
            'promoCode'     => $this->stringOperator,
            'type'          => $this->stringOperator,
            'amount'        => $this->numericOperator,
            'maxAmount'     => $this->numericOperator,
            'validFrom'     => $this->numericOperator,
            'validUntil'    => $this->numericOperator,
            'createdAt'     => $this->numericOperator,
            'updatedAt'     => $this->numericOperator,
        ];
    }
}