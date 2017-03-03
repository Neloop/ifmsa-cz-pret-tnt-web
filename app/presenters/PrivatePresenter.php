<?php

namespace App\Presenters;

use App\Helpers\PrivateParams;
use App\Model\Repository\Participants;
use App\Helpers\RegistrationLabelsHelper;
use App\Helpers\Emails\PaymentEmailsSender;
use App\Helpers\PretEventHelper;
use App\Helpers\TntEventHelper;
use App\Forms\LoginFormFactory;

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

    protected function createComponentLoginForm()
    {
        $form = $this->loginFormFactory->createLoginForm();
        $form->onSuccess[] = function () {
            $this->flashMessage('You have been succesfully logged in.', "success");
            $this->redirect("Private:list");
        };
        return $form;
    }

    private function isLoggedIn()
    {
        if (!$this->user->isLoggedIn()) {
            $this->redirect("Private:");
        }
    }

    public function actionDefault()
    {
        if ($this->user->isLoggedIn()) {
            $this->redirect("Private:list");
        }
    }

    public function actionList()
    {
        $this->isLoggedIn();

        $this->template->participants = $this->participants->findAll();
        $this->template->participantsCount = $this->participants->countAll();
        $this->template->pretParticipantsCount = $this->participants->countPretParticipants();
        $this->template->tntParticipantsCount = $this->participants->countTntParticipants();
    }

    public function actionParticipant($id)
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

    public function actionSendPaymentEmail($id)
    {
        $this->isLoggedIn();

        $participant = $this->participants->findOrThrow($id);
        if ($this->paymentEmailsSender->send($participant)) {
            $participant->paymentEmailSent = true;
            $this->participants->flush();
            $this->flashMessage("Payment Details Email successfully sent to participant", "success");
        } else {
            $this->flashMessage("Error during sending Payment Details Email, please try it again later", "warning");
        }

        $this->redirect("Private:participant", $id);
    }
}
