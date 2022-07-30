<?php

namespace App\Helpers\Table;

use App\Model\Repository\Participants;
use App\Helpers\PretEventHelper;
use App\Helpers\TntEventHelper;
use XLSXWriter;

/**
 * Factory class responsible for generation of tables concerning transactions.
 */
class TransactionsTableFactory
{
    /** @var Participants */
    private $participants;
    /** @var PretEventHelper */
    private $pretEventHelper;
    /** @var TntEventHelper */
    private $tntEventHelper;

    /**
     * DI Constructor.
     * @param Participants $participants
     * @param PretEventHelper $pretEventHelper
     * @param TntEventHelper $tntEventHelper
     */
    public function __construct(
        Participants $participants,
        PretEventHelper $pretEventHelper,
        TntEventHelper $tntEventHelper
    ) {
        $this->participants = $participants;
        $this->pretEventHelper = $pretEventHelper;
        $this->tntEventHelper = $tntEventHelper;
    }

    /**
     * Create table containing further information about given all participants
     * and their transactions.
     * @return string xlsx file table content, can be sent as response
     */
    public function createTransactionsTable()
    {
        $data = array(
            array('Transaction Start','Transaction End','Firstname',
                'Surname','Amount','Currency','Paid','PRET/TNT')
            );

        foreach ($this->participants->findAll() as $participant) {
            $start = "";
            $end = "";

            $transaction = $participant->getSuccessfulTransaction();
            if ($transaction) {
                $start = $transaction->getTDate()->format("j.n.Y H:i");
                if ($transaction->getTransactionEndDate()) {
                    $end = $transaction->getTransactionEndDate()->format("j.n.Y H:i");
                }
            }

            if ($participant->isPret()) {
                $amount = $this->pretEventHelper->getParticipantFee($participant);
                $currency = $this->pretEventHelper->getCurrency();
            } else {
                $amount = $this->tntEventHelper->getParticipantFee($participant);
                $currency = $this->tntEventHelper->getCurrency();
            }

            // if participant already paid, obtain appropriate amount
            if ($transaction) {
                $amount = $transaction->getAmount();
            }

            $data[] = array(
                $start, $end, $participant->getFirstname(), $participant->getSurname(),
                $amount, $currency, $participant->isPaid() ? "Yes" : "No",
                $participant->getPretOrTnt()
            );
        }

        $writer = new XLSXWriter();
        $writer->setTitle('IFMSA PRET/TNT Transactions Table');
        $writer->setSubject('');
        $writer->setAuthor('IFMSA PRET/TNT Website');
        $writer->setDescription('');
        $writer->setCompany('');
        $writer->writeSheet($data);
        return $writer->writeToString();
    }
}
