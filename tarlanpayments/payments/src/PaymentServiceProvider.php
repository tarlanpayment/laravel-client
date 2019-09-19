<?php

namespace TarlanPayments\Payments;

use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/tarlanpayment.php' => config_path('tarlanpayment.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__.'/config/tarlanpayment.php', 'tarlanpayment'
        );
    }
}
