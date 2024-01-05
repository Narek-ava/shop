<?php

namespace App\Models\AmeriaPayment;

use App\Contracts\Payment\Paymentable;
use App\Models\Transaction\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class AmeriaPayment extends Model implements Paymentable
{
    use HasFactory;

    /**
     * @return MorphOne
     */
    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'paymentable');
    }

    /**
     * @param float $amount
     * @return void
     */
    public function setAmount(float $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @param string $currency
     * @return void
     */
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
    }

    /**
     * @param string $status
     * @return void
     */
    public function setStatus(string $status)
    {
        //todo add validation
        $this->status = $status;
    }

    /**
     * @param string $externalId
     * @return void
     */
    public function setExternalId(string $externalId)
    {
        //todo add validation
        $this->external_id = $externalId;
    }

    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }
}
