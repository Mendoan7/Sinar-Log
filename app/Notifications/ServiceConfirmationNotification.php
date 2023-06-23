<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\{DatabaseMessage};

class ServiceConfirmationNotification extends Notification
{
    use Queueable;

    protected $serviceItem;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($serviceItem)
    {
        $this->serviceItem = $serviceItem;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $serviceItem = $this->serviceItem;
        $status = $serviceItem->status;

        if ($status == 10) {
            $title = 'Konfirmasi Servis';
            $message = 'Pelanggan menyetujui tindakan servis yang dilakukan ' . $serviceItem->kode_servis;
            $url = route('backsite.notification.confirmation', $this->serviceItem->id);
        } elseif ($status == 11) {
            $title = 'Konfirmasi Servis';
            $message = 'Pelanggan tidak setuju dan membatalkan servis ' . $serviceItem->kode_servis;
            $url = route('backsite.notification.confirmReject', $this->serviceItem->id);
        }

        return [
            'title' => $title,
            'message' => $message,
            'service_id' => $this->serviceItem->id,
            'url' => $url,
        ];
    }
}
