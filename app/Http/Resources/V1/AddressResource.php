<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                        => $this->id,
            'userId'                    => $this->user_id,
            'recipientName'             => $this->recipient_name,
            'recipientPhoneNumber'      => $this->recipient_phone_number, 
            'city'                      => $this->city,
            'postalCode'                => $this->postal_code,
            'fullAddress'               => $this->full_address,
            'additionalInstructions'    => $this->additional_instructions,
            'isDefault'                 => $this->is_default,
            'createdAt'                 => $this->created_at,
            'updateAt'                  => $this->updated_at,
            'shippings'                 => ShippingResource::collection($this->whenLoaded('shippings')),
        ];
    }
}
