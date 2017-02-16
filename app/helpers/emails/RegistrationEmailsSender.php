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

    public function __construct(EmailHelper $emailHelper)
    {
        $this->emailHelper = $emailHelper;
    }

    public function send(Participant $participant): bool
    {
        ;
    }
}
