<?php

namespace App\Helpers;

use Nette\Utils\Arrays;

class AppParams
{
    protected $googleApiKey;

    public function __construct(array $config)
    {
        $this->googleApiKey = Arrays::get($config, ["googleApiKey"], "");
    }

    public function getGoogleApiKey()
    {
        return $this->googleApiKey;
    }
}
