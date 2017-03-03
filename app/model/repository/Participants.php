<?php

namespace App\Model\Repository;

use Kdyby\Doctrine\EntityManager;
use App\Model\Entity\Participant;

/**
 * Repository for all Participant entities.
 */
class Participants extends BaseRepository
{
    /**
     * Constructor initialized via DI.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, Participant::class);
    }

    public function countPretParticipants()
    {
        return $this->countBy(array("pretOrTnt" => "pret"));
    }

    public function countTntParticipants()
    {
        return $this->countBy(array("pretOrTnt" => "tnt"));
    }
}
