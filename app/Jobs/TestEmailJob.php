<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class TestEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected  $mail_data, $message;
    /**
     * Create a new job instance.
     */
    public function __construct($mail_data, $message)
    {

        $this->mail_data =  $mail_data;
        $this->message =  $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = new TestMail($this->mail_data, $this->message);
        Log::alert('your email is send successfully',['mail_data' =>  $this->mail_data]);
        Mail::to($this->mail_data['email'])->send($email);
    
    }
}
