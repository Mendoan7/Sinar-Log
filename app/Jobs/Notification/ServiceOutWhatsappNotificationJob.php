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

class ServiceOutWhatsappNotificationJob implements ShouldQueue
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
        $status = $this->service->status;
        $kondisi = $this->service->service_detail->kondisi;
        $tanggal = $this->service->service_detail->transaction->updated_at;
        $pengambil = $this->service->service_detail->transaction->pengambil;
        $pembayaran = $this->service->service_detail->transaction->pembayaran;
        $garansi = $this->service->service_detail->transaction->garansi;

        //Merubah Format Biaya
        $biaya = number_format($this->service->service_detail->biaya, 0, ',', '.');
        $biaya = "Rp. " . $biaya;

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

        // Status
        $statusnya = "";

        if ($status == 8) {
            $statusnya = "Bisa Diambil";
        } elseif ($status == 9) {
            $statusnya = "Sudah Diambil";
        }
        
        // Kondisi
        $kondisinya = "";

        if ($kondisi == 1) {
            $kondisinya = "Sudah Jadi";
        } elseif ($kondisi == 2) {
            $kondisinya = "Tidak Bisa";
        } elseif ($kondisi == 3) {
            $kondisinya = "Dibatalkan";
        }

        $message = "*Notifikasi | SINAR CELL*\n\nBarang servis $jenis $tipe dengan No. Servis $kode Sudah Diambil dalam kondisi *$kondisinya* pada tanggal $tanggal oleh *$pengambil* dengan pembayaran *$pembayaran*. Garansi *$garansi*. Terima Kasih atas kepercayaan Anda telah melakukan Servis di *SINAR CELL*";
        $countryCode = '62'; // optional

        $client = new Client();

        $response = $client->post('https://api.fonnte.com/send', [
            'headers' => [
                'Authorization' => '0AfWd@ZvwV-4@JpBbMpq' // Ganti dengan token Anda
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
