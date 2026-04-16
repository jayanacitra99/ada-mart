<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'userId'        => $this->user_id,
            'promoId'       => $this->promo_id,
            'status'        => $this->status,
            'total'         => (int) $this->total,        
            'totalFinal'    => (int) $this->total_final,        
            'billedAt'      => $this->billed_at,
            'paidAt'        => $this->paid_at,
            'createdAt'     => $this->created_at,
            'updatedAt'     => $this->updated_at,
            'orderDetails'  => OrderDetailResource::collection($this->whenLoaded('orderDetails')),
            'payment'       => PaymentResource::make($this->whenLoaded('payment')),
            'shipping'      => ShippingResource::make($this->whenLoaded('shipping')),
            'promo'         => PromoResource::make($this->whenLoaded('promo')),
            'user'          => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
