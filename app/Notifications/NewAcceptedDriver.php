<?php

namespace App\Notifications;

use App\Models\Ride;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAcceptedDriver extends Notification
{
    use Queueable;

    private $driver;

    private $ride;

    /**
     * Create a new notification instance.
     *
     * @param User $driver
     * @param Ride $ride
     */
    public function __construct(User $driver, Ride $ride)
    {
        $this->driver = $driver;
        $this->ride = $ride;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
//        return ['mail'];
        return ['database', 'broadcast'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
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
            'title' => 'New Driver Accepted',
            'ride' => $this->ride,
            'driver' => $this->driver,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'New Driver Accepted',
            'ride' => $this->ride,
            'driver' => $this->driver,
        ]);
    }
}
