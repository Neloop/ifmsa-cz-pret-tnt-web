<?php

namespace App\Helpers;

use Nette;
use Nette\Utils\Arrays;

class PretEventParams extends Nette\Object
{
    /** @var \DateTime */
    protected $earlyStart;
    /** @var \DateTime */
    protected $regularStart;
    /** @var \DateTime */
    protected $end;
    /** @var int */
    protected $earlyFee;
    /** @var int */
    protected $regularFee;

    public function __construct(array $config)
    {
        $this->earlyStart = DatetimeHelper::createUTC(Arrays::get($config, ["earlyStart"], ""));
        $this->regularStart = DatetimeHelper::createUTC(Arrays::get($config, ["regularStart"], ""));
        $this->end = DatetimeHelper::createUTC(Arrays::get($config, ["end"], ""));
        $this->earlyFee = Arrays::get($config, ["earlyFee"], "");
        $this->regularFee = Arrays::get($config, ["regularFee"], "");
    }

    public function getEarlyStart(): \DateTime
    {
        return $this->earlyStart;
    }

    public function getRegularStart(): \DateTime
    {
        return $this->regularStart;
    }

    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    public function getEarlyFee(): int
    {
        return $this->earlyFee;
    }

    public function getRegularFee(): int
    {
        return $this->regularFee;
    }
}
