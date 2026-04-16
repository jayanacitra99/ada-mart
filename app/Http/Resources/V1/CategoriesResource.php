<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResource extends JsonResource
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
            'promoId'           => $this->promo_id,
            'name'              => $this->name,
            'image'             => $this->image,
            'createdAt'         => $this->created_at,
            'updatedAt'         => $this->update_at,
            'productCategories' => ProductCategoriesResource::collection($this->whenLoaded('productCategories')),
            'promo'             => PromoResource::make($this->whenLoaded('promo')),
        ];
    }
}
