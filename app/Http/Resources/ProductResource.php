<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'product_id' => $this->id,
            'name' => $this->name,
            'price' => $this->measure,
            'image' => url('/product/image') . '/' . $this->image,
            'category' => new CategoryResource($this->category)
        ];
    }
}
