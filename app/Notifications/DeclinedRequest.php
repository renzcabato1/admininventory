<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DeclinedRequest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $req;
    protected $requestor;
    public function __construct($req,$requestor)
    {
        //
        $this->req = $req;
        $this->requestor = $requestor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->subject('TR-'.str_pad($this->req->id, 4, '0', STR_PAD_LEFT).' Approved Request')
                ->greeting('Good day,')
                ->line('Your request has been declined.')
                ->line('Approver : '.$this->requestor)
                ->line('Request Number : TR-'.str_pad($this->req->id, 4, '0', STR_PAD_LEFT))
                ->line('Please click the button provided for faster transaction')
                ->action('requests', url('/requests'))
                ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
