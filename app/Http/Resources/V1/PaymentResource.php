<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'payment_receipt'   => $this->payment_receipt,
            'total'             => (int) $this->total,
            'status'            => $this->status,
            'createdAt'         => $this->created_at,
            'updatedAt'         => $this->update_at,
            'order'             => OrderResource::make($this->whenLoaded('order')),
        ];
    }
}
