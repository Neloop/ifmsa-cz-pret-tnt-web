<?php

namespace App\Helpers;

use Nette\Utils\Arrays;

/**
 * Parameters defined in config files concerning website private settings.
 */
class PrivateParams
{
    /**
     * Username used for authentication in private parts of website.
     * @var string
     */
    protected $username;
    /**
     * Password used for authentication in private parts of website.
     * @var string
     */
    protected $password;

    /**
     * Constructor initialized via DI.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->username = Arrays::get($config, ["username"], "");
        $this->password = Arrays::get($config, ["password"], "");
    }

    /**
     * Get username.
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Get password.
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
