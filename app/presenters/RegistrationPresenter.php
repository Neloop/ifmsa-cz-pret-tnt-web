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
            $this->redirect("Registration:completed");
        };
        return $form;
    }

    protected function createComponentTntRegistrationForm()
    {
        $form = $this->registrationFormsFactory->createTntRegistrationForm();
        $form->onSuccess[] = function () {
            $this->redirect("Registration:completed");
        };
        return $form;
    }
}
