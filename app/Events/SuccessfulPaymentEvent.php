<?php
namespace App\Events;
use App\Contracts\Payment\Paymentable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
class SuccessfulPaymentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public Paymentable $paymentable;
    /**
     * Create a new event instance.
     *
     * @param  Paymentable  $paymentable
     * @return void
     */
    public function __construct(Paymentable $paymentable)
    {
        $this->paymentable = $paymentable;
    }
}
