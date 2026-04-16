<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class ProductCategoriesFilter extends ApiFilter {

    protected $columnMap = [
        'productId' => 'product_id',
        'categoryId' => 'category_id',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

    public function __construct()
    {
        $this->safeParams = [
            'id'            => $this->numericOperator,
            'productId'     => $this->numericOperator,
            'categoryId'    => $this->numericOperator,
            'createdAt'     => $this->numericOperator,
            'updatedAt'     => $this->numericOperator,
        ];
    }
}