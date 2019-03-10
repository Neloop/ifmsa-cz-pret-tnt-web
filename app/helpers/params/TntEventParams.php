<?php

namespace App\Helpers;

use Nette\SmartObject;
use Nette\Utils\Arrays;

/**
 * Parameters defined in config files concerning TNT event.
 */
class TntEventParams
{
    use SmartObject;

    /**
     * Start date and time of registration to TNT event.
     * @var \DateTime
     */
    protected $start;
    /**
     * End date and time of registration to TNT event.
     * @var \DateTime
     */
    protected $end;
    /**
     * Registration fee which participants have to pay for event. Presented in
     * currency defined in payment parameters.
     * @var int
     */
    protected $fee;

    /**
     * Constructor initialized via DI.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->start = DatetimeHelper::createUTC(Arrays::get($config, ["start"], ""));
        $this->end = DatetimeHelper::createUTC(Arrays::get($config, ["end"], ""));
        $this->fee = Arrays::get($config, ["fee"], "");
    }

    /**
     * Get start of TNT event registration.
     * @return \DateTime
     */
    public function getStart(): \DateTime
    {
        return $this->start;
    }

    /**
     * Get end of TNT event registration.
     * @return \DateTime
     */
    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    /**
     * Get fee applied to participants of TNT event.
     * @return int
     */
    public function getFee(): int
    {
        return $this->fee;
    }
}
