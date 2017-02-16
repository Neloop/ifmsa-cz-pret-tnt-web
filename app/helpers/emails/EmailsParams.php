<?php

namespace App\Helpers\Emails;

use Nette;
use Nette\Utils\Arrays;

class EmailsParams extends Nette\Object
{
    protected $from;
    protected $reportTo;
    protected $subjectPrefix;

    public function __construct(array $config)
    {
        $this->from = Arrays::get($config, ["from"], "");
        $this->reportTo = Arrays::get($config, ["reportTo"], "");
        $this->subjectPrefix = Arrays::get($config, ["subjectPrefix"], "");
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getReportTo()
    {
        return $this->reportTo;
    }

    public function getSubjectPrefix()
    {
        return $this->subjectPrefix;
    }
}
