<?php

namespace App\Model\Repository;

use Kdyby\Doctrine\EntityManager;
use App\Model\Entity\PaymentTransaction;

/**
 * Repository for all PaymentTransaction entities.
 */
class PaymentTransactions extends BaseRepository
{
    /**
     * Constructor initialized via DI.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, PaymentTransaction::class);
    }

    /**
     * Get transaction by transaction identification gained from payment server.
     * @param string $transId transaction identification
     * @return PaymentTransaction|NULL
     */
    public function findOneByTransactionId($transId)
    {
        return $this->findOneBy(array("transactionId" => $transId));
    }
}
