<?php

namespace App\Helpers\Table;

use App\Model\Repository\Participants;
use App\Helpers\PretEventHelper;
use App\Helpers\TntEventHelper;

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

            $transaction = $participant->successfulTransaction;
            if ($transaction) {
                $start = $transaction->tDate->format("j.n.Y H:i");
                if ($transaction->transactionEndDate) {
                    $end = $transaction->transactionEndDate->format("j.n.Y H:i");
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
                $amount = $transaction->amount;
            }

            $data[] = array(
                $start, $end, $participant->firstname, $participant->surname,
                $amount, $currency, $participant->paid ? "Yes" : "No",
                $participant->pretOrTnt
            );
        }

        $writer = new \XLSXWriter();
        $writer->writeSheet($data);
        return $writer->writeToString();
    }
}
