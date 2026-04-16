<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class CategoriesFilter extends ApiFilter {

    protected $columnMap = [
        'promoId'   => 'promo_id',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

    public function __construct()
    {
        $this->safeParams = [
            'id'            => $this->numericOperator,
            'promoId'       => $this->numericOperator,
            'name'          => $this->stringOperator,
            'image'         => $this->stringOperator,
            'createdAt'     => $this->numericOperator,
            'updatedAt'     => $this->numericOperator,
        ];
    }
}