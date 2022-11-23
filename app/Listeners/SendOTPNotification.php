<?php

namespace App\Listeners;

use App\Abilities\SMS;
use App\Events\OtpSendingEvent;
use App\Mail\OneTimePassword;
use App\Models\EmptyObj;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendOTPNotification
{
    // Get username and message data.
    private function getSmsData($username, $otp)
    {
        $message = "Your WorksDiary verification code is " . $otp . ". This code is valid for " . Str::timeFormat(config('auth.password_timeout', 10800)) . ". Please DO NOT share this with anyone.";

        return (new EmptyObj)->setRawAttributes([
            'to'      => $username,
            'message' => $message,
        ]);

    }

    public function handle(OtpSendingEvent $event)
    {
        $username     = $event->otpInfo->username;
        $usernameType = $event->otpInfo->username_type;
        $otp          = $event->otpInfo->otp;

        if ($usernameType == 'email') {
            Mail::to($username)->send(new OneTimePassword($otp));
        }
        if ($usernameType == 'mobile') {
            $data = $this->getSmsData($username, $otp);
            (new SMS($data))->send();
        }
    }

    public function failed(OtpSendingEvent $event, $exception)
    {
        //
    }
}
