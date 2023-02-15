<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin \App\Models\Category */
class CategoriesResource extends JsonResource
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
            'name'     => $this->name,
            'slug'     => $this->slug,
            'children' => $this->when((bool) $this->children->count(), self::collection($this->children)),
            'level'    => $this->level,
            'discount' => $this->discount,
        ];
    }
}
