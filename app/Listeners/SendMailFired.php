<?php

namespace App\Listeners;

use App\Events\jobCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class SendMailFired
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
     * @param  \App\Events\jobCompleted  $event
     * @return void
     */
    public function handle(jobCompleted $event)
    {
        dd($event->id);
          Mail::send('send', $item, function($message) use ($item) {
            $message->to($item['email']);
            $message->subject('Event Testing');
        });
    }
}
