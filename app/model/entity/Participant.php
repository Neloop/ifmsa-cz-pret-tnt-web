<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Helpers\DatetimeHelper;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Participant
 *
 * @ORM\Entity
 *
 * @property integer $id
 * @property string $firstname
 * @property string $surname
 * @property string $email
 * @property string $phone
 * @property string $allergies
 * @property string $diet
 * @property bool $visaNeeded
 * @property bool $invitationLetterNeeded
 * @property string $nmo
 * @property string $nmoPosition
 * @property string $ifmsaEventsAttended
 * @property string $universityFaculty
 * @property string $city
 * @property integer $yearOfStudy
 * @property string $motivation
 * @property string $pretOrTnt
 * @property string $tntStrengthsAsTrainer
 * @property string $tntVisionAsTrainer
 * @property string $tntUsageOfKnowledge
 * @property boolean $paid
 * @property boolean $paymentEmailSent
 * @property \DateTime $registrationDateUtc
 * @property PaymentTransaction $successfulTransaction
 */
class Participant
{
    const PRET_KEY = "pret";
    const TNT_KEY = "tnt";

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string")
     */
    protected $surname;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $phone;

    /**
     * @ORM\Column(type="text")
     */
    protected $allergies;

    /**
     * @ORM\Column(type="text")
     */
    protected $diet;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $visaNeeded;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $invitationLetterNeeded;

    /**
     * @ORM\Column(type="string")
     */
    protected $nmo;

    /**
     * @ORM\Column(type="string")
     */
    protected $nmoPosition;

    /**
     * @ORM\Column(type="text")
     */
    protected $ifmsaEventsAttended;

    /**
     * @ORM\Column(type="string")
     */
    protected $universityFaculty;

    /**
     * @ORM\Column(type="string")
     */
    protected $city;

    /**
     * @ORM\Column(type="integer")
     */
    protected $yearOfStudy;

    /**
     * @ORM\Column(type="text")
     */
    protected $motivation;

    /**
     * @ORM\Column(type="string")
     */
    protected $pretOrTnt = "";

    /**
     * @ORM\Column(type="text")
     */
    protected $tntStrengthsAsTrainer = "";

    /**
     * @ORM\Column(type="text")
     */
    protected $tntVisionAsTrainer = "";

    /**
     * @ORM\Column(type="text")
     */
    protected $tntUsageOfKnowledge = "";

    /**
     * @ORM\Column(type="boolean")
     */
    protected $paid = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $paymentEmailSent = false;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $registrationDateUtc;

    /**
     * @ORM\OneToMany(targetEntity="PaymentTransaction", mappedBy="participant")
     */
    protected $paymentTransactions;


    public function __construct(
        $firstname,
        $surname,
        $email,
        $phone,
        $allergies,
        $diet,
        $visaNeeded,
        $invitationLetterNeeded,
        $nmo,
        $nmoPosition,
        $ifmsaEventsAttended,
        $university,
        $city,
        $yearOfStudy,
        $motivation
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

    public function getRegistrationDateUtc()
    {
        $original = $this->registrationDateUtc->format("Y-m-d H:i:s");
        return DatetimeHelper::createUTC($original);
    }

    public function isPret(): bool
    {
        return $this->pretOrTnt === self::PRET_KEY ? true : false;
    }

    public function setPret()
    {
        $this->pretOrTnt = self::PRET_KEY;
    }

    public function isTnt(): bool
    {
        return $this->pretOrTnt === self::TNT_KEY ? true : false;
    }

    public function setTnt()
    {
        $this->pretOrTnt = self::TNT_KEY;
    }

    public function getSuccessfulTransaction()
    {
        return $this->paymentTransactions->filter(function (PaymentTransaction $transaction) {
            if ($transaction->isOk()) {
                return true;
            } else {
                return false;
            }
        })->first();
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getAllergies(): string
    {
        return $this->allergies;
    }

    /**
     * @return string
     */
    public function getDiet(): string
    {
        return $this->diet;
    }

    /**
     * @return bool
     */
    public function isVisaNeeded(): bool
    {
        return $this->visaNeeded;
    }

    /**
     * @return bool
     */
    public function isInvitationLetterNeeded(): bool
    {
        return $this->invitationLetterNeeded;
    }

    /**
     * @return string
     */
    public function getNmo(): string
    {
        return $this->nmo;
    }

    /**
     * @return string
     */
    public function getNmoPosition(): string
    {
        return $this->nmoPosition;
    }

    /**
     * @return string
     */
    public function getIfmsaEventsAttended(): string
    {
        return $this->ifmsaEventsAttended;
    }

    /**
     * @return string
     */
    public function getUniversityFaculty(): string
    {
        return $this->universityFaculty;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return int
     */
    public function getYearOfStudy(): int
    {
        return $this->yearOfStudy;
    }

    /**
     * @return string
     */
    public function getMotivation(): string
    {
        return $this->motivation;
    }

    /**
     * @return string
     */
    public function getPretOrTnt(): string
    {
        return $this->pretOrTnt;
    }

    /**
     * @return string
     */
    public function getTntStrengthsAsTrainer(): string
    {
        return $this->tntStrengthsAsTrainer;
    }

    /**
     * @return string
     */
    public function getTntVisionAsTrainer(): string
    {
        return $this->tntVisionAsTrainer;
    }

    /**
     * @return string
     */
    public function getTntUsageOfKnowledge(): string
    {
        return $this->tntUsageOfKnowledge;
    }

    /**
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->paid;
    }

    /**
     * @return bool
     */
    public function isPaymentEmailSent(): bool
    {
        return $this->paymentEmailSent;
    }

    /**
     * @return ArrayCollection
     */
    public function getPaymentTransactions(): ArrayCollection
    {
        return $this->paymentTransactions;
    }
}
