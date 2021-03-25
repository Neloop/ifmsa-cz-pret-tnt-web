<?php

namespace App\Model\Entity;

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
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $errorTime;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $action;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $response;


    public function __construct($action, $response)
    {
        $this->errorTime = new \DateTime;
        $this->action = $action;
        $this->response = $response;
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getErrorTime(): \DateTime
    {
        return $this->errorTime;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }
}
