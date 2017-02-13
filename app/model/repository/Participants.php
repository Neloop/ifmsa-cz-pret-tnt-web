<?php

namespace App\Model\Repository;

use Kdyby\Doctrine\EntityManager;
use App\Model\Entity\Participant;

class Participants extends BaseRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, Participant::class);
    }
}
