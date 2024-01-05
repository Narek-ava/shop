<?php

namespace App\Http\Controllers\API\V1;

use App\Exceptions\Paymentable\AmeriaPaymentException;
use App\Services\Payment\AmeriaPaymentService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private AmeriaPaymentService $paymentService;

    public function __construct(AmeriaPaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }


    /**
     * @param Request $request
     * @return Redirector|RedirectResponse|Application
     * @throws AmeriaPaymentException
     */
    public function ameriaCallback(Request $request): Redirector|RedirectResponse|Application
    {
        if (!$request->get('orderID') && !$request->get('paymentId')) {
            abort(404);
        }
        $payment = null;

        if ($request->get('orderID')) {
            $payment = $this->paymentService->findById($request->get('orderID'));
        }

        //todo check
        if (!$payment && $request->get('paymentId')) {
            $payment = $this->paymentService->findByExternalId($request->get('paymentId'));
        }

        if (!$payment) {
            Log::warning('Payment not found AmeriaCallback request: ' . json_encode($request->all()));
            abort(404);
        }

        $payment = $this->paymentService->syncPayment($payment);

        if ($request->get('redirectUrl')) {
            return redirect($request->get('redirectUrl'));
        }

        return redirect()->route('order.show', ['id' => $payment->transaction->order_id]);
    }
}
