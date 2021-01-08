<?php

namespace App\Listeners;

use App\Events\ItemsUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ItemsUpdatedListener
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
     * @param  ItemsUpdated  $event
     * @return void
     */
    public function handle(ItemsUpdated $event)
    {
        echo $event->item;
    }
}
