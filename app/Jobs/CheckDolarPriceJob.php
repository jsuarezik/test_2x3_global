<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use App\Payment;
use Carbon\Carbon;

class CheckDolarPriceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $payment;

    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        //Check if there's any other payment for the day that have already a dolar price setted
        $result = Payment::query()->ofDate($this->payment->created_at)->ofNotNullKey('clp_usd')->select('clp_usd')->first();
        //If there's one, set the price
        if ($result) {
            $result = $result->clp_usd;
        } else { //Else check the https://mindicador.cl/api/dolar API and set the value 
            $result = $this->getDolarPriceForPaymentDate();
        }
        //Update the model      
        $this->payment->update(['clp_usd' => $result]);
    }

    private function getDolarPriceForPaymentDate() {
        $date = Carbon::parse($this->payment->created_at)->toDateString();
        $client = new Client();
        $response = $client->get('https://mindicador.cl/api/dolar')->getBody()->getContents();
        $prices = collect(json_decode($response, true)['serie']);
        $prices = $prices->first(function ($price) use ($date) {
            return Carbon::parse($price['fecha'])->toDateString() == $date;
        });

        return $prices['valor'] ?? null;
    }
}
