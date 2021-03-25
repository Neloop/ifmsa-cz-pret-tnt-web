<?php

namespace App\Helpers\Emails;

use Nette\Utils\Arrays;

/**
 * Parameters defined in config files concerning sending of emails.
 */
class EmailsParams
{
    /**
     * Email address of sender of all sent emails.
     * @var string
     */
    protected $from;
    /**
     * Reports of registration are sent to this email address.
     * @var string
     */
    protected $reportTo;
    /**
     * Prefix for subject for all sent emails.
     * @var string
     */
    protected $subjectPrefix;

    /**
     * Constructor initialized via DI.
     * @param array<string, string> $config
     */
    public function __construct(array $config)
    {
        $this->from = Arrays::get($config, ["from"], "");
        $this->reportTo = Arrays::get($config, ["reportTo"], "");
        $this->subjectPrefix = Arrays::get($config, ["subjectPrefix"], "");
    }

    /**
     * Get email address of sender.
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * Get email address to which report of registration are sent.
     * @return string
     */
    public function getReportTo(): string
    {
        return $this->reportTo;
    }

    /**
     * Get prefix for subject of emails.
     * @return string
     */
    public function getSubjectPrefix(): string
    {
        return $this->subjectPrefix;
    }
}
