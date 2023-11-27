<?php

namespace App\Services\Impl;

use App\Http\Requests\UserRequest;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserServiceImpl implements \App\Services\UserService
{
    public function register(UserRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            throw new \Exception('Этот email занят!', 422);
        }

        $request->password = Hash::make($request->password);

        $user = User::create($request->all());

        return $user;
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw new \Exception('Этот email не зарегестрирован!', 422);
        }

        if ($user && Hash::check($request->password, $user->password)) {
            if (Session::get('cart')) {
                $user->cart()->delete();
                $total_sum = 0;
                $cart = Cart::create([
                    'user_id' => $user->id,
                    'total_sum' => $total_sum
                ]);

                foreach (Session::get('cart') as $item) {
                    CartItems::create([
                        'cart_id' => $cart->id,
                        'product_id' => $item['id'],
                        'count' => $item['count'],
                        'sum' => $item['sum']
                    ]);
                    $total_sum += $item['sum'];
                }

                $cart->total_sum = $total_sum;

                $cart->save();

                Session::remove('cart');
            }

            return $user->createtoken($user->email)->plainTextToken;
        }
    }
}
