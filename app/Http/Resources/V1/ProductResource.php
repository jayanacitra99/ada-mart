<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $products = [
            'id'                => $this->id,
            'name'              => $this->name,
            'description'       => $this->description,
            'image'             => $this->image,
            'createdAt'         => $this->created_at,
            'updatedAt'         => $this->update_at,
        ];
        $productDetails = $this->productDetails;
        
        foreach($productDetails as $productDetail){
            if($productDetail->unit_type == 'pcs'){
                $products['idPcs'] = $productDetail->id;
            }
        }

        $relations = [
            'orderDetails'      => OrderDetailResource::collection($this->whenLoaded('orderDetails')),
            'restockLogs'       => RestockLogResource::collection($this->whenLoaded('restockLogs')),
            'productDetails'    => ProductDetailResource::collection($this->whenLoaded('productDetails')),
            'productCategories' => ProductCategoriesResource::collection($this->whenLoaded('productCategories')),
        ];

        $results = \array_merge($products, $relations);
        return $results;
    }
}
