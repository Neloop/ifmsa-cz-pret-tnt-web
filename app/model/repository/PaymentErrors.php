<?php

namespace App\Model\Repository;

use App\Model\Entity\PaymentError;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Repository for all PaymentError entities.
 */
class PaymentErrors extends BaseRepository
{
    /**
     * Constructor initialized via DI.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, PaymentError::class);
    }
}
