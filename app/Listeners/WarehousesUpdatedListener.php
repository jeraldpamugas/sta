<?php

namespace App\Listeners;

use App\Events\WarehousesUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WarehousesUpdatedListener
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
     * @param  WarehousesUpdated  $event
     * @return void
     */
    public function handle(WarehousesUpdated $event)
    {
        //
    }
}
