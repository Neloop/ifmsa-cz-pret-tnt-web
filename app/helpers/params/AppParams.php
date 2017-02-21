<?php

namespace App\Helpers;

use Nette;
use Nette\Utils\Arrays;

class AppParams extends Nette\Object
{
    protected $siteName;
    protected $siteUrl;
    protected $siteAlternativeUrl;
    protected $participantPaymentUrl;
    protected $googleMapsApiKey;
    protected $facobookEventUrl;

    public function __construct(array $config)
    {
        $this->siteName = Arrays::get($config, ["siteName"], "");
        $this->siteUrl = Arrays::get($config, ["siteUrl"], "");
        $this->siteAlternativeUrl = Arrays::get($config, ["siteAlternativeUrl"], "");
        $this->participantPaymentUrl = Arrays::get($config, ["participantPaymentUrl"], "");
        $this->googleMapsApiKey = Arrays::get($config, ["googleMapsApiKey"], "");
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

    public function getSiteAlternativeUrl()
    {
        return $this->siteAlternativeUrl;
    }

    public function getParticipantPaymentUrl()
    {
        return $this->participantPaymentUrl;
    }

    public function getGoogleMapsApiKey()
    {
        return $this->googleMapsApiKey;
    }

    public function getFacebookEventUrl()
    {
        return $this->facobookEventUrl;
    }
}