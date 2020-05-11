<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'order_id' => $this->id,
            'customer_id' => $this->customer_id,
            'order_date' => Carbon::parse($this->order_date)->formatLocalized('%A %d %B %Y'),
            'note' => $this->note,
            'paid' => $this->paid,
            'change' => $this->change,
            'total_order' => $this->total_order,
            'order_product' => new OrderProductCollectionResource($this->orderProduct)
        ];
    }
}
