<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\CartItemInterface;
use App\Contracts\VariationInterface;
use App\Contracts\ComponentInterface;
use App\Contracts\OrderPurchaseInterface;

use App\Contracts\Eloquent\EloquentCartItem;
use App\Contracts\Eloquent\EloquentVariation;
use App\Contracts\Eloquent\EloquentComponent;
use App\Contracts\Eloquent\EloquentOrderPurchase;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CartItemInterface::class, EloquentCartItem::class);
        $this->app->bind(VariationInterface::class, EloquentVariation::class);
        $this->app->bind(ComponentInterface::class, EloquentComponent::class);
        $this->app->bind(ComponentInterface::class, EloquentComponent::class);
        $this->app->bind(OrderPurchaseInterface::class, EloquentOrderPurchase::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
