<?php

namespace App\Model\Repository;

use App\Model\Entity\Participant;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Repository for all Participant entities.
 *
 * @extends BaseRepository<Participant>
 */
class Participants extends BaseRepository
{
    /**
     * Constructor initialized via DI.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Participant::class);
    }

    public function countPretParticipants(): int
    {
        return $this->countBy(array("pretOrTnt" => "pret"));
    }

    public function countTntParticipants(): int
    {
        return $this->countBy(array("pretOrTnt" => "tnt"));
    }
}
