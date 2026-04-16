<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class RestockLogsFilter extends ApiFilter {

    protected $columnMap = [
        'productId'     => 'product_id',
        'unitType'      => 'unit_type',
        'beforeRestock' => 'before_restock',
        'afterRestock'  => 'after_restock',
        'createdAt'     => 'created_at',
        'updatedAt'     => 'updated_at',
    ];
    
    public function __construct()
    {
        $this->safeParams = [
            'id'            => $this->numericOperator,
            'productId'     => $this->numericOperator,
            'quantity'      => $this->numericOperator,
            'unitType'      => $this->stringOperator,
            'beforeRestock' => $this->numericOperator,
            'afterRestock'  => $this->numericOperator,
            'createdAt'     => $this->numericOperator,
            'updatedAt'     => $this->numericOperator,
        ];
    }
}