<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestEmail extends Notification implements ShouldQueue
{
    use Queueable;
     private $mail_data;
   
    /**
     * Create a new notification instance.
     */
    public function __construct($mail_data)
    {
        $this->mail_data = $mail_data;
        Log::info('Showing the user profile for user:', ['mail_data' => $mail_data]);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        
       
       
        return (new MailMessage)
                    ->line($this->mail_data['email'])
                    ->action($this->mail_data['actionLink'],
                    $this->mail_data['actionLink'])
                    ->line($this->mail_data['token']);
    //    return ['okay'];
    }
 

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
