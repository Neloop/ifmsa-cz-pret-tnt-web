<?php

namespace App\Helpers\Emails;

use Nette\Utils\Arrays;

class EmailsParams
{
    protected $from;
    protected $subjectPrefix;

    public function __construct(array $config)
    {
        $this->from = Arrays::get($config, ["from"], "");
        $this->subjectPrefix = Arrays::get($config, ["subjectPrefix"], "");
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getSubjectPrefix()
    {
        return $this->subjectPrefix;
    }
}
