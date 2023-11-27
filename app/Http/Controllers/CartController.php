<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{   private $cartService;

    public function __construct(CartService $cartService) {
        $this->cartService = $cartService;
    }

    public function index() {
        try {
            return response()->json([
                'data' => $this->cartService->index(),
                'success' => true,
                'message' => ''
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function addToCart(Request $request) {
        try {
            return response()->json([
                'data' => $this->cartService->addToCart($request),
                'success' => true,
                'message' => ''
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function removeFromCart(Request $request) {
        try {
            return response()->json([
                'data' => $this->cartService->removeFromCart($request),
                'success' => true,
                'message' => ''
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
