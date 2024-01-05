<?php

namespace App\Providers;

use App\Contracts\Payment\PaymentableService;
use App\Services\Payment\AmeriaPaymentService;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            PaymentableService::class,
            AmeriaPaymentService::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
