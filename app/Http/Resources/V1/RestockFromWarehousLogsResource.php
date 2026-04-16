<?php

namespace App\Http\Resources\V1;

use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RestockFromWarehousLogsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'openedProductId'       => $this->opened_product_id,
            'convertedToProductId'  => $this->converted_to_product_id,
            'openedAmount'          => $this->opened_amount,
            'receivedAmount'        => $this->received_amount,
            'createdAt'             => $this->created_at,
            'updatedAt'             => $this->update_at,
            'openedProduct'         => ProductDetailResource::make($this->whenLoaded('openedProduct')),
            'convertedToProduct'    => ProductDetailResource::make($this->whenLoaded('convertedToProduct')),
        ];
    }
}
