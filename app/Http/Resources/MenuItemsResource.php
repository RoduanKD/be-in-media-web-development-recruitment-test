<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin \App\Models\MenuItem */
class MenuItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'name'           => $this->name,
            'slug'           => $this->slug,
            'price'          => $this->price,
            'discount_price' => $this->discount_price,
        ];
    }
}
