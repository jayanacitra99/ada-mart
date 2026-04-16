<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class AddressesFilter extends ApiFilter {

    protected $columnMap = [
        'userId'                    => 'user_id',
        'recipientName'             => 'recipient_name',
        'recipientPhoneNumber'      => 'recipient_phone_number',
        'postalCode'                => 'postal_code',
        'fullAddress'               => 'full_address',
        'additionalInstructions'    => 'additional_instructions',
        'createdAt'                 => 'created_at',
        'updatedAt'                 => 'updated_at',
    ];

    public function __construct()
    {
        $this->safeParams = [
            'id'                    => $this->numericOperator,
            'userId'                => $this->numericOperator,
            'recipientName'         => $this->stringOperator,
            'recipientPhoneNumber'  => $this->stringOperator,
            'city'                  => $this->stringOperator,
            'postalCode'            => $this->stringOperator,
            'fullAddress'           => $this->stringOperator,
            'additionalInstructions'=> $this->stringOperator,
            'isDefault'             => $this->numericOperator,
            'createdAt'             => $this->numericOperator,
            'updatedAt'             => $this->numericOperator,
        ];
    }
}