<?php

namespace App\Helpers\Payment;

use GuzzleHttp;

/**
 * An actual connection with the remote server which is providing payment
 * gateway. In this case requests are sent to CUK (CatUnicornKiller) system and
 * its REST endpoints. Requests are made with the help of guzzle library.
 */
class PaymentConnection
{
    /**
     * Payment parameters from config files.
     * @var PaymentParams
     */
    private $paymentParams;
    /**
     * Guzzle HTTP client.
     * @var GuzzleHttp\Client
     */
    private $guzzleClient;

    /**
     * Constructor initialized via DI.
     * @param PaymentParams $paymentParams
     */
    public function __construct(PaymentParams $paymentParams)
    {
        $this->paymentParams = $paymentParams;
        $this->guzzleClient = new GuzzleHttp\Client(array(
            //"verify" => \Composer\CaBundle\CaBundle::getSystemCaRootBundlePath(),
            "verify" => false,
            "query" => ["key" => $paymentParams->getServerAuthKey()]
        ));
    }

    /**
     * Start transaction by requesting start of transaction on the remote
     * server. Request is POST and response from server is in form of JSON data.
     * @param int $amount
     * @param string $ip
     * @param string $desc
     * @param string $currency
     * @return string JSON response
     */
    public function startTransaction($amount, $ip, $desc, $currency): string
    {
        $response = $this->guzzleClient->post($this->paymentParams->getServerStartTransactionUrl(), array(
            "form_params" => array(
                "service" => $this->paymentParams->getService(),
                "amount" => $amount,
                "currency" => $currency,
                "ipAddress" => $ip,
                "description" => $desc
            )
        ));
        return $response->getBody();
    }

    /**
     * Get result of transaction with given transaction identification from
     * remote server. Request is POST and response from server is in form of
     * JSON data.
     * @param string $transactionId transaction identification
     * @return string JSON response
     */
    public function getTransactionResult($transactionId): string
    {
        $response = $this->guzzleClient->post($this->paymentParams->getServerGetTransactionResultUrl(), array(
            "form_params" => array(
                "service" => $this->paymentParams->getService(),
                "transactionId" => $transactionId
            )
        ));
        return $response->getBody();
    }
}
