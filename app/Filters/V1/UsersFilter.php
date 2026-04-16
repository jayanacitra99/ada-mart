<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class UsersFilter extends ApiFilter {

    protected $columnMap = [
        'emailVerifiedAt'   => 'email_verified_at',
        'profileImage'      => 'profile_image',
        'birthDate'         => 'birth_date',
        'rememberToken'     => 'remember_token',
        'createdAt'         => 'created_at',
        'updatedAt'         => 'updated_at',
    ];

    public function __construct()
    {
        $this->safeParams = [
            'id'                => $this->numericOperator,
            'name'              => $this->stringOperator,
            'phone'             => $this->stringOperator,
            'email'             => $this->stringOperator,
            'emailVerifiedAt'   => $this->numericOperator,
            'password'          => $this->stringOperator,
            'profileImage'      => $this->stringOperator,
            'birthDate'         => $this->numericOperator,
            'role'              => $this->stringOperator,
            'rememberToken'     => $this->stringOperator,
            'createdAt'         => $this->numericOperator,
            'updatedAt'         => $this->numericOperator,
        ];
    }
}