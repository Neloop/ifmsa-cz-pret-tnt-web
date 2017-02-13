<?php

namespace App\Model\Repository;

use Kdyby\Doctrine\EntityManager;
use App\Model\Entity\PaymentError;

class PaymentErrors extends BaseRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, PaymentError::class);
    }
}
