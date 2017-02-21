<?php

namespace App\Model\Repository;

use Kdyby\Doctrine\EntityManager;
use App\Model\Entity\PaymentError;

/**
 * Repository for all PaymentError entities.
 */
class PaymentErrors extends BaseRepository
{
    /**
     * Constructor initialized via DI.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, PaymentError::class);
    }
}
