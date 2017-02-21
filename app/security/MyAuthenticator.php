<?php

namespace App\Security;

use App\Helpers\PrivateParams;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;
use Nette\Security\AuthenticationException;

/**
 * Simple authenticator which uses only one username and password for
 * authentication. Credentials are taken from application configuration files.
 */
class MyAuthenticator implements IAuthenticator
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
     * @param array $credentials
     * @return Identity
     * @throws AuthenticationException if username or password is incorrect
     */
    public function authenticate(array $credentials)
    {
        list($username, $password) = $credentials;

        if ($username !== $this->privateParams->getUsername()) {
            throw new AuthenticationException("User '{$username}' not found.");
        } elseif ($password !== $this->privateParams->getPassword()) {
            throw new AuthenticationException("Invalid password");
        }

        return new Identity($username);
    }
}
