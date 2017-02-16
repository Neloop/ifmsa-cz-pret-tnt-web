<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\MagicAccessors;

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
 * @property \DateTime $registrationDate
 * @property PaymentTransaction $paymentTransaction
 */
class Participant
{
    const PRET_KEY = "pret";
    const TNT_KEY = "tnt";

    use MagicAccessors;

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
     * @ORM\Column(type="datetime")
     */
    protected $registrationDateUtc;

    /**
     * @ORM\OneToOne(targetEntity="PaymentTransaction", inversedBy="participant")
     */
    protected $paymentTransaction;


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

        $this->registrationDateUtc = \App\Helpers\DatetimeHelper::getNowUTC();
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
}
