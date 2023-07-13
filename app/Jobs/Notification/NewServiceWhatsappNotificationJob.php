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
use Carbon\Carbon;

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
        $kode = $this->service->kode_servis;
        $jenis = $this->service->jenis;
        $tipe = $this->service->tipe;
        $tanggal = Carbon::parse($this->service->created_at)->isoFormat('D MMMM Y HH:mm');
        $trackLink = route('tracking.show', ['id' => $this->service->id]);
        // Menentukan ucapan selamat
        $time = date("H");
        $selamat = "";
        
        if ($time >= 5 && $time <= 11) {
            $selamat = "Selamat Pagi";
        } elseif ($time >= 12 && $time <= 14) {
            $selamat = "Selamat Siang";
        } elseif ($time >= 15 && $time <= 17) {
            $selamat = "Selamat Sore";
        } else {
            $selamat = "Selamat Malam";
        }

        $message = "*Notifikasi | SINAR CELL*\n\n$selamat, pelanggan yang terhormat. Barang servis $jenis $tipe telah diterima oleh *SINAR CELL* dengan No. Servis $kode pada tanggal $tanggal. Terima Kasih.";
        $message .= "\nUntuk memantau barang servis Anda, silahkan buka link dibawah ini.\n\n$trackLink"; 
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
