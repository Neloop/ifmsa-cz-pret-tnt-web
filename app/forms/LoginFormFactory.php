<?php

namespace App\Forms;

use Nette;
use Nette\Security\User;

/**
 * Factory which handles login form and authentication used within private parts
 * of the application.
 */
class LoginFormFactory
{
    /**
     * Nette user.
     * @var User
     */
    private $user;

    /**
     * Constructor initialized via DI.
     * @param User $user nette user instance
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Create login form and return it.
     * @return BootstrapForm
     */
    public function createLoginForm(): BootstrapForm
    {
        $form = new BootstrapForm;

        $form->addText('username', 'Username')
                ->setRequired('Please enter your username.')
                ->setHtmlAttribute('autofocus');

        $form->addPassword('password', 'Password')
                ->setRequired('Please enter your password.');

        $form->addSubmit('send', 'Login');
        $form->onSuccess[] = array($this, 'loginFormSucceeded');
        return $form;
    }

    /**
     * If submit of login form succeeded this callback is called. User is
     * authenticated through simple authenticator.
     * @param BootstrapForm $form
     * @param object $values
     */
    public function loginFormSucceeded(BootstrapForm $form, $values): void
    {
        try {
            $this->user->setExpiration('60 minutes');
            $this->user->login($values->username, $values->password);
        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError($e->getMessage());
        }
    }
}
