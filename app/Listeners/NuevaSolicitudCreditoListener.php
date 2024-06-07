<?php

namespace App\Listeners;

use App\Events\NuevaSolicitudCreditoEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NuevaSolicitudCreditoListener
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
     * @param  \App\Events\NuevaSolicitudCreditoEvent  $event
     * @return void
     */
    public function handle(NuevaSolicitudCreditoEvent $event)
    {
        //
    }
}
