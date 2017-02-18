<?php

namespace App\Helpers;

use App\Model\Entity\Participant;

/**
 * Description of TntEventHelper
 *
 * @author Neloop
 */
class TntEventHelper
{

    /** @var TntEventParams */
    private $tntEventParams;

    public function __construct(TntEventParams $tntEventParams)
    {
        $this->tntEventParams = $tntEventParams;
    }

    public function canRegisterNow(): bool
    {
        $now = DatetimeHelper::getNowUTC();
        if ($now <= $this->tntEventParams->getEnd()) {
            return true;
        } else {
            return false;
        }
    }

    public function getParticipantFee(Participant $participant): int
    {
        return $this->tntEventParams->getFee();
    }
}
