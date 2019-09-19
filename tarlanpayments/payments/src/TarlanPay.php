<?php

namespace TarlanPayments\Payments;

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
     * @param array $params
     */
    public function __construct()
    {
        config('tarlanpayment.pay_test_mode', true) ? $this->setTestParams() : $this->setProductionParams();
    }

    private function setTestParams()
    {
        $this->merchant_id      = '4';
        $this->secret_key       = 'qrR-QrHMbIQNZCLGzFldkqxXJ9Bzjl0f';

    }

    private function setProductionParams()
    {
        $this->merchant_id      = config('tarlanpayment.merchant_id');
        $this->secret_key       = config('tarlanpayment.secret_key');

    }

    /**
     * @param $params
     * @return PaymentCreate
     */
    public function paymentCreate($params)
    {
        return new PaymentCreate($params);
    }

    /**
     * @param $params
     * @return PaymentStatus
     */
    public function paymentStatus($params)
    {
        return new PaymentStatus($params);
    }

    /**
     * @param $url
     * @return mixed
     */
    public function request($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->request_timeout); // times out after 4s
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        $result = curl_exec($ch); // run the whole process
        curl_close($ch);
        return $result;
    }

}
