<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->product->name,
            'description' => $this->product->description,
            'quantity' => $this->count,
            'price' => $this->product->price,
            'sum' => $this->sum,
        ];
    }
}
