<?php

namespace App\Helpers\Payment;

class PaymentParams
{
    public $service;
    public $serverAuthKey;
    public $serverStartTransactionUrl;
    public $serverGetTransactionResultUrl;

    public function __construct(array $params)
    {
        $this->service = $params['service'];
        $this->serverAuthKey = $params['serverAuthKey'];
        $this->serverStartTransactionUrl = $params['serverStartTransactionUrl'];
        $this->serverGetTransactionResultUrl = $params['serverGetTransactionResultUrl'];
    }
}
