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
            'name' => isset($this->product) ? $this->product->name : $this['product']->name,
            'description' => isset($this->product) ? $this->product->description : $this['product']->description,
            'quantity' => $this->count ?? $this['count'],
            'price' => isset($this->product) ? $this->product->price : $this['product']->price,
            'sum' => $this->sum ?? $this['sum'],
        ];
    }
}
