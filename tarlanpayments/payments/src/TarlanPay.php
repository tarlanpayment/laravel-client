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
        $this->back_url         = config('tarlanpayment.BACK_URL');
        $this->secret_key       = 'qrR-QrHMbIQNZCLGzFldkqxXJ9Bzjl0f';

    }

    private function setProductionParams()
    {
        $this->merchant_id      = config('tarlanpayment.MERCHANT_ID');
        $this->back_url         = config('tarlanpayment.BACK_URL');
        $this->secret_key       = config('tarlanpayment.SECRET_KEY');

    }

    /**
     * @param $params
     * @return BasicAuth
     */
    public function basicAuth($params)
    {
        return new BasicAuth($params);
    }

    /**
     * @param $params
     * @return CheckPay
     */
    public function checkPay($params)
    {
        return new CheckPay($params);
    }


}
