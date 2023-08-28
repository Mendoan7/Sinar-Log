<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Notification;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\ServiceCreatedMail;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

// request
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;

// use model here
use App\Notifications\NewTaskNotification;
use App\Models\User;
use App\Models\TypeUser;
use App\Models\DetailUser;
use App\Models\Operational\Customer;
use App\Models\Operational\Service;

use App\Jobs\Notification\NewServiceEmailNotificationJob;
use App\Jobs\Notification\NewServiceWhatsappNotificationJob;
use App\Models\Operational\ServiceDetail;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user(); // Mendapatkan pengguna saat ini

        $query = Service::with('service_detail', 'teknisi_detail');

        if ($user->detail_user->type_user_id == 3) {
            $query->where('teknisi', $user->id)
                ->whereIn('status', [2, 3, 4, 5, 6, 7, 10, 11])
                ->orWhereHas('service_detail.warranty_history', function ($query) {
                    $query->where('status', 1);
            });
        } else {
            $query->whereIn('status', [1, 2, 3, 4, 5, 6, 7, 10, 11])
            ->orWhereHas('service_detail.warranty_history', function ($query) {
                $query->where('status', 1);
            });
        }

        $service = $query->orderBy('created_at', 'asc')->get();

        // Mengambil pengguna dengan tipe pengguna 3
        $technicians = User::whereHas('detail_user', function ($query) {
            $query->where('type_user_id', 3);
        })->where('status', true)->get();
    
        $now = Carbon::now();
        $warrantyInfo = [];
    
        foreach ($service as $service_item) {
            $created_at = Carbon::parse($service_item->created_at)->startOfDay();
            $daysPassed = $created_at->diffInDays($now);

            if ($daysPassed == 0) {
                $service_item->duration = "Hari Ini";
            } else {
                $service_item->duration = $daysPassed . " Hari";
            }
    
            if ($service_item->service_detail?->transaction?->warranty_info?->status == 1) {
                $warranty_history = $service_item->service_detail->warranty_history;
                if ($warranty_history) {
                    $created_at = Carbon::parse($warranty_history->created_at)->startOfDay();
                    $daysPassed = $created_at->diffInDays($now);
    
                    if ($daysPassed == 0) {
                        $service_item->duration = "Hari Ini";
                    } else {
                        $service_item->duration = $daysPassed . " Hari";
                    }
                }
            }
            
            // Garansi
            $serviceDetail = $service_item->service_detail;
            if ($serviceDetail) {
                $warranty = $serviceDetail->garansi;
                $endWarranty = Carbon::parse($service_item->date_out)->addDays($warranty);
                $remainingTime = now()->diff($endWarranty);
                $sisaWarranty = $remainingTime->format('%d Hari %h Jam');
    
                $warrantyInfo[$service_item->id] = [
                    'warranty' => $warranty,
                    'end_warranty' => $endWarranty,
                    'sisa_warranty' => $sisaWarranty,
                ];
            }
        }

        $customer = Customer::orderBy('name', 'asc')->get();

        return view('pages.backsite.operational.service.index', compact('service', 'customer', 'technicians', 'warrantyInfo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequest $request)
    {
        // // get all request from frontsite
        $data = $request->validated();

        // set random code for transaction code
        $data['kode_servis'] = Str::upper(Str::random(6).date('dmy'));

        $service = new Service;
        $service->user_id = Auth::user()->id;
        $service->customer_id = $data['customer_id'];
        $service->kode_servis = $data['kode_servis'];
        $service->jenis = $data['jenis'];
        $service->tipe = $data['tipe'];
        $service->kelengkapan = $data['kelengkapan'];
        $service->penerima =  Auth::user()->name;
        $service->status = 1; // set to belum cek
        $service->save();

        $service_detail = new ServiceDetail;
        $service_detail->service_id = $service->id;
        $service_detail->kerusakan = $data['kerusakan'];
        $service_detail->save();

        // Ambil nilai checkbox dari request
        $sendNotification = $request->input('send_notification');

        if ($sendNotification) {
            // Kirim Notif Whatsapp Queue
            NewServiceWhatsAppNotificationJob::dispatch($service)->onQueue('notifications');

            // Kirim Notif Email Queue
            NewServiceEmailNotificationJob::dispatch($service)->onQueue('notifications');
        }

        alert()->success('Berhasil', 'Sukses menambahkan data servis baru');
        return redirect()->route('backsite.service.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        $service->load('customer');

        return view('pages.backsite.operational.service.index', compact('service','customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $service->load('customer');

        return view('pages.backsite.operational.service.index', compact('service', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        // get all request from frontsite
        $data = $request->all();

        // update to database
        $service->update($data);

        alert()->success('Success Message', 'Berhasil memperbarui status');
        return redirect()->route('backsite.service.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->forceDelete();

        alert()->success('Success Message', 'Berhasil menghapus data servis');
        return back();
    }

    // Custom

    public function addTechnician(Request $request)
    {
        // Mendapatkan input teknisi yang dipilih dari form
        $selectedTechnician = $request->input('teknisi');

        // Mendapatkan data service yang akan diperbarui
        $service = Service::findOrFail($request->input('service_id'));

        // Memeriksa apakah teknisi sebelumnya sudah ada
        $previousTechnician = $service->teknisi;

        // Melakukan update data service
        $teknisi = User::whereHas('detail_user', function ($query) {
            $query->where('type_user_id', 3); // Filter user dengan tipe user 3 (teknisi)
        })->findOrFail($selectedTechnician);
        
        $service->teknisi = $teknisi->id;
        $service->status = 2;

        // Simpan data service yang telah diperbarui
        $service->save();

        // dd($teknisi);
        if ($teknisi) {
            // Kirim notifikasi ke teknisi
            try {
                // Memeriksa apakah teknisi sebelumnya sudah ada
                if ($previousTechnician) {
                    alert()->success('Success Message', 'Berhasil mengganti teknisi');
                } else {
                    alert()->success('Success Message', 'Berhasil menambahkan teknisi');
                }
                $teknisi->notify(new NewTaskNotification($service));
            } catch (\Exception $e) {
                alert()->error('Error Message', 'Gagal mengirim notifikasi');
            }
        } else {
            alert()->error('Error Message', 'Teknisi tidak ditemukan');
        }
        
        return back();
    }


    public function sendConfirmation(Request $request) 
    {
        $service_item = Service::find($request->service_id);
        $contacts = $service_item->customer->contact;
        $jenis = $service_item->jenis;
        $tipe = $service_item->tipe;
        $kode = $service_item->kode_servis;
        
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
    
        $tindakan = $request->input('tindakan');
        $biaya = $request->input('biaya');
        $totalBiaya = 0;

        $message = "*Konfirmasi Servis | SINAR CELL*\n\n$selamat, pelanggan yang terhormat.\nKami ingin melakukan konfirmasi untuk mengatasi kerusakan pada barang servis $jenis $tipe dengan No. Servis $kode ";

        if (count($tindakan) === 1) {
            $message .= "akan dilakukan tindakan *$tindakan[0]* dengan biaya *$biaya[0]*.";
            $totalBiaya = (int) str_replace(',', '', $biaya[0]);
        } elseif (count($tindakan) > 1) {
            $message .= "akan dilakukan tindakan:\n";

            for ($i = 0; $i < count($tindakan); $i++) {
                $message .= "*$tindakan[$i]* (Rp $biaya[$i])";

                if ($i !== count($tindakan) - 1) {
                    $message .= ", ";
                }

                $totalBiaya += (int) str_replace(',', '', $biaya[$i]);
            }

            $message .= " dengan Total biaya *Rp " . number_format($totalBiaya, 0, ',', '.') . "*.";
        }
    
        // Link konfirmasi
        $confirmationToken = Uuid::uuid4()->toString();
        $expiredTime = Carbon::now()->addDay(); // Tambahkan 1 hari dari waktu sekarang

        $biaya = str_replace(',', '', $biaya);
        $biaya = str_replace('Rp. ', '', $biaya);
        $service_item->estimasi_tindakan = $tindakan;
        $service_item->estimasi_biaya = $biaya;
        $service_item->confirmation_token = $confirmationToken;
        $service_item->expired_time = $expiredTime;
        $service_item->save();

        $service_item->status = 6;
        $service_item->save();

        $confirmationLink = route('confirmation.service', ['token' => $confirmationToken]);

        $message .= "\n\nLink untuk melakukan konfirmasi : $confirmationLink";

        // Link whatsapp
        $waLink = "https://wa.me/$contacts?text=".urlencode($message);
    
        // Redirect ke halaman whatsapp
        return redirect($waLink);
    }

}
