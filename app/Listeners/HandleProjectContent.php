<?php

namespace App\Listeners;

use App\Events\WriteProjectContent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleProjectContent
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WriteProjectContent $event): void
    {
        //
    }
}
