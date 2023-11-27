<?php

namespace App\Services\Impl;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartServiceImpl implements \App\Services\CartService
{

    public function index()
    {
        if (Auth::user()) {
            return new CartResource(Auth::user()->cart()->first());
        } else {
            return Session::get('cart');
        }
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->productId);

        if (Auth::user()) {
            $user = Auth::user();
            $cart = $user->cart()->first();

            if ($cart) {
                $items = $cart->items()->get();
                foreach ($items as $key => $item) {
                    if ($item->product_id == $product->id) {
                        $item->count += 1;
                        $item->sum += $product->price;

                        $cart->total_sum += $product->price;
                        $item->save();
                        $cart->save();
                        break;
                    } else {
                        if ($key == count($items) - 1) {
                            $this->createCartItem($cart, $product);
                            $cart->total_sum += $product->price;
                            $cart->save();

                            break;
                        }
                    }
                }
                if (count($items) == 0) {
                    $cartItem = $this->createCartItem($cart, $product);

                    $cart->total_sum += $cartItem->sum;
                    $cart->save();

                }
            }
            else {
                $cart = Cart::create([
                    'user_id' => $user->id,
                    'total_sum' => 0
                ]);

                $cartItem = $this->createCartItem($cart, $product);

                $cart->total_sum += $cartItem->sum;

                $cart->save();
            }
            return new CartResource($cart);
        } else {
            $cart = Session::get('cart');


            if ($cart != null && is_array($cart)) {

                for ($i = 0; $i < count($cart); $i++) {
                    if ($cart[$i]['id'] == $product->id) {
                        $cart[$i]['count'] += 1;
                        $cart[$i]['sum'] += $product->price;
                        break;
                    }
                    else{
                        if ($i == count($cart) - 1) {
                            $cart[] = [
                                'id' => $product->id,
                                'name' => $product->name,
                                'sum' => $product->price,
                                'count' => 1
                            ];
                            break;
                        }
                    }
                }
            } else {
                $cart[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sum' => $product->price,
                    'count' => 1
                ];
            }
            Session::put('cart', $cart);

            return Session::get('cart');
        }
    }

    public function removeFromCart(Request $request)
    {
        $product = Product::findOrFail($request->productId);

        if (Auth::user()) {
            $user = Auth::user();
            $cart = $user->cart()->first();
            if ($cart) {
                $items = $cart->items()->get();

                if ($items) {
                    foreach ($items as $key => $item) {
                        if ($item->product_id == $product->id) {
                            $item->count -= 1;
                            $item->sum -= $product->price;

                            $cart->total_sum -= $product->price;
                            $item->save();
                            $cart->save();
                            break;
                        }
                    }
                }
            }
        } else {
            $cart = Session::get('cart');


            if ($cart != null && is_array($cart)) {
                for ($i = 0; $i < count($cart); $i++) {
                    if ($cart[$i]['id'] == $product->id) {
                        $cart[$i]['count'] -= 1;
                        $cart[$i]['sum'] -= $product->price;
                        break;
                    }
                }
                Session::put('cart', $cart);

            }
        }

        return null;
    }

    public function createCartItem($cart, $product) {
        return CartItems::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'count' => 1,
            'sum' => $product->price
        ]);
    }
}
