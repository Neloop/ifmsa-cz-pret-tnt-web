<?php

namespace App\Presenters;

use App\Forms\RegistrationFormsFactory;

class RegistrationPresenter extends BasePresenter
{
    /**
     * @var RegistrationFormsFactory
     * @inject
     */
    public $registrationFormsFactory;

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
}
