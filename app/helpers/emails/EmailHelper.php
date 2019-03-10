<?php

namespace App\Helpers\Emails;

use App\Helpers\AppParams;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use Nette\Mail\SendException;
use Latte;

/**
 * Email helper providing sending of all emails in the application. All emails
 * have the same template specified in current directory.
 */
class EmailHelper
{
    /**
     * Mailer service.
     * @var IMailer
     */
    private $mailer;
    /**
     * Parameter for emails from config files.
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
     * @param IMailer $mailer
     * @param AppParams $appParams
     * @param EmailsParams $emailsParams
     */
    public function __construct(
        IMailer $mailer,
        AppParams $appParams,
        EmailsParams $emailsParams
    ) {

        $this->mailer = $mailer;
        $this->emailsParams = $emailsParams;
        $this->appParams = $appParams;
    }

    /**
     * Constructs email message, initializes its template and sends it to given
     * recipient from address defined in config.
     * @param array $to possibility of more recipients
     * @param string $subject subject of the message
     * @param string $messageText the message
     * @return bool if email was sent successfully
     */
    public function send(array $to, string $subject, string $messageText): bool
    {
        $latte = new Latte\Engine;
        $latte->setTempDirectory(__DIR__ . "/../../../temp");
        $params = [
            "subject"   => $subject,
            "message"   => $messageText,
            "siteUrl"    => $this->appParams->getSiteUrl(),
            "siteName"  => $this->appParams->getSiteName(),
            "facebookUrl" => $this->appParams->getFacebookEventUrl()
        ];
        $html = $latte->renderToString(__DIR__ . "/email.latte", $params);

        $message = new Message;
        $message->setFrom($this->emailsParams->getFrom())
                ->setSubject($this->emailsParams->getSubjectPrefix() . " - " . $subject)
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
