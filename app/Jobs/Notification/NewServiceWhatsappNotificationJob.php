<?php

namespace App\Jobs\Notification;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Operational\Service;

class NewServiceWhatsappNotificationJob implements ShouldQueue
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
        $targetNumber = $this->service->customer->contact;
        $message = "*Notifikasi | SINAR CELL*\n\nHalo, terima kasih telah membuat servis dengan kode {$this->service->kode_servis}.";
        $countryCode = '62'; // optional

        $client = new Client();

        $response = $client->post('https://api.fonnte.com/send', [
            'headers' => [
                'Authorization' => '0AfWd@ZvwV-4@JpBbMpq'
            ],
            'form_params' => [
                'target' => $targetNumber,
                'message' => $message,
                'countryCode' => $countryCode,
            ],
        ]);

        $responseData = $response->getBody()->getContents();
        echo $responseData;
    }
}
