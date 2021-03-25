<?php

namespace App\Presenters;

use App\Model\Entity\PaymentTransaction;
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

    public function actionStartTransaction(string $id): void
    {
        $participant = $this->participants->findOrThrow($id);
        if ($participant->isPaid()) {
            $this->redirect("Payment:transactionPaid");
        }

        // prepare vars
        $description = "Type:{$participant->getPretOrTnt()};";
        $description .= "Email:{$participant->getEmail()};";
        $description .= "RegDate:{$participant->getRegistrationDateUtc()->format('Y-m-d H:i:s')}";

        if ($participant->isPret()) {
            $amount = $this->pretEventHelper->getParticipantFee($participant);
        } else {
            $amount = $this->tntEventHelper->getParticipantFee($participant);
        }

        // start transaction
        try {
            /** @var PaymentTransaction $transaction */
            list($url, $transaction) =
                    $this->paymentTransactionsHelper->startTransaction(
                        $description,
                        $amount,
                        $this->httpRequest->getRemoteAddress()
                    );

            // save transaction to participant
            $transaction->setParticipant($participant);
            $this->paymentTransactions->flush();

            // and finally redirect user to gateway
            $this->redirectUrl($url);
        } catch (PaymentException $e) {
            $this->error($e->getMessage());
        }
    }

    public function actionTransactionOk(string $transId): void
    {
        $transaction = $this->paymentTransactions->findOneByTransactionId($transId);
        if (!$transaction) {
            $this->error("Access Denied");
        }

        if ($transaction->getParticipant()->isPaid()) {
            $this->redirect("Payment:transactionPaid");
        }

        try {
            $correct = $this->paymentTransactionsHelper->processTransactionOk($transaction);
            if ($correct) {
                // just let us know that transaction is ok to our database
                $participant = $transaction->getParticipant();
                $participant->setPaid(true);
                $this->participants->flush();
            } else {
                $this->forward("Payment:transactionIncorrect", $transId);
            }
        } catch (PaymentException $e) {
            $this->forward("Payment:transactionIncorrect", $transId);
        }
    }

    public function actionTransactionIncorrect(string $transId): void
    {
        $transaction = $this->paymentTransactions->findOneByTransactionId($transId);
        if (!$transaction) {
            $this->error("Access Denied");
        }

        $this->template->result = $transaction->getResult();
    }

    public function actionTransactionFail(string $transId, string $errorMsg): void
    {
        $transaction = $this->paymentTransactions->findOneByTransactionId($transId);
        if (!$transaction) {
            $this->error("Access Denied");
        }

        $this->paymentTransactionsHelper->processTransactionFail($transaction, $errorMsg);
    }
}
