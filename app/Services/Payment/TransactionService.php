<?php

namespace App\Services\Payment;

use App\Contracts\Payment\Paymentable;
use App\Models\Transaction;

class TransactionService
{
    /**
     * @param int $orderId
     * @param Paymentable $paymentable
     * @return Transaction
     */
    public function create(int $orderId, Paymentable $paymentable): Transaction
    {
        $transaction = new Transaction();
        $transaction->setOrderId($orderId);
        $transaction->setPaymentableType(get_class($paymentable));
        $transaction->setPaymentableId($paymentable->id);
        $transaction->save();

        return $transaction;
    }

}
