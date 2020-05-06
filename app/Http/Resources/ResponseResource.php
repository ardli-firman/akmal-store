<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource as Resource;

class ResponseResource extends Resource
{
    private $message;

    public function __construct($resource, $message)
    {
        parent::__construct($resource);
        $this->resource = $resource;

        $this->message = $message;
    }

    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function with($request)
    {
        return ['message' => $this->message];
    }
}
