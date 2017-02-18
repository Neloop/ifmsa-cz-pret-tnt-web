<?php

namespace App\Helpers;

use Nette\Utils\Arrays;

class PrivateParams
{
    protected $username;
    protected $password;

    public function __construct(array $config)
    {
        $this->username = Arrays::get($config, ["username"], "");
        $this->password = Arrays::get($config, ["password"], "");
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
