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
            return Auth::user()->cart()->first();
        } else {
            $cart = Session::get('cart');
            $items = [

            ];
            $totalSum = 0;
            foreach ($cart as $item) {
                $items[] = collect([
                    "sum" => $item['sum'],
                    "count" => $item['count'],
                    "product" => $item['product']
                ]);
                $totalSum += $item['sum'];
            }

            $data = [
                'items' => collect($items),
                'total_sum' => $totalSum
            ];
            return new CartResource($data);
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
                                'count' => 1,
                                'product' => $product
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
                    'count' => 1,
                    'product' => $product

                ];
            }
            Session::put('cart', $cart);

        }

        return true;

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
                            if ($item->count == 1) {
                                $item->delete();
                                break;
                            }
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
                    if ($cart[$i]['count'] == 1) {
                        array_splice($cart, $i, 1);
                        break;
                    }
                    if ($cart[$i]['id'] == $product->id) {
                        $cart[$i]['count'] -= 1;
                        $cart[$i]['sum'] -= $product->price;
                        break;
                    }
                }
                Session::put('cart', $cart);

            }

        }
        return true;

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
