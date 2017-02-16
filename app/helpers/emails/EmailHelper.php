<?php

namespace App\Helpers\Emails;

use App\Helpers\AppParams;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use Nette\Mail\SendException;
use Latte;

class EmailHelper
{

    /** @var IMailer */
    private $mailer;

    /** @var EmailsParams */
    private $emailsParams;

    /** @var AppParams */
    private $appParams;

    public function __construct(IMailer $mailer, AppParams $appParams, EmailsParams $emailsParams)
    {
        $this->mailer = $mailer;
        $this->emailsParams = $emailsParams;
        $this->appParams = $appParams;
    }

    public function send(array $to, string $subject, string $messageText): bool
    {
        $latte = new Latte\Engine;
        $latte->setTempDirectory(__DIR__ . "/../../../temp");
        $params = [
            "subject"   => $subject,
            "message"   => $messageText,
            "siteUrl"    => $this->appParams->siteUrl,
            "siteName"  => $this->appParams->siteName,
            "facebookUrl" => $this->appParams->facebookEventUrl
        ];
        $html = $latte->renderToString(__DIR__ . "/email.latte", $params);

        $message = new Message;
        $message->setFrom($this->emailsParams->from)
                ->setSubject($this->emailsParams->subjectPrefix . " - " . $subject)
                ->setHtmlBody($html);

        foreach ($to as $receiver) {
            $message->addTo($receiver);
        }

        try {
            $this->mailer->send($message);
        } catch (SendException $e) {
            return false;
        }

        return true;
    }
}
