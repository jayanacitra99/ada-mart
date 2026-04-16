<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RestockLogResource extends JsonResource
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
            'productId'     => $this->product_id,
            'quantity'      => $this->quantity,
            'unitType'      => $this->unit_type,
            'beforeRestock' => $this->before_restock,
            'afterRestock'  => $this->after_restock,
            'createdAt'     => $this->created_at,
            'updatedAt'     => $this->update_at,
            'product'       => ProductResource::make($this->whenLoaded('product')),
        ];
    }
}
