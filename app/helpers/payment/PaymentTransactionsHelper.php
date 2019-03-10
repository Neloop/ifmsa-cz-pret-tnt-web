<?php

namespace App\Helpers\Payment;

use App\Model\Entity\PaymentError;
use App\Model\Entity\PaymentTransaction;
use App\Model\Repository\PaymentErrors;
use App\Model\Repository\PaymentTransactions;
use App\Exceptions\PaymentException;

/**
 * Payment gateway transaction helper which manages connection to the remote
 * server through @see PaymentConnection and also take care of all appropriate
 * database entities like @see PaymentTransaction and @see PaymentError.
 */
class PaymentTransactionsHelper
{
    /**
     * Payment parameters from config files.
     * @var PaymentParams
     */
    private $paymentParams;
    /**
     * Actual connection helper to the remote server.
     * @var PaymentConnection
     */
    private $paymentConnection;
    /**
     * Payment errors repository.
     * @var PaymentErrors
     */
    private $paymentErrors;
    /**
     * Payment transactions repository.
     * @var PaymentTransactions
     */
    private $paymentTransactions;

    /**
     * Constructor initialized via DI.
     * @param PaymentParams $paymentParams
     * @param PaymentConnection $paymentConnection
     * @param PaymentErrors $paymentErrors
     * @param PaymentTransactions $paymentTransactions
     */
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
     * Start transaction by requesting transaction info from remote server and
     * then examination of response. If the response is successful and in the
     * right format, return URL where payment page is located and transaction
     * entity.
     * @param string $description description of new transaction
     * @param int $amount amount in whole crowns or euros.
     * @param string $ip IP address of client which requested payment
     * @return array($url, $transaction) Redirection URL where payment gateway
     * is placed and transaction entity.
     * @throws PaymentException if transaction initialization failed
     */
    public function startTransaction(
        string $description,
        int $amount,
        string $ip
    ): array {

        // create connection and register transaction
        $response =
                $this->paymentConnection->startTransaction(
                    $amount * 100,
                    $ip,
                    $description,
                    $this->paymentParams->getCurrency()
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

            throw new PaymentException('Transaction initialization failed, '
                    . 'error logged');
        }
    }

    /**
     * Response from payment gateway was successful, now process results and
     * write them into database. If the transaction was correct return true,
     * otherwise return false.
     * @param PaymentTransaction $transaction
     * @return bool True if transaction was successful, false if transaction
     * was incorrect.
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
     * Payment failed critically and it need to be processed and stored.
     * @param PaymentTransaction $transaction
     * @param string $errorMsg error message
     */
    public function processTransactionFail(
        PaymentTransaction $transaction,
        string $errorMsg
    ) {
    
        // get information from merchant and store them in database
        $response = $this->paymentConnection->getTransactionResult(
            $transaction->transactionId
        );
        $response = $errorMsg . ' + ' . $response;

        $error = new PaymentError('returnFailURL', $response);
        $this->paymentErrors->persist($error);
    }
}
