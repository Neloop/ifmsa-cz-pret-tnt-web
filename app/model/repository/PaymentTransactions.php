<?php

namespace App\Model\Repository;

use Kdyby\Doctrine\EntityManager;
use App\Model\Entity\PaymentTransaction;

class PaymentTransactions extends BaseRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, PaymentTransaction::class);
    }

    public function findOneByTransactionId($transId)
    {
        return $this->findOneBy(array("transactionId" => $transId));
    }
}
