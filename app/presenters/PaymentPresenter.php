<?php

namespace App\Presenters;

use Nette;
use App\Model\Repository\Participants;
use App\Model\Repository\PaymentTransactions;
use App\Helpers\Payment\PaymentTransactionsHelper;
use App\Helpers\PretEventHelper;
use App\Helpers\TntEventHelper;
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
    /**
     * @var PretEventHelper
     * @inject
     */
    public $pretEventHelper;
    /**
     * @var TntEventHelper
     * @inject
     */
    public $tntEventHelper;

    public function actionStartTransaction($id)
    {
        $participant = $this->participants->findOrThrow($id);
        if ($participant->paid) {
            $this->redirect("Payment:transactionPaid");
        }

        // prepare vars
        $description = "Type:{$participant->pretOrTnt};";
        $description .= "Email:{$participant->email};";
        $description .= "RegDate:{$participant->registrationDateUtc->format('Y-m-d H:i:s')}";

        if ($participant->isPret()) {
            $amount = $this->pretEventHelper->getParticipantFee($participant);
        } else {
            $amount = $this->tntEventHelper->getParticipantFee($participant);
        }

        // start transaction
        try {
            list($url, $transaction) =
                    $this->paymentTransactionsHelper->startTransaction(
                        $description,
                        $amount,
                        $this->httpRequest->getRemoteAddress()
                    );

            // save transaction to participant
            $transaction->participant = $participant;
            $this->paymentTransactions->flush();

            // and finally redirect user to gateway
            $this->redirectUrl($url);
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

        if ($transaction->participant->paid) {
            $this->redirect("Payment:transactionPaid");
        }

        try {
            $correct = $this->paymentTransactionsHelper->processTransactionOk($transaction);
            if ($correct) {
                // just let us know that transaction is ok to our database
                $participant = $transaction->participant;
                $participant->paid = true;
                $this->participants->flush();
            } else {
                $this->redirect("Payment:transactionIncorrect", $transId);
            }
        } catch (PaymentException $e) {
            $this->redirect("Payment:transactionIncorrect", $transId);
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
