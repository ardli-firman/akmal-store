<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->measure,
            'image' => $this->image,
            'category' => [
                'name' => $this->category->name
            ]
        ];
    }
}
