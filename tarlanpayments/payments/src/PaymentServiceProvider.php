<?php

namespace TarlanPayments\Payments;

use TarlanPayments\Payments\Facades\TarlanPay as TarlanPayFacade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
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
            __DIR__.'/config/tarlanpayment.php' => config_path('tarlanpayment.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__.'/config/tarlanpayment.php', 'tarlanpayment'
        );
    }
}
