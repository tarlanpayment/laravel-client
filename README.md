# Tarlan Payment Gateway
# Платежный сервис для приема платежей https://tarlanpayments.kz

Payment package tarlanpayments api for laravel 5.2 - 5.8

## Install
```
composer require tarlanpayments/payments
```

## For laravel 5.8 
    
### Service provider to config/app.php

```
  TarlanPayments\Payments\PaymentServiceProvider::class
```

### Facade 

``` 
'TarlanPay' => \TarlanPayments\Payments\Facades\TarlanPay::class
```

## Publish config file 

```
  php artisan vendor:publish
```

## TarlanPay requests

### Basic auth pay example
```php
$pay =  TarlanPay::paymentCreate([
              'secret_key' => reference_id+secret_key,
              'merchant_id' => '4'
              'reference_id' => '11111111',
              'request_url' => 'your-site.kz',
              'back_url' => 'your-site.kz',
              'amount' => 9999,
              'user_id' => 'your-email@gmail.com',              
        ]);
          
$pay->generateUrl();
```

### Check pay example
```php
$checkPay = TarlanPay::paymentStatus( [ 'reference_id' => '11111111' ] );

$response = Epay::request( $checkPay->generateUrl() );
```

## Epay responses
