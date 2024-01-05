<?php

namespace App\Contracts\Payment;


use App\Models\Transaction\Transaction;

interface Paymentable
{
    public const CURRENCY_AMD = 'AMD';

    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    public function getTransaction(): Transaction;
}
