<?php

namespace App\Helpers;

use Nette;
use Nette\Utils\Arrays;

/**
 * Top level application parameters defined in config files.
 */
class AppParams extends Nette\Object
{
    /**
     * Identificator of this website.
     * @var string
     */
    protected $siteName;
    /**
     * Unique URL address of this website.
     * @var string
     */
    protected $siteUrl;
    /**
     * Alternative URL address of website.
     * @var string
     */
    protected $siteAlternativeUrl;
    /**
     * URL of endpoint where participants are able to pay for events. Used in
     * payment email which is sent to participants on demand. URL is without
     * terminating participant ID.
     * @var string
     */
    protected $participantPaymentUrl;
    /**
     * Google API key used for js maps requests.
     * @var string
     */
    protected $googleMapsApiKey;
    /**
     * URL leading to facebook event page.
     * @var string
     */
    protected $facobookEventUrl;

    /**
     * Constructor initialized via DI.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->siteName = Arrays::get($config, ["siteName"], "PRET & TNT");
        $this->siteUrl = Arrays::get($config, ["siteUrl"], "");
        $this->siteAlternativeUrl = Arrays::get($config, ["siteAlternativeUrl"], "");
        $this->participantPaymentUrl = Arrays::get($config, ["participantPaymentUrl"], "");
        $this->googleMapsApiKey = Arrays::get($config, ["googleMapsApiKey"], "");
        $this->facobookEventUrl = Arrays::get($config, ["facebookEventUrl"], "");
    }

    /**
     * Get website identificator.
     * @return string
     */
    public function getSiteName(): string
    {
        return $this->siteName;
    }

    /**
     * Get website URL address.
     * @return string
     */
    public function getSiteUrl(): string
    {
        return $this->siteUrl;
    }

    /**
     * Get website alternative URL address.
     * @return string
     */
    public function getSiteAlternativeUrl(): string
    {
        return $this->siteAlternativeUrl;
    }

    /**
     * Get URL where participants are able to pay for event.
     * @return string
     */
    public function getParticipantPaymentUrl(): string
    {
        return $this->participantPaymentUrl;
    }

    /**
     * Get Google Maps API key.
     * @return string
     */
    public function getGoogleMapsApiKey(): string
    {
        return $this->googleMapsApiKey;
    }

    /**
     * Get URL of facebook event concerning this website.
     * @return string
     */
    public function getFacebookEventUrl(): string
    {
        return $this->facobookEventUrl;
    }
}
