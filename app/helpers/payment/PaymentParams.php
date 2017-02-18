<?php

namespace App\Helpers\Payment;

use Nette;

class PaymentParams extends Nette\Object
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

    public function getService()
    {
        return $this->service;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getServerAuthKey()
    {
        return $this->serverAuthKey;
    }

    public function getServerStartTransactionUrl()
    {
        return $this->serverStartTransactionUrl;
    }

    public function getServerGetTransactionResultUrl()
    {
        return $this->serverGetTransactionResultUrl;
    }
}
