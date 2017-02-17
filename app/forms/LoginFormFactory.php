<?php

namespace App\Forms;

use Nette;
use Nette\Security\User;

/**
 *
 * @author Neloop
 */
class LoginFormFactory
{
    /** @var User */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function createLoginForm(): BootstrapForm
    {
        $form = new BootstrapForm;

        $form->addText('username', 'Username')
                ->setRequired('Please enter your username.')
                ->setAttribute('autofocus');

        $form->addPassword('password', 'Password')
                ->setRequired('Please enter your password.');

        $form->addSubmit('send', 'Login');
        $form->onSuccess[] = array($this, 'loginFormSucceeded');
        return $form;
    }

    public function loginFormSucceeded(BootstrapForm $form, $values)
    {
        try {
            $this->user->setExpiration('60 minutes', true);
            $this->user->login($values->username, $values->password);
        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError($e->getMessage());
        }
    }
}
