<?php

namespace App\Helpers\Payment;

use GuzzleHttp;

class PaymentConnection
{
    /** @var PaymentParams */
    private $paymentParams;
    /** @var GuzzleHttp\Client */
    private $guzzleClient;

    public function __construct(PaymentParams $paymentParams)
    {
        $this->paymentParams = $paymentParams;
        $this->guzzleClient = new GuzzleHttp\Client(array(
            //"verify" => \Composer\CaBundle\CaBundle::getSystemCaRootBundlePath(),
            "verify" => false,
            "query" => ["key" => $paymentParams->serverAuthKey]
        ));
    }

    public function startTransaction($amount, $ip, $desc, $currency)
    {
        $response = $this->guzzleClient->post($this->paymentParams->serverStartTransactionUrl, array(
            "form_params" => array(
                "service" => $this->paymentParams->service,
                "amount" => $amount,
                "currency" => $currency,
                "ipAddress" => $ip,
                "description" => $desc
            )
        ));
        return $response->getBody();
    }

    public function getTransactionResult($transactionId)
    {
        $response = $this->guzzleClient->post($this->paymentParams->serverGetTransactionResultUrl, array(
            "form_params" => array(
                "service" => $this->paymentParams->service,
                "transactionId" => $transactionId
            )
        ));
        return $response->getBody();
    }
}
