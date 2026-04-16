<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShoppingCartResource extends JsonResource
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
            'userId'            => $this->user_id,
            'productDetailId'   => $this->product_detail_id,
            'quantity'          => (int) $this->quantity,
            'createdAt'         => $this->created_at,
            'updatedAt'         => $this->update_at,
            'user'              => UserResource::make($this->whenLoaded('user')),
            'productDetail'     => ProductDetailResource::make($this->whenLoaded('productDetail')),
        ];
    }
}
