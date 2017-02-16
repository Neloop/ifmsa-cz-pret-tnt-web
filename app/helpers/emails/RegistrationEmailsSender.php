<?php

namespace App\Helpers\Emails;

use App\Model\Entity\Participant;

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

    public function __construct(EmailHelper $emailHelper, EmailsParams $emailsParams)
    {
        $this->emailHelper = $emailHelper;
        $this->emailsParams = $emailsParams;
    }

    private function sendToParticipant(Participant $participant)
    {
        $subject = strtoupper($participant->pretOrTnt) . " Registration";
        $message = $participant->firstname . " " . $participant->surname;

        // TODO: message

        return $this->emailHelper->send([$participant->email], $subject, $message);
    }

    private function sendToOrganizers(Participant $participant)
    {
        $subject = strtoupper($participant->pretOrTnt) . " Registration Report";
        $message = $participant->firstname . " " . $participant->surname;

        // TODO: message

        return $this->emailHelper->send([$this->emailsParams->reportTo], $subject, $message);
    }

    public function send(Participant $participant): bool
    {
        $resultParticipant = $this->sendToParticipant($participant);
        $resultOrganizers = $this->sendToOrganizers($participant);

        return $resultParticipant && $resultOrganizers;
    }
}
