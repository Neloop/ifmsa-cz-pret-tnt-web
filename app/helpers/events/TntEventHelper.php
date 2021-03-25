<?php

namespace App\Helpers;

use App\Model\Entity\Participant;
use App\Helpers\Payment\PaymentParams;

/**
 * Helper for TNT event and interpretation of parameters given in
 * configuration file.
 */
class TntEventHelper extends BaseEventHelper
{

    /**
     * TNT event parameters from config file.
     * @var TntEventParams
     */
    private $tntEventParams;

    /**
     * Constructor initialized via DI.
     * @param TntEventParams $tntEventParams
     * @param PaymentParams $paymentParams
     */
    public function __construct(
        TntEventParams $tntEventParams,
        PaymentParams $paymentParams
    ) {
    
        parent::__construct($paymentParams);
        $this->tntEventParams = $tntEventParams;
    }

    /**
     * Detect if TNT event is still open for registration.
     * @return bool true if TNT is still open
     */
    public function canRegisterNow(): bool
    {
        return DatetimeHelper::getNowUTC() <= $this->tntEventParams->getEnd();
    }

    /**
     * Get fee for given participant.
     * @param Participant $participant
     * @return int in currency defined in payment config
     */
    public function getParticipantFee(Participant $participant): int
    {
        return $this->tntEventParams->getFee();
    }
}
