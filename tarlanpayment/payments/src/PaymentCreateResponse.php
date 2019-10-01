<?php

namespace TarlanPayment\Payments;

/**
 *
 * Class PaymentCreateResponse
 * @package TarlanPayment\Payments
 */
class PaymentCreateResponse
{

    protected $transaction_id;
    protected $status;
    protected $reference_id;
    protected $secret_key;

    public function __construct($rawResponse)
    {

        $parsedResponse = json_decode($rawResponse);

        $this->transaction_id = $parsedResponse['transaction_id'];
        $this->status = $parsedResponse['status'];
        $this->reference_id = $parsedResponse['reference_id'];
        $this->secret_key = $parsedResponse['secret_key'];
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {

        return $this->transaction_id;
    }

    /**
     * @return string
     */
    public function getStatus()
    {

        return $this->status;
    }

    /**
     * @return string
     */
    public function getReferenceId()
    {

        return $this->reference_id;
    }


    /**
     * @return string
     */
    public function getSecretKey()
    {

        return $this->secret_key;
    }

    public function isSuccess(array $params = [])
    {

        $defaultParams = [
            'merchant_id' => app()->get('epay')->merchant_id,
            'response_code' => '00'
        ];

        $params = array_merge($params, $defaultParams);

        return $this->validateSign() && parent::isSuccess($params);
    }
}
