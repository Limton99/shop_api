<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

interface UserService
{
    public function register(UserRequest $request);
    public function login(Request $request);
}
