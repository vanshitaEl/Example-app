<?php

namespace App\Observers;

use App\Models\verifyUser;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Log;
class VerifyUserObserver
{
    /**
     * Handle the verifyUser "created" event.
     */
    public function created(verifyUser $verifyUser): void
    {
       
        $token = $verifyUser->token;
        dispatch(new SendEmailJob($token))->delay(now()->addMinutes(1));
        Log::info('Token is deleted successfully', ['token' => $token]);
    }

    /**
     * Handle the verifyUser "updated" event.
     */
    public function updated(verifyUser $verifyUser): void
    {
        //
    }

    /**
     * Handle the verifyUser "deleted" event.
     */
    public function deleted(verifyUser $verifyUser): void
    {
        //
    }

    /**
     * Handle the verifyUser "restored" event.
     */
    public function restored(verifyUser $verifyUser): void
    {
        //
    }

    /**
     * Handle the verifyUser "force deleted" event.
     */
    public function forceDeleted(verifyUser $verifyUser): void
    {
        //
    }
}
