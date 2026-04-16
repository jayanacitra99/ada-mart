<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'productId' => $this->product_id,
            'categoryId'=> $this->category_id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->update_at,
            'product'   => ProductResource::make($this->whenLoaded('product')),
            'category'  => CategoriesResource::make($this->whenLoaded('category')),
        ];
    }
}
