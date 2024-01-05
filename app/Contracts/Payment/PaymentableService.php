<?php

namespace App\Contracts\Payment;

use App\Exceptions\Paymentable\PaymentableException;

interface PaymentableService
{
    /**
     * @param float $amount
     * @param string $currency
     * @param array $options
     * @return Paymentable
     * @throws PaymentableException
     */
    public function initPayment(float $amount, string $currency, array $options = []): Paymentable;


    /**
     * @param Paymentable $payment
     * @param string|null $locale
     * @return string
     * @throws PaymentableException
     */
    public function getCheckoutUrl(Paymentable $payment, ?string $locale = 'en'): string;
}
