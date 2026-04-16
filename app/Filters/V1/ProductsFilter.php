<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class ProductsFilter extends ApiFilter {

    protected $columnMap = [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

    public function __construct()
    {
        $this->safeParams = [
            'id'            => $this->numericOperator,
            'name'          => $this->stringOperator,
            'description'   => $this->stringOperator,
            'image'         => $this->stringOperator,
            'createdAt'     => $this->numericOperator,
            'updatedAt'     => $this->numericOperator,
        ];
    }
}