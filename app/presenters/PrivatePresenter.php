<?php

namespace App\Presenters;

use App\Helpers\PrivateParams;
use App\Model\Repository\Participants;
use App\Helpers\RegistrationLabelsHelper;
use App\Helpers\Emails\PaymentEmailsSender;
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
    }

    public function actionParticipant($id)
    {
        $this->isLoggedIn();

        $this->template->labelsHelper = $this->registrationLabelsHelper;
        $this->template->participant = $this->participants->findOrThrow($id);
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
