<?php

namespace App\Listeners;

use App\Events\TestEmailEvent;
use App\Models\Doctor;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendEmailJob;
use App\Models\verifyUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTestEmailNotification
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
    public function handle(TestEmailEvent $event): void
    {
       
        $event->EmailVerifyToken;
        $doctor = new Doctor;
        $last_id = $doctor->id;
        $token = $last_id . hash('sha256', Str::random(120));
        Log::info('Showing the user profile for user:', ['doctor_id' => $last_id]);
        Log::info('Showing the user profile for user:', ['token' => $token]);
    }
}
