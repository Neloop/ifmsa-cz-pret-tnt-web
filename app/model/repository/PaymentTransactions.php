<?php

namespace App\Model\Repository;

use App\Model\Entity\PaymentTransaction;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Repository for all PaymentTransaction entities.
 *
 * @extends BaseRepository<PaymentTransaction>
 */
class PaymentTransactions extends BaseRepository
{
    /**
     * Constructor initialized via DI.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
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
