<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromoResource extends JsonResource
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
            'promoCode'         => $this->promo_code,
            'type'              => $this->type,
            'amount'            => (int) $this->amount,
            'maxAmount'         => (int) $this->max_amount,
            'validFrom'         => $this->valid_from,
            'validUntil'        => $this->valid_until,
            'createdAt'         => $this->created_at,
            'updatedAt'         => $this->update_at,
            'orders'            => OrderResource::collection($this->whenLoaded('orders')),
            'productDetails'    => ProductDetailResource::collection($this->whenLoaded('productDetails')),
            'categories'        => CategoriesResource::collection($this->whenLoaded('categories')),
        ];
        
    }
}
