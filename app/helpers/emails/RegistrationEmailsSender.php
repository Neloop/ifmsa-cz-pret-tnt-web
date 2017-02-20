<?php

namespace App\Helpers\Emails;

use App\Model\Entity\Participant;
use App\Helpers\AppParams;

/**
 *
 * @author Neloop
 */
class RegistrationEmailsSender
{
    /** @var EmailHelper */
    private $emailHelper;

    /** @var EmailsParams */
    private $emailsParams;

    /** @var AppParams */
    private $appParams;

    public function __construct(EmailHelper $emailHelper, EmailsParams $emailsParams, AppParams $appParams)
    {
        $this->emailHelper = $emailHelper;
        $this->emailsParams = $emailsParams;
        $this->appParams = $appParams;
    }

    private function sendToParticipant(Participant $participant)
    {
        $subject = strtoupper($participant->pretOrTnt) . " Registration";

        $message = "<p>Dear IFMSA friend,</p>";
        $message .= "<p>thank you for your registration. There are 30 spots in the first registration wave so we will consider all registrations carefully. We will let you know before the second registration period if you are chosen or not.</p>";
        $message .= "<p>Stay tuned on our website <a href='{$this->appParams->getSiteUrl()}' target='_blank'>pret.ifmsa.cz</a> / <a href='{$this->appParams->getSiteAlternativeUrl()}' target='_blank'>tnt.ifmsa.cz</a> or the <a href='{$this->appParams->getFacebookEventUrl()}' target='_blank'>FB event.</a></p>";

        return $this->emailHelper->send([$participant->email], $subject, $message);
    }

    private function sendToOrganizers(Participant $participant)
    {
        $subject = strtoupper($participant->pretOrTnt) . " Registration Report";

        $message = "<p>New registration on " . strtoupper($participant->pretOrTnt) . " event.</p>";
        $message .= "Name: {$participant->firstname} {$participant->surname}<br>";
        $message .= "Email: {$participant->email}<br>";
        $message .= "Registration Date: {$participant->registrationDateUtc->format('j. n. Y H:i')}";

        return $this->emailHelper->send([$this->emailsParams->reportTo], $subject, $message);
    }

    public function send(Participant $participant): bool
    {
        $resultParticipant = $this->sendToParticipant($participant);
        $resultOrganizers = $this->sendToOrganizers($participant);

        return $resultParticipant && $resultOrganizers;
    }
}
