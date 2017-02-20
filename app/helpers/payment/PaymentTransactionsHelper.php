<?php

namespace App\Helpers\Payment;

use App\Model\Entity\PaymentError;
use App\Model\Entity\PaymentTransaction;
use App\Model\Repository\PaymentErrors;
use App\Model\Repository\PaymentTransactions;
use App\Exceptions\PaymentException;

/**
 * Description of PaymentTransactionsHelper
 *
 * @author Martin
 */
class PaymentTransactionsHelper
{
    /** @var PaymentParams */
    private $paymentParams;
    /** @var PaymentConnection */
    private $paymentConnection;
    /** @var PaymentErrors */
    private $paymentErrors;
    /** @var PaymentTransactions */
    private $paymentTransactions;

    public function __construct(
        PaymentParams $paymentParams,
        PaymentConnection $paymentConnection,
        PaymentErrors $paymentErrors,
        PaymentTransactions $paymentTransactions
    ) {
        $this->paymentParams = $paymentParams;
        $this->paymentConnection = $paymentConnection;
        $this->paymentErrors = $paymentErrors;
        $this->paymentTransactions = $paymentTransactions;
    }

    /**
     *
     * @param string $description
     * @param int $amount
     * @param string $ip
     * @return array($url, $transaction) Redirection URL where payment gateway is placed and transaction entity.
     * @throws PaymentException if transaction initialization failed
     */
    public function startTransaction(string $description, int $amount, string $ip): array
    {
        // create connection and register transaction
        $response =
                $this->paymentConnection->startTransaction(
                    $amount * 100,
                    $ip,
                    $description,
                    $this->paymentParams->currency
                );
        $respArray = json_decode($response, true);

        // process response from server
        if (array_key_exists("transactionId", $respArray) &&
                array_key_exists("url", $respArray)) {
            $transaction = new PaymentTransaction(
                $respArray["transactionId"],
                $amount,
                $ip,
                $description,
                $response
            );
            $this->paymentTransactions->persist($transaction);

            return array($respArray["url"], $transaction);
        } else {
            $error = new PaymentError('startTransaction', $response);
            $this->paymentErrors->persist($error);

            throw new PaymentException('Transaction initialization failed, error logged');
        }
    }

    /**
     *
     * @param PaymentTransaction $transaction
     * @return boolean True if transaction was successful, false if transaction was incorrect.
     * @throws PaymentException if transaction failed critically
     */
    public function processTransactionOk(PaymentTransaction $transaction)
    {
        $response = $this->paymentConnection->getTransactionResult(
            $transaction->transactionId
        );
        $respArray = json_decode($response, true);

        if (array_key_exists("result", $respArray)) {
            $result = $respArray["result"];
            $resultCode = $respArray["resultCode"];

            // write information about transaction into db
            $transaction->transactionEndDate = new \DateTime;
            $transaction->result = $result;
            $transaction->resultCode = $resultCode;
            $transaction->result3dsecure = $respArray["result3dsecure"];
            $transaction->cardNumber = $respArray["cardNumber"];
            $transaction->response = $response;
            $this->paymentTransactions->flush();

            return ($result == 'OK' && strlen($resultCode) == 3 &&
                    $resultCode[0] == '0');
        } else {
            $error = new PaymentError('returnOkURL', $response);
            $this->paymentErrors->persist($error);

            throw new PaymentException('Transaction failed');
        }
    }

    /**
     *
     * @param PaymentTransaction $transaction
     * @param string $errorMsg
     */
    public function processTransactionFail(PaymentTransaction $transaction, string $errorMsg)
    {
        // get information from merchant and store them in database
        $response = $this->paymentConnection->getTransactionResult(
            urlencode($transaction->transactionId)
        );
        $response = $errorMsg . ' + ' . $response;

        $error = new PaymentError('returnFailURL', $response);
        $this->paymentErrors->persist($error);
    }
}
