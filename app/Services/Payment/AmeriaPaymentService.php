<?php

namespace App\Services\Payment;

use App\Contracts\Payment\Paymentable;
use App\Contracts\Payment\PaymentableService;
use App\Events\SuccessfulPaymentEvent;
use App\Exceptions\Paymentable\AmeriaPaymentException;
use App\Models\AmeriaPayment\AmeriaPayment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class AmeriaPaymentService implements PaymentableService
{
    protected const PAYMENT_URL_TEST = 'https://servicestest.ameriabank.am/VPOS';
    protected const PAYMENT_URL_LIVE = 'https://services.ameriabank.am/VPOS';

    protected const PAYMENT_CODE_SUCCESS = '00';
    protected const PAYMENT_CODE_NO_PAYMENT_YET = '0-100';


    /**
     * @return string
     */
    private function getUrl(): string
    {
        return config('services.ameriaPayment.testMode') ? self::PAYMENT_URL_TEST : self::PAYMENT_URL_LIVE;
    }

    /**
     * @param AmeriaPayment $payment
     * @return int
     */
    private function getId(AmeriaPayment $payment): int
    {
        return config('services.ameriaPayment.testMode') ? 29470045 + $payment->id : $payment->id;
    }

    /**
     * @param AmeriaPayment $payment
     * @return float|int
     */
    private function getAmount(AmeriaPayment $payment): float|int
    {
        return config('services.ameriaPayment.testMode') ? 10 : $payment->amount;
    }



    /**
     * @param float $amount
     * @param string $currency
     * @param array $options
     * @return AmeriaPayment
     * @throws AmeriaPaymentException
     */
    public function initPayment(float $amount, string $currency, array $options = []): AmeriaPayment
    {
        try {
            DB::beginTransaction();

            $payment = new AmeriaPayment();
            $payment->setAmount($amount);
            $payment->setCurrency($currency);
            $payment->setStatus(Paymentable::STATUS_PENDING);
            $payment->save();

            $url = $this->getUrl() . '/api/VPOS/InitPayment';
            $data = [
                'ClientID' => config('services.ameriaPayment.clientId'),
                'Username' => config('services.ameriaPayment.username'),
                'Password' => config('services.ameriaPayment.password'),
                'Currency' => $payment->currency,
                'Description' => 'lilly.am Payment for an order in the amount of ' . $amount . $currency,//todo add translation
                'OrderID' => $this->getId($payment),
                'amount' => $this->getAmount($payment),
                'BackURL' => route('payment.ameriaCallback', array_merge(['paymentId' => $payment->id], $options)),
            ];

            $response = Http::post($url, $data);

            if (!$response->successful() || !$paymentId = $response->object()->PaymentID) {
                throw new AmeriaPaymentException('Failed to create PaymentID response: ' . json_encode($response));
            }

            $payment->setExternalId($paymentId);
            $payment->save();
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('PaymentID ' . $e->getMessage());
            //todo handle
            throw new AmeriaPaymentException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        DB::commit();

        return $payment;
    }

    /**
     * @param AmeriaPayment|Paymentable $payment
     * @param string|null $locale
     * @return string
     * @throws AmeriaPaymentException
     */
    public function getCheckoutUrl(AmeriaPayment|Paymentable $payment, ?string $locale = 'en'): string
    {
        if (empty($payment->external_id)) {
            throw new AmeriaPaymentException('invalid payment');//todo add custom exception
        }

        return $this->getUrl() . "/Payments/Pay?id=$payment->external_id&lang={$this->transformLocale($locale)}";
    }

    /**
     * @param string $locale
     * @return string
     */
    private function transformLocale(string $locale): string
    {
        if ($locale === 'hy') {
            $locale = 'am';
        }

        return $locale;
    }

    /**
     * @throws AmeriaPaymentException
     */
    public function confirmPayment(AmeriaPayment $payment): object
    {
        $this->validateCanConfirmPayment($payment);
        $payment->setStatus(Paymentable::STATUS_PROCESSING);
        $payment->save();

        $url = $this->getUrl() . '/api/VPOS/ConfirmPayment';
        $data = [
            'Username' => config('services.ameriaPayment.username'),
            'Password' => config('services.ameriaPayment.password'),
            'PaymentID' => $payment->external_id,
            'Amount' => $payment->amount,
        ];

        try {
            $response = Http::post($url, $data);

            if (!$response->successful() || !$responseObject = $response->object()) {
                throw new AmeriaPaymentException('Failed to getExternalPayment response: ' . json_encode($response));
            }

            //fail
            if ($responseObject->ResponseCode !== self::PAYMENT_CODE_SUCCESS) {
                $payment->setStatus(Paymentable::STATUS_REJECTED);
                $payment->save();
                Log::info("PaymentTRejected paymentId: $payment->id, response: " . json_encode($responseObject));

                return $payment;
            }

            //success
            $payment->setStatus(Paymentable::STATUS_APPROVED);
            $payment->save();

            return $payment;
        } catch (Throwable $e) {
            Log::error('PaymentID ' . $e->getMessage());
            //todo handle
            throw new AmeriaPaymentException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    /**
     * @param string $paymentId
     * @return object
     * @throws AmeriaPaymentException
     */
    public function getExternalPayment(string $paymentId): object
    {
        $url = $this->getUrl() . '/api/VPOS/GetPaymentDetails';
        $data = [
            'Username' => config('services.ameriaPayment.username'),
            'Password' => config('services.ameriaPayment.password'),
            'PaymentID' => $paymentId,
        ];

        try {
            $response = Http::post($url, $data);

            if (!$response->successful() || !$responseObject = $response->object()) {
                throw new AmeriaPaymentException('Failed to getExternalPayment response: ' . json_encode($response));
            }

            return $responseObject; //todo create dto
        } catch (Throwable $e) {
            Log::error('PaymentID ' . $e->getMessage());
            //todo handle
            throw new AmeriaPaymentException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    /**
     * @param AmeriaPayment $payment
     * @return AmeriaPayment
     * @throws AmeriaPaymentException
     */
    public function syncPayment(AmeriaPayment $payment): AmeriaPayment
    {
        $this->validateCanSyncPayment($payment);
        $paymentData = $this->getExternalPayment($payment->external_id);

        switch ($paymentData->ResponseCode) {
            //payment completed (approved)
            case self::PAYMENT_CODE_SUCCESS:
                $oldPaymentStatus = $payment->status;

                $payment->setStatus(Paymentable::STATUS_APPROVED);
                $payment->save();

                if ($oldPaymentStatus !== Paymentable::STATUS_APPROVED) {
                    event(new SuccessfulPaymentEvent($payment));
                }

                if ($oldPaymentStatus === Paymentable::STATUS_REJECTED) {
                    Log::warning('Completed payment is on status: ' . $payment->status);
                }
                break;
            //no payment yet (pending)
            case self::PAYMENT_CODE_NO_PAYMENT_YET:
                if ($payment->status !== Paymentable::STATUS_PENDING) {
                    Log::warning('Payment without payments is on status: ' . $payment->status);
                }
                break;
            //rejected
            default:
                $payment->setStatus(Paymentable::STATUS_REJECTED);
                $payment->save();
                Log::info("Payment rejected paymentId: $payment->id paymentData: " . json_encode($paymentData));

        }

        return $payment;
    }

    /**
     * @throws  AmeriaPaymentException()
     */
    private function validateCanConfirmPayment(AmeriaPayment $payment)
    {
        switch ($payment->status) {
            case Paymentable::STATUS_PROCESSING:
                throw new  AmeriaPaymentException('Payment is already being processed');
            case Paymentable::STATUS_APPROVED :
                throw new  AmeriaPaymentException('Payment is already approved');
        }
    }

    /**
     * @throws  AmeriaPaymentException()
     */
    private function validateCanSyncPayment(AmeriaPayment $payment)
    {
        if ($payment->status == Paymentable::STATUS_APPROVED) {
            throw new  AmeriaPaymentException('Payment is already approved');
        }
    }

    /**
     * @param int $id
     * @return AmeriaPayment|Builder|null
     */
    public function findById(int $id): AmeriaPayment|Builder|null
    {
        return AmeriaPayment::query()->where('id', $id)->first();
    }

    /**
     * @param string $externalId
     * @return AmeriaPayment|Builder|null
     */
    public function findByExternalId(string $externalId): AmeriaPayment|Builder|null
    {
        return AmeriaPayment::query()->where('external_id', $externalId)->first();
    }
}
