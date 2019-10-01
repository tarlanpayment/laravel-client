<?php
namespace TarlanPayment\Payments;

use Illuminate\Support\Facades\Validator;

/**
 * Class PaymentCreate
 * @package TarlanPayment\Payments
 */
class PaymentCreate extends  TarlanPay
{

    public function __construct($params)
    {
        /**
         * BasicPay constructor.
         * @param array $params
         */
        parent::__construct();

        $this->request_url      = $params['request_url'];
        $this->back_url         = $params['back_url'];
        $this->reference_id     = $params['reference_id'] ?? null;
        $this->amount           = $params['amount'] ?? 0;
        $this->user_id          = $params['user_id'];
        $this->user_email       = $params['user_email'] ?? '';
        $this->description      = $params['description'] ?? '';
        $this->hashed_key       = password_hash(
            $this->reference_id.$this->secret_key,
            PASSWORD_BCRYPT,
            ['cost' => 10]
        );
    }

    /**
     * Generate url for epay
     * @return string|array
     */
    public function generateUrl()
    {
        $params = collect(
            [
                'reference_id'   => $this->reference_id,
                'request_url'    => $this->request_url,
                'back_url'       => $this->back_url,
                'description'    => $this->description,
                'amount'         => $this->amount,
                'merchant_id'    => $this->merchant_id,
                'user_id'        => $this->user_id,
                'secret_key'     => $this->hashed_key,
                'user_email'     => $this->user_email,
                'is_test'        => $this->is_test
            ]
        );

        $validator = Validator::make( $params->all(),
            [
                'amount'         => 'required',
                'merchant_id'    => 'required',
                'reference_id'   => 'required',
                'secret_key'     => 'required',
                'request_url'    => 'required',
                'back_url'       => 'required',
                'description'    => 'max:512|required',
                'user_id'        => 'numeric|required',
                'user_email'     => 'email|nullable',
                'is_test'        => 'required'

            ]
        );

        if($validator->fails())
        {
            return $validator->errors();
        }

        $paramsArray = $params->only([
            'reference_id',
            'request_url',
            'back_url',
            'description',
            'amount',
            'merchant_id',
            'user_id',
            'secret_key',
            'is_test'
        ])->toArray();

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL, 'https://api.tarlanpayments.kz/invoice/create');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $paramsArray);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        curl_close($ch);
        $response = \json_decode($response, true);

        return $response['data']['redirect_url'];
    }
}


