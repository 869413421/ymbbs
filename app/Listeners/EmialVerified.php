<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmialVerified
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        session()->flash('success', '成功验证了邮件！');
    }

    /**
     * Handle the event.
     *
     * @param  Verified $event
     * @return void
     */
    public function handle(Verified $event)
    {
        //
    }
}
