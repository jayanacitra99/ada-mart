<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class CarouselsFilter extends ApiFilter {

    protected $columnMap = [
        'isPopup'   => 'is_popup',
        'showFrom'  => 'show_from',
        'showUntil' => 'show_until',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

    public function __construct()
    {
        $this->safeParams = [
            'id'        => $this->numericOperator,
            'name'      => $this->stringOperator,
            'image'     => $this->stringOperator,
            'status'    => $this->stringOperator,
            'isPopup'   => $this->numericOperator,
            'showFrom'  => $this->numericOperator,
            'showUntil' => $this->numericOperator,
            'createdAt' => $this->numericOperator,
            'updatedAt' => $this->numericOperator,
        ];
    }
}