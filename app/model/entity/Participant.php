<?php

namespace App\Model\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Helpers\DatetimeHelper;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Participant
 *
 * @ORM\Entity
 */
class Participant
{
    const PRET_KEY = "pret";
    const TNT_KEY = "tnt";

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * 
     * @var string
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string")
     * 
     * @var string
     */
    protected $surname;

    /**
     * @ORM\Column(type="string")
     * 
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     * 
     * @var string
     */
    protected $phone;

    /**
     * @ORM\Column(type="text")
     * 
     * @var string|null
     */
    protected $allergies;

    /**
     * @ORM\Column(type="text")
     * 
     * @var string
     */
    protected $diet;

    /**
     * @ORM\Column(type="boolean")
     * 
     * @var bool
     */
    protected $visaNeeded;

    /**
     * @ORM\Column(type="boolean")
     * 
     * @var bool
     */
    protected $invitationLetterNeeded;

    /**
     * @ORM\Column(type="string")
     * 
     * @var string
     */
    protected $nmo;

    /**
     * @ORM\Column(type="string")
     * 
     * @var string
     */
    protected $nmoPosition;

    /**
     * @ORM\Column(type="text")
     * 
     * @var string|null
     */
    protected $ifmsaEventsAttended;

    /**
     * @ORM\Column(type="string")
     * 
     * @var string
     */
    protected $universityFaculty;

    /**
     * @ORM\Column(type="string")
     * 
     * @var string
     */
    protected $city;

    /**
     * @ORM\Column(type="integer")
     * 
     * @var int
     */
    protected $yearOfStudy;

    /**
     * @ORM\Column(type="text")
     * 
     * @var string
     */
    protected $motivation;

    /**
     * @ORM\Column(type="string")
     * 
     * @var string
     */
    protected $pretOrTnt = "";

    /**
     * @ORM\Column(type="text")
     * 
     * @var string
     */
    protected $tntStrengthsAsTrainer = "";

    /**
     * @ORM\Column(type="text")
     * 
     * @var string
     */
    protected $tntVisionAsTrainer = "";

    /**
     * @ORM\Column(type="text")
     * 
     * @var string
     */
    protected $tntUsageOfKnowledge = "";

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    protected $paid = false;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    protected $paymentEmailSent = false;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var DateTime
     */
    protected $registrationDateUtc;

    /**
     * @ORM\OneToMany(targetEntity="PaymentTransaction", mappedBy="participant")
     *
     * @var Collection<int, PaymentTransaction>
     */
    protected $paymentTransactions;


    public function __construct(
        string $firstname,
        string $surname,
        string $email,
        string $phone,
        ?string $allergies,
        string $diet,
        bool $visaNeeded,
        bool $invitationLetterNeeded,
        string $nmo,
        string $nmoPosition,
        ?string $ifmsaEventsAttended,
        string $university,
        string $city,
        int $yearOfStudy,
        string $motivation
    ) {

        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->email = $email;
        $this->phone = $phone;
        $this->allergies = $allergies;
        $this->diet = $diet;
        $this->visaNeeded = $visaNeeded;
        $this->invitationLetterNeeded = $invitationLetterNeeded;
        $this->nmo = $nmo;
        $this->nmoPosition = $nmoPosition;
        $this->ifmsaEventsAttended = $ifmsaEventsAttended;
        $this->universityFaculty = $university;
        $this->city = $city;
        $this->yearOfStudy = $yearOfStudy;
        $this->motivation = $motivation;

        $this->registrationDateUtc = DatetimeHelper::getNowUTC();
        $this->paymentTransactions = new ArrayCollection;
    }

    public function getRegistrationDateUtc(): DateTime
    {
        $original = $this->registrationDateUtc->format("Y-m-d H:i:s");
        return DatetimeHelper::createUTC($original);
    }

    public function isPret(): bool
    {
        return $this->pretOrTnt === self::PRET_KEY;
    }

    public function setPret(): void
    {
        $this->pretOrTnt = self::PRET_KEY;
    }

    public function isTnt(): bool
    {
        return $this->pretOrTnt === self::TNT_KEY;
    }

    public function setTnt(): void
    {
        $this->pretOrTnt = self::TNT_KEY;
    }

    public function getSuccessfulTransaction(): object
    {
        return $this->paymentTransactions->filter(function (PaymentTransaction $transaction) {
            return $transaction->isOk();
        })->first();
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * @param bool $paid
     */
    public function setPaid(bool $paid): void
    {
        $this->paid = $paid;
    }

    /**
     * @param string $tntStrengthsAsTrainer
     */
    public function setTntStrengthsAsTrainer(string $tntStrengthsAsTrainer): void
    {
        $this->tntStrengthsAsTrainer = $tntStrengthsAsTrainer;
    }

    /**
     * @param string $tntVisionAsTrainer
     */
    public function setTntVisionAsTrainer(string $tntVisionAsTrainer): void
    {
        $this->tntVisionAsTrainer = $tntVisionAsTrainer;
    }

    /**
     * @param string $tntUsageOfKnowledge
     */
    public function setTntUsageOfKnowledge(string $tntUsageOfKnowledge): void
    {
        $this->tntUsageOfKnowledge = $tntUsageOfKnowledge;
    }

    /**
     * @param bool $paymentEmailSent
     */
    public function setPaymentEmailSent(bool $paymentEmailSent): void
    {
        $this->paymentEmailSent = $paymentEmailSent;
    }

    ////////////////////////////////////////////////////////////////////////////

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getAllergies(): ?string
    {
        return $this->allergies;
    }

    public function getDiet(): string
    {
        return $this->diet;
    }

    public function isVisaNeeded(): bool
    {
        return $this->visaNeeded;
    }

    public function isInvitationLetterNeeded(): bool
    {
        return $this->invitationLetterNeeded;
    }

    public function getNmo(): string
    {
        return $this->nmo;
    }

    public function getNmoPosition(): string
    {
        return $this->nmoPosition;
    }

    public function getIfmsaEventsAttended(): ?string
    {
        return $this->ifmsaEventsAttended;
    }

    public function getUniversityFaculty(): string
    {
        return $this->universityFaculty;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getYearOfStudy(): int
    {
        return $this->yearOfStudy;
    }
    public function getMotivation(): string
    {
        return $this->motivation;
    }

    public function getPretOrTnt(): string
    {
        return $this->pretOrTnt;
    }

    public function getTntStrengthsAsTrainer(): string
    {
        return $this->tntStrengthsAsTrainer;
    }

    public function getTntVisionAsTrainer(): string
    {
        return $this->tntVisionAsTrainer;
    }

    public function getTntUsageOfKnowledge(): string
    {
        return $this->tntUsageOfKnowledge;
    }

    public function isPaid(): bool
    {
        return $this->paid;
    }

    public function isPaymentEmailSent(): bool
    {
        return $this->paymentEmailSent;
    }

    /**
     * @return Collection<int, PaymentTransaction>
     */
    public function getPaymentTransactions(): Collection
    {
        return $this->paymentTransactions;
    }
}
