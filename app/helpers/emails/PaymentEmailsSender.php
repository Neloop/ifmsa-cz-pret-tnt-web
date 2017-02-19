<?php

namespace App\Helpers\Emails;

use App\Model\Entity\Participant;
use App\Helpers\AppParams;

/**
 *
 * @author Neloop
 */
class PaymentEmailsSender
{
    /** @var EmailHelper */
    private $emailHelper;

    /** @var AppParams */
    private $appParams;

    public function __construct(EmailHelper $emailHelper, AppParams $appParams)
    {
        $this->emailHelper = $emailHelper;
        $this->appParams = $appParams;
    }

    public function send(Participant $participant): bool
    {
        $subject = strtoupper($participant->pretOrTnt) . " Payment Details";

        $message = "<p>Dear IFMSA friend,</p>";
        $message .= "<p>thank you again for your registration. We have great news for you, you were chosen to participate PRET&TNT Prague 2017. There is only one final step, payment for the event.</p>";
        $message .= "<p>Your registration will be recognized as binding if you execute payment through our payment gateway which resides <a href='{$this->appParams->getParticipantPaymentUrl()}/{$participant->id}'>here</a>.</p>";
        $message .= "<p>And this is it, we will look forward to meet you in Prague!</p>";

        return $this->emailHelper->send([$participant->email], $subject, $message);
    }
}
