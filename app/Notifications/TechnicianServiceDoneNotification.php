<?php

namespace App\Notifications;

use App\Models\Operational\ServiceDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TechnicianServiceDoneNotification extends Notification
{
    use Queueable;

    private $service_detail;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ServiceDetail $service_detail)
    {
        $this->service_detail = $service_detail;
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
        return [
            'title' => 'Servis Telah Selesai',
            'message' => 'Servis telah selesai dilakukan ' . $this->service_detail->service->kode_servis,
            'service_id' => $this->service_detail->service->id,
            'url' => route('backsite.notification.serviceDone', $this->service_detail->service->id),
        ];
    }
}
