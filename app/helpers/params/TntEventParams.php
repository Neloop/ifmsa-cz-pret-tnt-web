<?php

namespace App\Helpers;

use Nette;
use Nette\Utils\Arrays;

class TntEventParams extends Nette\Object
{
    /** @var \DateTime */
    protected $start;
    /** @var \DateTime */
    protected $end;
    /** @var int */
    protected $fee;

    public function __construct(array $config)
    {
        $this->start = DatetimeHelper::createUTC(Arrays::get($config, ["start"], ""));
        $this->end = DatetimeHelper::createUTC(Arrays::get($config, ["end"], ""));
        $this->fee = Arrays::get($config, ["fee"], "");
    }

    public function getStart(): \DateTime
    {
        return $this->start;
    }

    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    public function getFee(): int
    {
        return $this->fee;
    }
}
