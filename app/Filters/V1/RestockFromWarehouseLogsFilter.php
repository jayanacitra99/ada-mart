<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class RestockFromWarehouseLogsFilter extends ApiFilter {

    protected $columnMap = [
        'openedProductId'       => 'opened_product_id',
        'convertedToProductId'  => 'converted_to_product_id',
        'openedAmount'          => 'opened_amount',
        'receivedAmount'        => 'received_amount',
        'createdAt'             => 'created_at',
        'updatedAt'             => 'updated_at',
    ];
    
    public function __construct()
    {
        $this->safeParams = [
            'id'                    => $this->numericOperator,
            'openedProductId'       => $this->numericOperator,
            'convertedToProductId'  => $this->numericOperator,
            'openedAmount'          => $this->numericOperator,
            'receivedAmount'        => $this->numericOperator,
            'createdAt'             => $this->numericOperator,
            'updatedAt'             => $this->numericOperator,
        ];
    }
}