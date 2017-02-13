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
 */
class Participant
{
    use MagicAccessors;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $paid = false;

    /**
     * @ORM\OneToOne(targetEntity="PaymentTransaction", inversedBy="participant")
     */
    protected $paymentTransaction;


    public function __construct()
    {
    }
}
