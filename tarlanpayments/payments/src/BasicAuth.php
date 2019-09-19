<?php
namespace TarlanPayments\Payments;

use Illuminate\Support\Facades\Validator;

/**
 * Class BasicAuth
 * @package packages\tarlanpayments\payments\src
 */
class BasicAuth extends  TarlanPay
{

    public function __construct($params)
    {
        /**
         * BasicPay constructor.
         * @param array $params
         */
        parent::__construct();

        $this->request_url      = $params('request_url');
        $this->reference_id     = $params['reference_id'] ?? null;
        $this->amount           = $params['amount'] ?? 0;
        $this->user_id          = $params['user_id'];
        $this->user_email       = $params['user_email'] ?? '';
        $this->hashed_key       =password_hash(
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
                'hashed_key'     => $this->secret_key,
                'user_email'     => $this->user_email
            ]
        );

        $validator = Validator::make( $params->all(),
            [
                'amount'         => 'required',
                'merchant_id'    => 'required',
                'reference_id'   => 'required',
                'hashed_key'     => 'required',
                'request_url'    => 'required',
                'back_url'       => 'required',
                'description'    => 'max:512|required',
                'user_id'        => 'numeric|required',
                'user_email'     => 'email|nullable'
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
            'hashed_key',
            'user_email'
        ])->toArray();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->tarlan_server . 'invoice/create');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $paramsArray);

        $response = json_decode(curl_exec($ch));

        curl_close ($ch);

        if($response['success'])
        {
            return $response['redirect_url'];
        }

    }

}
