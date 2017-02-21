<?php

namespace App\Helpers\Payment;

use Nette;

/**
 * Parameters defined in config files concerning events payment.
 */
class PaymentParams extends Nette\Object
{
    /**
     *
     * @var string
     */
    public $service;
    /**
     *
     * @var string
     */
    public $currency;
    /**
     *
     * @var string
     */
    public $serverAuthKey;
    /**
     *
     * @var string
     */
    public $serverStartTransactionUrl;
    /**
     *
     * @var string
     */
    public $serverGetTransactionResultUrl;

    /**
     * Constructor initialized via DI.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->service = $params['service'];
        $this->currency = $params['currency'];
        $this->serverAuthKey = $params['serverAuthKey'];
        $this->serverStartTransactionUrl = $params['serverStartTransactionUrl'];
        $this->serverGetTransactionResultUrl = $params['serverGetTransactionResultUrl'];
    }

    /**
     *
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     *
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     *
     * @return string
     */
    public function getServerAuthKey(): string
    {
        return $this->serverAuthKey;
    }

    /**
     *
     * @return string
     */
    public function getServerStartTransactionUrl(): string
    {
        return $this->serverStartTransactionUrl;
    }

    /**
     *
     * @return string
     */
    public function getServerGetTransactionResultUrl(): string
    {
        return $this->serverGetTransactionResultUrl;
    }
}
