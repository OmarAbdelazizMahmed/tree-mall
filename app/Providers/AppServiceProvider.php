<?php

namespace App\Providers;

use App\Contracts\PaymentGatewayContract;
use App\Services\StripPaymentGateway;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(PaymentGatewayContract::class, function ($app) {
            $cartItems = Cart::instance('default')->content()->map(function ($item) {
                return
                    'Product Code: '. $item->options->code.', '.
                    'Product Name: '. $item->name.', '.
                    'Product Quantity: '. $item->qty;

            })->values()->toJson();

            return new StripPaymentGateway($cartItems);
        });
    }
}
