<?php

namespace App\Helpers;

use Nette;
use Nette\Utils\Arrays;

class AppParams extends Nette\Object
{
    protected $siteName;
    protected $siteUrl;
    protected $googleApiKey;
    protected $facobookEventUrl;

    public function __construct(array $config)
    {
        $this->siteName = Arrays::get($config, ["siteName"], "");
        $this->siteUrl = Arrays::get($config, ["siteUrl"], "");
        $this->googleApiKey = Arrays::get($config, ["googleApiKey"], "");
        $this->facobookEventUrl = Arrays::get($config, ["facebookEventUrl"], "");
    }

    public function getSiteName()
    {
        return $this->siteName;
    }

    public function getSiteUrl()
    {
        return $this->siteUrl;
    }

    public function getGoogleApiKey()
    {
        return $this->googleApiKey;
    }

    public function getFacebookEventUrl()
    {
        return $this->facobookEventUrl;
    }
}
