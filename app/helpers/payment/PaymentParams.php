<?php

namespace App\Helpers\Payment;

use Nette;

/**
 * Parameters defined in config files concerning events payment.
 */
class PaymentParams extends Nette\Object
{
    /**
     * Identification of this service which is used in CUK payment gateway.
     * @var string
     */
    private $service;
    /**
     * Currency in the proper three number format.
     * @var string
     */
    private $currency;
    /**
     * Access key used in CUK payment gateway.
     * @var string
     */
    private $serverAuthKey;
    /**
     * Address where transaction start endpoint resides.
     * @var string
     */
    private $serverStartTransactionUrl;
    /**
     * Address where get transaction results endpoint resides.
     * @var string
     */
    private $serverGetTransactionResultUrl;

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
     * Gets service identification.
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * Gets currency.
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * Gets CUK payment gateway access key.
     * @return string
     */
    public function getServerAuthKey(): string
    {
        return $this->serverAuthKey;
    }

    /**
     * Gets address of start transaction endpoint.
     * @return string
     */
    public function getServerStartTransactionUrl(): string
    {
        return $this->serverStartTransactionUrl;
    }

    /**
     * Gets address of get transaction results endpoint.
     * @return string
     */
    public function getServerGetTransactionResultUrl(): string
    {
        return $this->serverGetTransactionResultUrl;
    }
}
