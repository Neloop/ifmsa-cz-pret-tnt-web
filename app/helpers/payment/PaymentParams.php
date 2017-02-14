<?php

namespace App\Helpers\Payment;

class PaymentParams
{
    public $service;
    public $currency;
    public $serverAuthKey;
    public $serverStartTransactionUrl;
    public $serverGetTransactionResultUrl;

    public function __construct(array $params)
    {
        $this->service = $params['service'];
        $this->currency = $params['currency'];
        $this->serverAuthKey = $params['serverAuthKey'];
        $this->serverStartTransactionUrl = $params['serverStartTransactionUrl'];
        $this->serverGetTransactionResultUrl = $params['serverGetTransactionResultUrl'];
    }
}
