<?php

namespace App\Listeners;

use App\Events\transactionUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class transactionUpdatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  transactionUpdated  $event
     * @return void
     */
    public function handle(transactionUpdated $event)
    {
        echo $event->transData;
    }
}
