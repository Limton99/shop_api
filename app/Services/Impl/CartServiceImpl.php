<?php

namespace App\Services\Impl;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartServiceImpl implements \App\Services\CartService
{

    public function index()
    {
        if (Auth::user()) {
            return null;
        } else {
            return Session::get('cart');
        }
    }

    public function addToCart(Request $request)
    {
        if (Auth::user()) {
            return null;
        } else {
            $product = Product::findOrFail($request->productId);
            $cart = Session::get('cart');
            $data = [
            ];
            if ($cart != null && is_array($cart)) {
                foreach($cart as $item){
                    if ($item['id'] == $product->id) {
                        $item['count'] += 1;
                        $item['price'] += $product->price;
                        $data[] = $item;
                    } else{
                        $data = $cart;
                        $data[] = [
                            'id' => $product->id,
                            'name' => $product->name,
                            'price' => $product->price,
                            'count' => 1
                        ];
                    }
                };
            } else {
                $data[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'count' => 1
                ];
            }
            Session::put('cart', $data);

            return Session::get('cart');
        }
    }

    public function removeFromCart(Request $request)
    {
        // TODO: Implement removeFromCart() method.
    }
}
