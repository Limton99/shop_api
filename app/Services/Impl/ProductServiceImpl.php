<?php

namespace App\Services\Impl;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductServiceImpl implements \App\Services\ProductService
{
    public function search(Request $request)
    {
        $products = Product::where('name', 'like', '%' . $request->tag . '%')
            ->orWhereHas('category', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->tag . '%')
                    ->orWhere('slug', 'like', '%' . $request->tag . '%');
            })->get();

        return $products;
    }
}
