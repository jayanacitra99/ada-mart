<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'productDetailId'   => $this->product_detail_id,
            'productPrice'      => $this->product_price,
            'quantity'          => (int) $this->quantity, 
            'subtotal'          => (int) $this->subtotal,
            'createdAt'         => $this->created_at,
            'updateAt'          => $this->updated_at,
            'order'             => OrderResource::make($this->whenLoaded('order')),
            'productDetail'     => ProductDetailResource::make($this->whenLoaded('productDetail')),
        ];
    }
}
