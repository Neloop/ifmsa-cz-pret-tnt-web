<?php

namespace App\Helpers\Emails;

use Nette\Mail\Message;
use Nette\Mail\IMailer;

/**
 *
 * @author Neloop
 */
class PaymentEmailsSender
{
    /** @var IMailer */
    private $mailer;

    /** @var EmailsParams */
    private $emailsParams;

    public function __construct(IMailer $mailer, EmailsParams $emailsParams) {
        $this->mailer = $mailer;
        $this->emailsParams = $emailsParams;
    }

    public function send(Participant $participant)
    {
        ; // TODO
    }
}
