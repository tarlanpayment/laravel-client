<?php
namespace TarlanPayments\Payments;

/**
 * Class CheckPay
 * @package packages\TarlanPayments\Payments\src
 */
class CheckPay
{
    /**
     * @var
     */
    public $epay_url_server;

    /**
     * @var
     */
    public $transaction_ids;



    /**
     * CheckPay constructor.
     * @param array $params
     */
    public function __construct($params)
    {
        $this->epay_url_server = 'https://api.tarlanpayments.kz';
        $this->transaction_ids = $params['transaction_ids'] ?? null;
    }

    /**
     * generete url for to get epay status
     * @return string|array
     */
    public function generateUrl()
    {
        $params = collect(
            [
                'transaction_ids' => $this->transaction_ids
            ]
        );

        $validator = Validator::make( $params->all(),
            [
                'transaction_ids'    => 'required|array|min:1',
                'transaction_ids.*'  => 'required|distinct'
            ]
        );

        if($validator->fails())
        {
            return $validator->errors();
        }

        $queryString = http_build_query( $params->to_array() );

        $url = $this->epay_url_server. '/payment/status?' . $queryString;

        return $url;
    }
}

