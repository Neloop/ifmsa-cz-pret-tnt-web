<?php

namespace App\Presenters;

use App\Forms\BootstrapForm;
use Nette;
use App\Helpers\PrivateParams;
use App\Model\Repository\Participants;
use App\Model\Repository\PaymentTransactions;
use App\Helpers\RegistrationLabelsHelper;
use App\Helpers\Emails\PaymentEmailsSender;
use App\Helpers\PretEventHelper;
use App\Helpers\TntEventHelper;
use App\Helpers\Table\TransactionsTableFactory;
use App\Helpers\ResponseHelper;
use App\Forms\LoginFormFactory;
use Nette\Application\Responses\TextResponse;

class PrivatePresenter extends BasePresenter
{
    /**
     * @var PrivateParams
     * @inject
     */
    public $privateParams;

    /**
     * @var Participants
     * @inject
     */
    public $participants;

    /**
     * @var RegistrationLabelsHelper
     * @inject
     */
    public $registrationLabelsHelper;

    /**
     * @var LoginFormFactory
     * @inject
     */
    public $loginFormFactory;

    /**
     * @var PaymentEmailsSender
     * @inject
     */
    public $paymentEmailsSender;

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

    /**
     * @var ResponseHelper
     * @inject
     */
    public $responseHelper;

    /**
     * @var TransactionsTableFactory
     * @inject
     */
    public $transactionsTableFactory;

    /**
     * @var PaymentTransactions
     * @inject
     */
    public $paymentTransactions;

    protected function createComponentLoginForm(): BootstrapForm
    {
        $form = $this->loginFormFactory->createLoginForm();
        $form->onSuccess[] = function () {
            $this->flashMessage('You have been succesfully logged in.', "success");
            $this->redirect("Private:list");
        };
        return $form;
    }

    private function isLoggedIn(): void
    {
        if (!$this->user->isLoggedIn()) {
            $this->redirect("Private:");
        }
    }

    public function actionDefault(): void
    {
        if ($this->user->isLoggedIn()) {
            $this->redirect("Private:list");
        }
    }

    public function actionList(): void
    {
        $this->isLoggedIn();

        $this->template->participants = $this->participants->findAll();
        $this->template->participantsCount = $this->participants->countAll();
        $this->template->pretParticipantsCount = $this->participants->countPretParticipants();
        $this->template->tntParticipantsCount = $this->participants->countTntParticipants();
    }

    public function actionParticipant(string $id): void
    {
        $this->isLoggedIn();

        $this->template->labelsHelper = $this->registrationLabelsHelper;
        $this->template->participant = $participant = $this->participants->findOrThrow($id);

        if ($participant->isPret()) {
            $this->template->fee = $this->pretEventHelper->getParticipantFee($participant);
            $this->template->currency = $this->pretEventHelper->getCurrency();
        } else {
            $this->template->fee = $this->tntEventHelper->getParticipantFee($participant);
            $this->template->currency = $this->tntEventHelper->getCurrency();
        }
    }

    public function actionSendPaymentEmail(string $id): void
    {
        $this->isLoggedIn();

        $participant = $this->participants->findOrThrow($id);
        if ($this->paymentEmailsSender->send($participant)) {
            $participant->setPaymentEmailSent(true);
            $this->participants->flush();
            $this->flashMessage("Payment Details Email successfully sent to participant", "success");
        } else {
            $this->flashMessage("Error during sending Payment Details Email, please try it again later", "warning");
        }

        $this->redirect("Private:participant", $id);
    }

    public function actionGenerateTransactionsTable(): void
    {
        $this->isLoggedIn();

        $content = $this->transactionsTableFactory->createTransactionsTable();
        $this->responseHelper->setXlsxFileResponse($this->getHttpResponse(), 'table.xlsx');
        $this->sendResponse(new TextResponse($content));
    }

    public function actionTransactions(): void
    {
        $this->isLoggedIn();

        $this->template->transactions = $this->paymentTransactions->findBy(array(), array("id" => "desc"));
        $this->template->transactionsCount = $this->paymentTransactions->countAll();
    }
}
