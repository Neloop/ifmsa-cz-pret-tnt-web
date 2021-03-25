<?php

namespace App\Helpers;

use App\Model\Entity\Participant;
use App\Helpers\Payment\PaymentParams;

/**
 * Helper for PRET event and interpretation of parameters given in
 * configuration file.
 */
class PretEventHelper extends BaseEventHelper
{

    /**
     * PRET event parameters from config file.
     * @var PretEventParams
     */
    private $pretEventParams;

    /**
     * Constructor initialized via DI.
     * @param PretEventParams $pretEventParams
     * @param PaymentParams $paymentParams
     */
    public function __construct(
        PretEventParams $pretEventParams,
        PaymentParams $paymentParams
    ) {
    
        parent::__construct($paymentParams);
        $this->pretEventParams = $pretEventParams;
    }

    /**
     * Detect if PRET event is still open for registration.
     * @return bool true if PRET is still open
     */
    public function canRegisterNow(): bool
    {
        return DatetimeHelper::getNowUTC() <= $this->pretEventParams->getEnd();
    }

    /**
     * Get fee for given participant based on registration date.
     * @param Participant $participant
     * @return int in currency stated in payment config
     */
    public function getParticipantFee(Participant $participant): int
    {
        $registrationDate = $participant->getRegistrationDateUtc();
        if ($registrationDate <= $this->pretEventParams->getRegularStart()) {
            return $this->pretEventParams->getEarlyFee();
        } else {
            return $this->pretEventParams->getRegularFee();
        }
    }
}
