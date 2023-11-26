<?php

namespace App\Providers;

use App\Services\CartService;
use App\Services\Impl\CartServiceImpl;
use App\Services\Impl\ProductServiceImpl;
use App\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductService::class, ProductServiceImpl::class);
        $this->app->bind(CartService::class, CartServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
