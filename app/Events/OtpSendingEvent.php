<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OtpSendingEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $otpInfo;

    /**
     * Create a new event instance.
     *
     * Listener
     * @param  \App\Listeners\SendOTPNotification
     * @return void
     */

    public function __construct($otpInfo)
    {
        $this->otpInfo = $otpInfo;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
