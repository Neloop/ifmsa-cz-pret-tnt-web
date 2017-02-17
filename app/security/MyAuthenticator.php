<?php

namespace App\Security;

use App\Helpers\PrivateParams;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;
use Nette\Security\AuthenticationException;

/**
 * Description of MyAuthenticator
 *
 * @author Neloop
 */
class MyAuthenticator implements IAuthenticator
{

    /** PrivateParams */
    private $privateParams;

    public function __construct(PrivateParams $privateParams)
    {
        $this->privateParams = $privateParams;
    }

    /**
     * Authenticates user against given credentials.
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
