<?php

namespace App\Jobs;
use App\Models\verifyUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Monolog\Handler\SendGridHandler;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $token;
    /**
     * Create a new job instance.
     */
    public function __construct($token)
    {

        $this->token = $token;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $verifyUser = new verifyUser;
        $token = $verifyUser->token;
        verifyUser::where('token', $token)->delete();
    }
}
