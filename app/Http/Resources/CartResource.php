<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'items' => isset($this->items) ? CartItemsResource::collection($this->items) :
                (isset($this['items']) ? CartItemsResource::collection($this['items']) : null),
            'total_sum' => $this->total_sum ?? (isset($this['total_sum']) ? $this['total_sum'] : 0),
        ];
    }
}
