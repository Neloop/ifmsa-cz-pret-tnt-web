<?php

namespace App\Model\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * PaymentTransaction
 *
 * @ORM\Entity
 */
class PaymentTransaction
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
     * @ORM\Column(type="string", length=50, nullable=true)
     *
     * @var string|null
     */
    protected $transactionId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var int
     */
    protected $amount;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     *
     * @var string
     */
    protected $ipAddress;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     *
     * @var string
     */
    protected $result;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     *
     * @var string
     */
    protected $resultCode;

    /**
     * @ORM\Column(name="result_3dsecure", type="string", length=50, nullable=true)
     *
     * @var string
     */
    protected $result3dsecure;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     *
     * @var string
     */
    protected $cardNumber;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTime;
     */
    protected $tDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTime
     */
    protected $transactionEndDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string|null
     */
    protected $response;

    /**
     * @ORM\ManyToOne(targetEntity="Participant", inversedBy="paymentTransactions")
     *
     * @var Participant
     */
    protected $participant;


    public function __construct(
        ?string $transactionId,
        int $amount,
        string $ip,
        string $description,
        ?string $response
    ) {

        $this->transactionId = $transactionId;
        $this->amount = $amount;
        $this->ipAddress = $ip;
        $this->description = $description;
        $this->tDate = new DateTime;
        $this->response = $response;
    }

    public function isOk(): bool
    {
        return $this->result === "OK";
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * @param mixed $transactionEndDate
     */
    public function setTransactionEndDate($transactionEndDate): void
    {
        $this->transactionEndDate = $transactionEndDate;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result): void
    {
        $this->result = $result;
    }

    /**
     * @param mixed $resultCode
     */
    public function setResultCode($resultCode): void
    {
        $this->resultCode = $resultCode;
    }

    /**
     * @param mixed $result3dsecure
     */
    public function setResult3dsecure($result3dsecure): void
    {
        $this->result3dsecure = $result3dsecure;
    }

    /**
     * @param mixed $cardNumber
     */
    public function setCardNumber($cardNumber): void
    {
        $this->cardNumber = $cardNumber;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response): void
    {
        $this->response = $response;
    }

    /**
     * @param mixed $participant
     */
    public function setParticipant($participant): void
    {
        $this->participant = $participant;
    }

    ////////////////////////////////////////////////////////////////////////////

    public function getId(): int
    {
        return $this->id;
    }

    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return mixed
     */
    public function getResultCode()
    {
        return $this->resultCode;
    }

    /**
     * @return mixed
     */
    public function getResult3dsecure()
    {
        return $this->result3dsecure;
    }

    /**
     * @return mixed
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * @return DateTime
     */
    public function getTDate(): DateTime
    {
        return $this->tDate;
    }

    /**
     * @return mixed
     */
    public function getTransactionEndDate()
    {
        return $this->transactionEndDate;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    public function getParticipant(): ?Participant
    {
        return $this->participant;
    }
}
