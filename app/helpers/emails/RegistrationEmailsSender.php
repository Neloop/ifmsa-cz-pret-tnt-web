<?php

namespace App\Helpers\Emails;

use App\Model\Entity\Participant;
use App\Helpers\AppParams;

/**
 * Helper which is supposed to send emails after participant registration.
 * Emails are sent to participant and also to email address used for reporting
 * about new participants.
 */
class RegistrationEmailsSender
{
    /**
     * Actual sender of emails.
     * @var EmailHelper
     */
    private $emailHelper;
    /**
     * Emails parameters from config files.
     * @var EmailsParams
     */
    private $emailsParams;
    /**
     * Application parameters from config files.
     * @var AppParams
     */
    private $appParams;

    /**
     * Constructor initialized via DI.
     * @param EmailHelper $emailHelper
     * @param EmailsParams $emailsParams
     * @param AppParams $appParams
     */
    public function __construct(
        EmailHelper $emailHelper,
        EmailsParams $emailsParams,
        AppParams $appParams
    ) {

        $this->emailHelper = $emailHelper;
        $this->emailsParams = $emailsParams;
        $this->appParams = $appParams;
    }

    /**
     * Send email with some further information to event participant.
     * @param Participant $participant
     * @return bool if email was sent successfully
     */
    private function sendToParticipant(Participant $participant): bool
    {
        $subject = strtoupper($participant->getPretOrTnt()) . " Registration";

        $message = "<p>Dear IFMSA friend,</p>";
        $message .= "<p>thank you for your registration. There are limited spots for both events so we will consider all registrations carefully. We will let you know according to registration dates you can find on website if you are chosen or not.</p>";
        $message .= "<p>Stay tuned on our website <a href='{$this->appParams->getSiteUrl()}' target='_blank'>pret.ifmsa.cz</a> / <a href='{$this->appParams->getSiteAlternativeUrl()}' target='_blank'>tnt.ifmsa.cz</a> or the <a href='{$this->appParams->getFacebookEventUrl()}' target='_blank'>FB event.</a></p>";

        return $this->emailHelper->send([$participant->getEmail()], $subject, $message);
    }

    /**
     * Send report email about new participant to special email address.
     * @param Participant $participant
     * @return bool if email was sent successfully
     */
    private function sendToOrganizers(Participant $participant): bool
    {
        $subject = strtoupper($participant->getPretOrTnt()) . " Registration Report";

        $message = "<p>New registration on " . strtoupper($participant->getPretOrTnt()) . " event.</p>";
        $message .= "Name: {$participant->getFirstname()} {$participant->getSurname()}<br>";
        $message .= "Email: {$participant->getEmail()}<br>";
        $message .= "Registration Date: {$participant->getRegistrationDateUtc()->format('j. n. Y H:i')}";

        return $this->emailHelper->send([$this->emailsParams->getReportTo()], $subject, $message);
    }

    /**
     * Sends both emails to the participant and to the reporting email address.
     * @param Participant $participant
     * @return bool if emails were sent successfully
     */
    public function send(Participant $participant): bool
    {
        $resultParticipant = $this->sendToParticipant($participant);
        $resultOrganizers = $this->sendToOrganizers($participant);

        return $resultParticipant && $resultOrganizers;
    }
}
