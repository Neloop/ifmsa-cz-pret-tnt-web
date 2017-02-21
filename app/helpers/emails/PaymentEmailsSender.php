<?php

namespace App\Helpers\Emails;

use App\Model\Entity\Participant;
use App\Helpers\AppParams;

/**
 * Helper which provides sending of payment email to the participant. Payment
 * email is supposed to be sent on demand after thorough inspection of all
 * registrated participants. Mentioned email is containing payment link
 * generated for appropriate participant.
 */
class PaymentEmailsSender
{
    /**
     * Sender which handles actual email sending.
     * @var EmailHelper
     */
    private $emailHelper;
    /**
     * Application parameters from config files.
     * @var AppParams
     */
    private $appParams;

    /**
     * Constructor initialized via DI.
     * @param EmailHelper $emailHelper
     * @param AppParams $appParams
     */
    public function __construct(EmailHelper $emailHelper, AppParams $appParams)
    {
        $this->emailHelper = $emailHelper;
        $this->appParams = $appParams;
    }

    /**
     * Sends email with details about payment to the given participant.
     * @param Participant $participant
     * @return bool if email was sent successfully
     */
    public function send(Participant $participant): bool
    {
        $subject = strtoupper($participant->pretOrTnt) . " Payment Details";

        $message = "<p>Dear IFMSA friend,</p>";
        $message .= "<p>thank you again for your registration. We have great news for you, you were chosen to participate PRET&TNT Prague 2017. There is only one final step, payment for the event.</p>";
        $message .= "<p>Your registration will be recognized as binding if you execute payment through our payment gateway which resides <a href='{$this->appParams->getParticipantPaymentUrl()}/{$participant->id}' target='_blank'>here</a>.</p>";
        $message .= "<p>And this is it, we will look forward to meet you in Prague!</p>";

        return $this->emailHelper->send([$participant->email], $subject, $message);
    }
}
