<?php
namespace TarlanPayment\Payments;

use Illuminate\Support\Facades\Validator;

/**
 * Class PaymentStatus
 * @package TarlanPayment\Payments
 */
class PaymentStatus extends TarlanPay
{

    /**
     * CheckPay constructor.
     * @param array $params
     */
    public function __construct($params)
    {
        parent::__construct();
        $this->transaction_ids = $params['transaction_ids'] ?? null;
    }

    /**
     * generete url for to get epay status api
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



        $queryString = http_build_query($params->toArray());

        $url = $this->tarlan_server. '/payment/status?' . $queryString;

        return $url;
    }
}
