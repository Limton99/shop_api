<?php

namespace App\Services;

use Illuminate\Http\Request;

interface ProductService
{
    public function search(Request $request);
}
