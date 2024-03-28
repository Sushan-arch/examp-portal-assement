<?php

namespace App\Http\Services;

use App\Mail\InvitationMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * MailService
 */
class MailService
{
    /**
     * sendInvitationEmail
     *
     * @param  array $mailPayload
     */
    public function sendInvitationEmail(array $mailPayload): bool
    {
        try {
            $mail = new InvitationMail($mailPayload);
            Mail::to($mailPayload['email'])->send($mail);
            return true;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return false;
        }
    }
}
