<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'phone'             => $this->phone,
            'email'             => $this->email,
            'emailVerifiedAt'   => $this->email_verified_at,
            'password'          => $this->password,
            'profileImage'      => $this->profile_image,
            'birthDate'         => $this->birth_date,
            'role'              => $this->role,
            'rememberToken'     => $this->remember_token,
            'createdAt'         => $this->created_at,
            'updatedAt'         => $this->update_at,
            'orders'            => OrderResource::collection($this->whenLoaded('orders')),
            'customerHistories' => CustomerHistoryResource::collection($this->whenLoaded('customerHistories')),
        ];
    }
}
