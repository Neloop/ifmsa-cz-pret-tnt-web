<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\MagicAccessors;

/**
 * PaymentTransaction
 *
 * @ORM\Entity
 */
class PaymentTransaction
{
    use MagicAccessors;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $transactionId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $amount;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $ipAddress;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $result;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $resultCode;

    /**
     * @ORM\Column(name="result_3dsecure", type="string", length=50, nullable=true)
     */
    protected $result3dsecure;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $cardNumber;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $tDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $transactionEndDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $response;

    /**
     * @ORM\ManyToOne(targetEntity="Participant", inversedBy="paymentTransactions")
     */
    protected $participant;


    public function __construct(
        $transactionId,
        $amount,
        $ip,
        $description,
        $response
    ) {

        $this->transactionId = $transactionId;
        $this->amount = $amount;
        $this->ipAddress = $ip;
        $this->description = $description;
        $this->tDate = new \DateTime;
        $this->response = $response;
    }

    public function isOk()
    {
        return $this->result == "OK";
    }
}
