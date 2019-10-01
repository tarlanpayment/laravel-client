<?php
namespace TarlanPayment\Payments;

use TarlanPayment\Payments\PaymentCreateResponse;
use TarlanPayment\Payments\PaymentStatusResponse;
use TarlanPayment\Payments\PaymentCreate;
use TarlanPayment\Payments\PaymentStatus;

class TarlanPay
{
    /**
     * @var
     */
    public $tarlan_server = 'https://api.tarlanpayments.kz';
    /**
     * @var
     */
    public $merchant_id;
    /**
     * @var
     */
    public $amount;
    /**
     * @var
     */
    public $description;
    /**
     * @var
     */
    public $back_url;
    /**
     * @var
     */
    public $request_url;
    /**
     * @var
     */
    public $reference_id;
    /**
     * @var
     */
    public $secret_key;
    /**
     * @var
     */
    public $hashed_key;
    /**
     * @var
     */
    public $user_id;
    /**
     * @var
     */
    public $user_email;
    /**
     * @var
     */
    public $currency;
    /**
     * @var
     */
    public $transaction_ids;
    /**
     * @var
     */
    public $is_test;

    /**
     * @param array $params
     */
    public function __construct()
    {

        config('tarlanpayment.pay_test_mode', true) ? $this->setTestParams() : $this->setProductionParams();
    }

    private function setTestParams()
    {

        $this->is_test = true;
        $this->merchant_id      = 4;
        $this->secret_key       = 'qrR-QrHMbIQNZCLGzFldkqxXJ9Bzjl0f';
    }

    private function setProductionParams()
    {

        $this->merchant_id      = config('tarlanpayment.merchant_id');
        $this->secret_key       = config('tarlanpayment.secret_key');
    }

    public function paymentCreate($params)
    {

        return new PaymentCreate($params);
    }

    public function paymentStatus($params)
    {

        return new PaymentStatus($params);
    }

    public function handlePaymentCreateResponse($rawResponse)
    {

        return new PaymentCreateResponse($rawResponse);
    }

    public function handlePaymentStatusResponse($rawResponse)
    {

        return new PaymentStatusResponse($rawResponse);
    }

    /**
     * @param $url
     * @return mixed
     */
    public function request($url)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
