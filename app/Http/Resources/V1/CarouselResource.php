<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarouselResource extends JsonResource
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
            'name'      => $this->name,
            'image'     => $this->image,
            'status'    => $this->status,
            'isPopup'   => $this->is_popup,
            'isShow'    => $this->is_show,
            'showFrom'  => $this->show_from,
            'showUntil' => $this->show_until,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->update_at,
        ];
    }
}
