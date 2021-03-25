<?php

namespace App\Model\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * PaymentError
 *
 * @ORM\Entity
 */
class PaymentError
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTime
     */
    protected $errorTime;

    /**
     * @ORM\Column(type="string", length=20)
     *
     * @var string
     */
    protected $action;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string|null
     */
    protected $response;


    public function __construct(string $action, ?string $response)
    {
        $this->errorTime = new DateTime;
        $this->action = $action;
        $this->response = $response;
    }

    ////////////////////////////////////////////////////////////////////////////

    public function getId(): int
    {
        return $this->id;
    }

    public function getErrorTime(): DateTime
    {
        return $this->errorTime;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }
}
