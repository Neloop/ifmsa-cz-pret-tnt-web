<?php

namespace App\Helpers;

use App\Model\Entity\Participant;

/**
 * Description of PretEventHelper
 *
 * @author Neloop
 */
class PretEventHelper
{

    /** @var PretEventParams */
    private $pretEventParams;

    public function __construct(PretEventParams $pretEventParams)
    {
        $this->pretEventParams = $pretEventParams;
    }

    public function canRegisterNow(): bool
    {
        $now = DatetimeHelper::getNowUTC();
        if ($now <= $this->pretEventParams->getEnd()) {
            return true;
        } else {
            return false;
        }
    }

    public function getParticipantFee(Participant $participant): int
    {
        $registrationDate = $participant->registrationDateUtc;
        if ($registrationDate <= $this->pretEventParams->getRegularStart()) {
            return $this->pretEventParams->getEarlyFee();
        } else {
            return $this->pretEventParams->getRegularFee();
        }
    }
}
