<?php

namespace App\Presenters;

use Nette;
use App\Model\Repository\Participants;
use App\Model\Repository\PaymentTransactions;
use App\Helpers\Payment\PaymentTransactionsHelper;
use App\Exceptions\PaymentException;

class PaymentPresenter extends BasePresenter
{
    /**
     * @var Participants
     * @inject
     */
    public $participants;
    /**
     * @var PaymentTransactionsHelper
     * @inject
     */
    public $paymentTransactionsHelper;
    /**
     * @var Nette\Http\Request
     * @inject
     */
    public $httpRequest;
    /**
     * @var PaymentTransactions
     * @inject
     */
    public $paymentTransactions;

    public function actionStartTransaction($id)
    {
        $participant = $this->participants->findOrThrow($id);
        if ($participant->paid) {
            $this->error("Participant already paid");
        }

        // prepare vars
        $description = "hello"; // TODO
        $amount = 100;

        // start transaction
        try {
            list($url, $transaction) =
                    $this->paymentTransactionsHelper->startTransaction(
                        $description,
                        $amount,
                        $this->httpRequest->getRemoteAddress()
                    );

            // save transaction to participant
            $participant->paymentTransaction = $transaction;
            $this->participants->flush();

            // and finally redirect user to gateway
            //$this->redirectUrl($url);
            $this->redirect("Payment:transactionOk", $transaction->transactionId); // TODO
        } catch (PaymentException $e) {
            $this->error($e->getMessage());
        }
    }

    public function actionTransactionOk($transId)
    {
        $transaction = $this->paymentTransactions->findOneByTransactionId($transId);
        if (!$transaction) {
            $this->error("Access Denied");
        }

        try {
            $correct = $this->paymentTransactionsHelper->processTransactionOk($transaction);
            if ($correct) {
                // just let us know that transaction is ok to our database
                $participant = $transaction->eventParticipant;
                $participant->paid = true;
                $this->eventParticipants->flush();
            } else {
                $this->redirect("Payment:transactionIncorrect", urlencode($transId));
            }
        } catch (PaymentException $e) {
            $this->error($e->getMessage());
        }
    }

    public function actionTransactionIncorrect($transId)
    {
        $transaction = $this->paymentTransactions->findOneByTransactionId($transId);
        if (!$transaction) {
            $this->error("Access Denied");
        }

        $this->template->result = $transaction->result;
    }

    public function actionTransactionFail($transId, $errorMsg)
    {
        $transaction = $this->paymentTransactions->findOneByTransactionId($transId);
        if (!$transaction) {
            $this->error("Access Denied");
        }

        $this->paymentTransactionsHelper->processTransactionFail($transaction, $errorMsg);
    }
}
