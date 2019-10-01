<?php

namespace TarlanPayments\Payments\Facades;

use Illuminate\Support\Facades\Facade;

class TarlanPay extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tarlanpay';
    }

}
