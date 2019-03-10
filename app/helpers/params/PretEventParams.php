<?php

namespace App\Helpers;

use Nette\SmartObject;
use Nette\Utils\Arrays;

/**
 * Parameters defined in config files concerning PRET event.
 */
class PretEventParams
{
    use SmartObject;

    /**
     * Start date and time of early registration for PRET event.
     * @var \DateTime
     */
    protected $earlyStart;
    /**
     * Start date and time of regular registration for PRET event.
     * @var \DateTime
     */
    protected $regularStart;
    /**
     * End date and time of registration for PRET event.
     * @var \DateTime
     */
    protected $end;
    /**
     * Early fee concerning PRET event for its participants.
     * @var int
     */
    protected $earlyFee;
    /**
     * Regular fee concerning PRET event for its participants.
     * @var int
     */
    protected $regularFee;

    /**
     * Constructor initialized via DI.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->earlyStart = DatetimeHelper::createUTC(Arrays::get($config, ["earlyStart"], ""));
        $this->regularStart = DatetimeHelper::createUTC(Arrays::get($config, ["regularStart"], ""));
        $this->end = DatetimeHelper::createUTC(Arrays::get($config, ["end"], ""));
        $this->earlyFee = Arrays::get($config, ["earlyFee"], "");
        $this->regularFee = Arrays::get($config, ["regularFee"], "");
    }

    /**
     * Get start of early registration to PRET event.
     * @return \DateTime
     */
    public function getEarlyStart(): \DateTime
    {
        return $this->earlyStart;
    }

    /**
     * Get start of regular registration to PRET event.
     * @return \DateTime
     */
    public function getRegularStart(): \DateTime
    {
        return $this->regularStart;
    }

    /**
     * Get end of registration to PRET event.
     * @return \DateTime
     */
    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    /**
     * Get fee which is applied to participants who registered in early
     * registration period.
     * @return int
     */
    public function getEarlyFee(): int
    {
        return $this->earlyFee;
    }

    /**
     * Get fee which is applied to participants who registered in regular
     * registration period.
     * @return int
     */
    public function getRegularFee(): int
    {
        return $this->regularFee;
    }
}
