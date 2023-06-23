<?php

namespace App\Jobs\Notification;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

use App\Mail\ServiceOutMail;
use App\Models\Operational\Service;

class ServiceOutEmailNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $service;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get customer's email address from the service
        $customerEmail = $this->service->customer->email;

        // Compose and send the email
        Mail::to($customerEmail)->send(new ServiceOutMail($this->service));
    }
}
