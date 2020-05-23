<?php

namespace App\Observers;

use App\Payment;
use App\Jobs\CheckDolarPriceJob;
use App\Events\NewPaymentCreated;
class PaymentObserver
{
    /**
     * Handle the payment "created" event.
     *
     * @param  \App\Payment  $payment
     * @return void
     */
    public function created(Payment $payment)
    {
        dispatch(new CheckDolarPriceJob($payment));
        event(new NewPaymentCreated($payment));
    }

    /**
     * Handle the payment "creating" event.
     *
     * @param  \App\Payment  $payment
     * @return void
     */
    public function creating(Payment $payment)
    {
        $payment->uuid = 0;
        return true;
    }
}
