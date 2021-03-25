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
        $subject = strtoupper($participant->getPretOrTnt()) . " Payment Details";

        $message = "Dear applicant,<br>";
        $message .= "Thank you very much for your interest in PRET&TNT Prague"
                . " 2017<br>";
        $message .= "It is our pleasure to inform you that you <u>have been"
                . " selected</u> and you are invited to attend the event!<br>";
        $message .= "Congratulations!<br>";
        $message .= "<br>";

        $message .= "We would like to ask you to pay the participation fee in"
                . " <u>five days</u> since you receive this email. Please be"
                . " aware that your registration will be recognized valid as"
                . " soon as you proceed the payment. Payment is realised"
                . " through our payment gateway and you can pay with your"
                . " Master Card or Visa. Link for the payment is below:<br>";
        $paymentLink = $this->appParams->getParticipantPaymentUrl() . "/" . $participant->getId();
        $message .= "<a href='{$paymentLink}' target='_blank'>{$paymentLink}</a><br>";
        $message .= "<br>";

        $message .= "Applicants with visa requirement, please contact us at"
                . " <a href='mailto:neo@ifmsa.cz'>neo@ifmsa.cz</a> with your"
                . " specific needs for visa process with enclosed copy of your"
                . " passport<br>";
        $message .= "Don't forget to put going on our"
                . " <a href='{$this->appParams->getFacebookEventUrl()}' target='_blank'>facebook event</a>"
                . " to receive new updates about the event!<br>";

        return $this->emailHelper->send([$participant->getEmail()], $subject, $message);
    }
}
