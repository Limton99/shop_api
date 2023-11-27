<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(UserRequest $request)
    {
        try {
            return response()->json([
                'data' => $this->userService->register($request),
                'success' => true,
                'message' => ''
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function login(Request $request) {
        try {
            return response()->json([
                'data' => $this->userService->login($request),
                'success' => true,
                'message' => ''
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
