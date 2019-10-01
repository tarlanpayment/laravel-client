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

### Invoice create example
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

### Payment status check example
```php
$checkPay = TarlanPay::paymentStatus( [ 'reference_id' => '11111111' ] );

$response = TaralanPay::request( $checkPay->generateUrl() );
```

## Epay responses
### Payment Create BACK_LINK response handling example 
```php
 $jsonResponse = request('json');

        if($jsonResponse)
        {
            $payResponse = TarlanPay::handlePaymentCreate($jsonResponse);

            Log::info( 'transaction_id='.$payResponse->getTransactionId() );
            Log::info( 'status='.$payResponse->getStatus() );
            Log::info( 'reference_id='.$payResponse->getReferenceId() );
        }
```
### Payment Status response handling example 
```php
$obj = TarlanPay::paymentStatus( request()->all() );
       $response = TarlanPay::request( $obj->generateUrl() );

       if($response) {
           $checkPaymentResponse = TarlanPay::handlePaymentStatusResponse( $response );
           dd($checkPaymentResponse->getData());

           Log::info('status='.$checkPaymentResponse->getData());
           Log::info('message='.$checkPaymentResponse->getMessage());
           Log::info('data='.$checkPaymentResponse->getData());
           Log::info('error_code='.$checkPaymentResponse->getErrorCode());
       }

Payment status:
    const STATUS_NEW = 0;
    const STATUS_OK = 1;
    const STATUS_PROCESS = 2;
    const STATUS_AUTHORIZED = 3;
    const STATUS_CANCELED = 4;
    const STATUS_REFUND = 5;
    const STATUS_FAILED = 6;
```
