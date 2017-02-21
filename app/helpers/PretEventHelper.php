<?php

namespace App\Helpers;

use App\Model\Entity\Participant;

/**
 * Helper for PRET event and interpretation of parameters given in
 * configuration file.
 */
class PretEventHelper
{

    /**
     * PRET event parameters from config file.
     * @var PretEventParams
     */
    private $pretEventParams;

    /**
     * Constructor initialized via DI.
     * @param PretEventParams $pretEventParams
     */
    public function __construct(PretEventParams $pretEventParams)
    {
        $this->pretEventParams = $pretEventParams;
    }

    /**
     * Detect if PRET event is still open for registration.
     * @return bool true if PRET is still open
     */
    public function canRegisterNow(): bool
    {
        $now = DatetimeHelper::getNowUTC();
        if ($now <= $this->pretEventParams->getEnd()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get fee for given participant based on registration date.
     * @param Participant $participant
     * @return int in currency stated in payment config
     */
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
