<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerHistoryResource extends JsonResource
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
            'orderId'           => $this->order_id,
            'products'          => $this->products,
            'destination'       => $this->destination,
            'paymentReceipt'    => $this->payment_receipt,
            'totalRaw'          => (int) $this->total_raw,
            'promo'             => $this->promo,
            'totalFinal'        => (int) $this->total_final,
            'createdAt'         => $this->created_at,
            'updatedAt'         => $this->update_at,
            'user'              => UserResource::make($this->whenLoaded('user')),
            'orderDetails'      => OrderDetailResource::collection($this->whenLoaded('orderDetails')), 
        ];
    }
}
