<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingResource extends JsonResource
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
            'orderId'           => $this->order_id,
            'addressId'         => $this->address_id,
            'shippingNumber'    => $this->shipping_number,
            'type'              => $this->type,
            'subtotal'          => (int) $this->subtotal,
            'status'            => $this->status,
            'createdAt'         => $this->created_at,
            'updatedAt'         => $this->update_at,
            'order'             => OrderResource::make($this->whenLoaded('order')),
            'address'           => AddressResource::make($this->whenLoaded('address')),
        ];
    }
}
