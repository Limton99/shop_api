<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function index() {
        try {
            return response()->json([
                'data' => Product::all(),
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

    public function search(Request $request) {
        try {
            return response()->json([
                'data' => $this->productService->search($request),
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
