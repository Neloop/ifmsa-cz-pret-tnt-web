<?php

namespace App\Helpers;

use Alcohol\ISO4217;
use App\Model\Entity\Participant;
use App\Helpers\Payment\PaymentParams;

/**
 * Base class for event helpers.
 */
abstract class BaseEventHelper
{

    /**
     * Payment parameters from config file.
     * @var PaymentParams
     */
    protected $paymentParams;

    /**
     * Constructor initialized via DI.
     * @param PaymentParams $paymentParams
     */
    public function __construct(PaymentParams $paymentParams)
    {
        $this->paymentParams = $paymentParams;
    }

    /**
     * Detect if event is still open for registration.
     * @return bool true if is still open
     */
    abstract public function canRegisterNow(): bool;

    /**
     * Get fee for given participant based on registration date.
     * @param Participant $participant
     * @return int in currency stated in payment config
     */
    abstract public function getParticipantFee(Participant $participant): int;

    /**
     * Get currency of participant fee.
     * @return string
     */
    public function getCurrency()
    {
        $iso4217 = new ISO4217();
        return $iso4217->getByNumeric($this->paymentParams->getCurrency())["alpha3"];
    }
}
