<?php

namespace App\Presenters;

use App\Forms\RegistrationFormsFactory;
use App\Helpers\PretEventHelper;
use App\Helpers\TntEventHelper;

class RegistrationPresenter extends BasePresenter
{
    /**
     * @var RegistrationFormsFactory
     * @inject
     */
    public $registrationFormsFactory;

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

    protected function createComponentPretRegistrationForm()
    {
        $form = $this->registrationFormsFactory->createPretRegistrationForm();
        $form->onSuccess[] = function () {
            $this->flashMessage("Your PRET registration was successful, further details were sent to your email account.", "success");
            $this->redirect("Homepage:");
        };
        return $form;
    }

    protected function createComponentTntRegistrationForm()
    {
        $form = $this->registrationFormsFactory->createTntRegistrationForm();
        $form->onSuccess[] = function () {
            $this->flashMessage("Your TNT registration was successful, further details were sent to your email account.", "success");
            $this->redirect("Homepage:");
        };
        return $form;
    }

    public function actionPretForm()
    {
        if (!$this->pretEventHelper->canRegisterNow()) {
            $this->flashMessage("Registration to PRET is already closed.");
            $this->redirect("Homepage:");
        }
    }

    public function actionTntForm()
    {
        if (!$this->tntEventHelper->canRegisterNow()) {
            $this->flashMessage("Registration to TNT is already closed.");
            $this->redirect("Homepage:");
        }
    }
}
