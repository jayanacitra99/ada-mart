<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $productDetail = [
            'id'                    => $this->id,
            'productId'             => $this->product_id,
            'promoId'               => $this->promo_id,
            'unitType'              => $this->unit_type,
            'price'                 => (int) $this->price,
            'quantity'              => (int) $this->quantity,
            'createdAt'             => $this->created_at,
            'updatedAt'             => $this->update_at,
            'product'               => ProductResource::make($this->whenLoaded('product')),
            'promo'                 => PromoResource::make($this->whenLoaded('promo')),
            'orderDetails'          => OrderDetailResource::collection($this->whenLoaded('orderDetails')),
            'openedProducts'        => RestockFromWarehousLogsResource::collection($this->whenLoaded('openedProducts')),
            'convertedToProducts'   => RestockFromWarehousLogsResource::collection($this->whenLoaded('convertedToProducts')),
        ];
        $promo = $this->promo;
        if($promo){
            $productDetail['statusPromo'] = $promo->active;
        } else {
            $productDetail['statusPromo'] = false;
        }
        $combinedArray = $productDetail;
        if($promo and $promo->active){
            $promoOfProduct = [
                'promoPrice'        => (int) $this->promo_price,
                'promoCode'         => $promo->promo_code,
                'type'              => $promo->type,
                'amount'            => (int) $promo->amount,
                'maxAmount'         => (int) $promo->max_amount,
                'validFrom'         => $promo->valid_from,
                'validUntil'        => $promo->valid_until,
            ];

            $combinedArray = array_merge($productDetail, $promoOfProduct);
        }
        return $combinedArray;
    }
}
