<?php

namespace App\Services;

use Illuminate\Http\Request;

interface CartService
{
    public function index();
    public function addToCart(Request $request);
    public function removeFromCart(Request $request);
}
