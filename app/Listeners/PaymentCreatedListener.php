<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\NewPaymentCreated;
use App\Jobs\SendPaymentCreatedMailJob;

class PaymentCreatedListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NewPaymentCreated $event)
    {
        dispatch(new SendPaymentCreatedMailJob($event->payment));
    }
}
