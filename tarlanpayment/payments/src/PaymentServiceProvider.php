<?php

namespace TarlanPayment\Payments;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use TarlanPayment\Payments\Facades\TarlanPay as TarlanPayFacade;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/tarlanpayment.php', 'tarlanpayment'
        );

        $loader = AliasLoader::getInstance();
        $loader->alias('Crud', TarlanPayFacade::class);

        $this->app->singleton("tarlanpay", function($app)
        {
            return new TarlanPay();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/tarlanpayment.php' => config_path('tarlanpayment.php'),
        ]);
    }
}
