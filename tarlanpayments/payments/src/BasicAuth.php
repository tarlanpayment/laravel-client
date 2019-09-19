<?php
namespace TarlanPayments\Payments;

use Illuminate\Support\Facades\Validator;
/**
 * Class BasicAuth
 * @package packages\tarlanpayments\payments\src
 */
class BasicAuth {
    /**
     * @var
     */
    public $epay_url_server;
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
    public $user_id;
    /**
     * @var
     */
    public $is_test;
    /**
     * @var
     */
    public $user_email;
    /**
     * @var
     */
    public $currency;
    /**
     * @param array $params
     */
    public function __construct($params)
    {
        $this->epay_url_server  = 'https://api.tarlanpayments.kz';
        $this->merchant_id      = config('tarlanpayment.MERCHANT_ID');
        $this->back_url         = config('tarlanpayment.BACK_URL');
        $this->description      = config('tarlanpayment.MERCHANT_ID');
        $secret_key = $params['reference_id'] . config('tarlanpayment.SECRET_KEY');
        $options = ['const' => 10];
        $this->secret_key       = password_hash($secret_key, PASSWORD_BCRYPT, $options);
        $this->currency         = $params['currency'] ?? $this->currency;

        $this->request_url      = $params('request_url');
        $this->reference_id     = $params['reference_id'] ?? null;
        $this->amount           = $params['amount'] ?? 0;
        $this->user_id          = $params['user_id'];
        $this->user_email       = $params['user_email'] ?? '';
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
                'secret_key'     => $this->secret_key,
                'user_email'     => $this->user_email
            ]
        );

        $validator = Validator::make( $params->all(),
            [
                'amount'         => 'required',
                'merchant_id'    => 'required',
                'reference_id'   => 'required',
                'sectet_key'     => 'required',
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
            'secret_key',
            'user_email'
        ])->toArray();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->epay_url_server . 'invoice/create');
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
