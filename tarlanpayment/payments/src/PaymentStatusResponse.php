<?php

namespace TarlanPayment\Payments;

/**
 * Class PaymentStatusResponse
 * @package TarlanPayment\Payments
 */
class PaymentStatusResponse
{

    const STATUS_NEW = 0;
    const STATUS_OK = 1;
    const STATUS_PROCESS = 2;
    const STATUS_AUTHORIZED = 3;
    const STATUS_CANCELED = 4;
    const STATUS_REFUND = 5;
    const STATUS_FAILED = 6;

    const VALIDATION_ERROR = 101;
    const UNAUTHORIZED_ERROR = 102;
    const SYSTEM_ERROR = 103;

    protected $success;
    protected $data;
    protected $message;
    protected $error_code;

    /**
     * PaymentStatusResponse constructor.
     * @param string $rawResponse
     * @param array|null $mappedParams
     */
    public function __construct($rawResponse)
    {

        $this->result = json_decode($rawResponse, true);

        $this->parseResult($this->result);
    }

    public function parseResult($jsonResponse)
    {

        $this->success = $jsonResponse['success'];
        $this->data = $this->mapParameters($jsonResponse['data']);
        $this->message = $jsonResponse['message'];
        $this->error_code = $jsonResponse['error_code'];
    }

    public function mapParameters($rawArrayData)
    {

        $arrayData = [];
        foreach ($rawArrayData as $row) {

            $data = [];
            foreach ($row as $key => $value) {

                $data[$key] = $value;
            }

            array_push($arrayData, $data);
        }
        return $arrayData;
    }

    public function getSuccess()
    {

        return $this->success;
    }

    public function getData()
    {

        return $this->data;
    }

    public function getMessage()
    {

        return $this->message;
    }

    public function getErrorCode()
    {

        return $this->error_code;
    }

    public static function getPayStatus()
    {
        return [
            0 => self::STATUS_NEW,
            1 => self::STATUS_OK,
            2 => self::STATUS_PROCESS,
            3 => self::STATUS_AUTHORIZED,
            4 => self::STATUS_CANCELED,
            5 => self::STATUS_REFUND,
            6 => self::STATUS_FAILED,

        ];
    }
}
