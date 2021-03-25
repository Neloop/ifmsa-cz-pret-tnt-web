<?php

namespace App\Security;

use App\Helpers\PrivateParams;
use Nette\Security\Authenticator;
use Nette\Security\AuthenticationException;
use Nette\Security\IIdentity;
use Nette\Security\SimpleIdentity;

/**
 * Simple authenticator which uses only one username and password for
 * authentication. Credentials are taken from application configuration files.
 */
class MyAuthenticator implements Authenticator
{

    /**
     * Private application parameters from config file.
     * @var PrivateParams
     */
    private $privateParams;

    /**
     * Constructor initialized via DI.
     * @param PrivateParams $privateParams
     */
    public function __construct(PrivateParams $privateParams)
    {
        $this->privateParams = $privateParams;
    }

    /**
     * Authenticates user with given credentials against default ones.
     * @param string $user
     * @param string $password
     * @return IIdentity
     * @throws AuthenticationException if username or password is incorrect
     */
    public function authenticate(string $user, string $password): IIdentity
    {
        if ($user !== $this->privateParams->getUsername()) {
            throw new AuthenticationException("User '{$user}' not found.");
        } elseif ($password !== $this->privateParams->getPassword()) {
            throw new AuthenticationException("Invalid password");
        }

        return new SimpleIdentity($user);
    }
}
