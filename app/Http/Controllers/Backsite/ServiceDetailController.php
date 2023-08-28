<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceDetail\StoreServiceDetailRequest;
use App\Http\Requests\ServiceDetail\WarrantyServiceDetailRequest;
use App\Jobs\Notification\ServiceDoneEmailNotificationJob;
use App\Jobs\Notification\ServiceDoneWhatsappNotificationJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Notification;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\ServiceCreatedMail;


// use model here
use App\Models\User;
use App\Models\Operational\Customer;
use App\Models\Operational\Service;
use App\Models\Operational\ServiceDetail;
use App\Models\Operational\Transaction;
use App\Models\Operational\WarrantyHistory;
use App\Notifications\TechnicianServiceDoneNotification;

class ServiceDetailController extends Controller
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

    public function index(Request $request)
    {
        $status = $request->query('status'); // filter data berdasarkan parameter di URL
        $user = Auth::user(); //Cek user login

        $service_detailQuery = ServiceDetail::with('service')->whereHas('service', function ($query) {
            $query->whereIn('status', [8])->orWhereHas('service_detail.warranty_history', function ($query) {
                $query->where('status', 2);
            });
        });

        // Login sebagai teknisi
        if ($user->detail_user->type_user_id == 3) {
            $service_detailQuery->whereHas('service', function ($query) use ($user) {
                $query->where('teknisi', $user->id);
            });
        }

        $service_detail = $service_detailQuery->get();

        // Counting
        $all_count = $service_detail->count();
        $done_count = $service_detail->filter(function ($item) {
            return optional($item)->warranty_history ? $item->warranty_history->kondisi == 1 : $item->kondisi == 1;
        })->count();
        $notdone_count = $service_detail->filter(function ($item) {
            return optional($item)->warranty_history ? $item->warranty_history->kondisi == 2 : $item->kondisi == 2;
        })->count();
        $cancel_count = $service_detail->filter(function ($item) {
            return optional($item)->warranty_history ? $item->warranty_history->kondisi == 3 : $item->kondisi == 3;
        })->count();
        
        // Filter Tab
        if ($status) {
            if ($status == 'done') {
                $kondisi = 1;
            } elseif ($status == 'notdone') {
                $kondisi = 2;
            } elseif ($status == 'cancel') {
                $kondisi = 3;
            }
    
            $service_detailQuery->where(function ($query) use ($kondisi) {
                $query->whereHas('warranty_history', function ($query) use ($kondisi) {
                    $query->where('kondisi', $kondisi);
                })->orWhereDoesntHave('warranty_history')
                ->where('kondisi', $kondisi);
            });
        }

        $service_detail = $service_detailQuery->orderBy('created_at', 'desc')->get();

        return view('pages.backsite.operational.service-detail.index', compact('service_detail', 'all_count', 'done_count', 'notdone_count', 'cancel_count'));
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
    public function store(StoreServiceDetailRequest $request)
    {
        $data = $request->only(['kondisi', 'tindakan', 'modal', 'biaya']);
        $service_id = $request->input('service_id');

        $service = Service::findOrFail($service_id);

        $service_detail = $service->service_detail;

        // Cek apakah ada service_detail terakit
        if (!$service_detail) {
            $service_detail = new ServiceDetail();
            $service_detail->service_id = $service->id;
        }
        
        $data['modal'] = str_replace(',', '', $data['modal']);
        $data['modal'] = str_replace('RP. ', '', $data['modal']);
        $data['biaya'] = str_replace(',', '', $data['biaya']);
        $data['biaya'] = str_replace('RP. ', '', $data['biaya']);

        $data['tindakan'] = json_encode($data['tindakan']);
        $data['modal'] = json_encode($data['modal']);

        // save to database
        $service_detail->kondisi = $data['kondisi'];
        $service_detail->tindakan = $data['tindakan'];
        $service_detail->modal = $data['modal'];
        $service_detail->biaya = $data['biaya'];
        $service_detail->save();

        // Update service
        $service->date_done = Carbon::now();
        $service->status = 8;
        $service->save();

        $admins = User::whereHas('detail_user.type_user', function ($query) {
            $query->where('type_user_id', 2); // Mengambil pengguna dengan tipe 1 dan 2 (admin)
        })->get();

        foreach ($admins as $admin) {
            $admin->notify(new TechnicianServiceDoneNotification($service_detail));
        }

        $sendNotification = $request->input('send_notification'); // Ambil nilai dari input checkbox
        
        if ($sendNotification) {
            // Kirim Notif Whatsapp Queue
            ServiceDoneWhatsAppNotificationJob::dispatch($service)->onQueue('notifications');
                                    
            // Kirim Notif Email Queue
            ServiceDoneEmailNotificationJob::dispatch($service)->onQueue('notifications');
        }

        alert()->success('Success Message', 'Berhasil, barang siap diambil');
        return redirect()->route('backsite.service.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceDetail $service_detail)
    {
        $service_detail->forceDelete();
        $service_detail->service->forceDelete();

        alert()->success('Success Message', 'Berhasil menghapus data transaksi');
        return back();
    }

    // Custom
    public function reservice($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        
        // Clear service_detail attributes except 'service_id' and 'kerusakan'
        $service->service_detail()->update([
            'kondisi' => null,
            'tindakan' => null,
            'modal' => null,
            'biaya' => null,
        ]);
        
        // Update service status
        $service->status = 2;
        $service->save();
        
        // Redirect to service index or wherever needed
        alert()->success('Success Message', 'Dilakukan servis kembali');
        return redirect()->route('backsite.service.index');
    }

    public function warranty(WarrantyServiceDetailRequest $request)
    {
        $data = $request->only(['kondisi', 'tindakan', 'catatan']);

        $service_id = $request->input('service_id');
        $service_detail = ServiceDetail::where('service_id', $service_id)->first();

        $warranty_history = $service_detail->warranty_history;

        // Cek apakah sudah ada warranty_history terkait
        if (!$warranty_history) {
            $warranty_history = new WarrantyHistory;
            $warranty_history->service_detail = $service_detail->id;
        }

        // save to database
        $warranty_history->kondisi = $data['kondisi'];
        $warranty_history->tindakan = $data['tindakan'];
        $warranty_history->catatan = $data['catatan'];
        $warranty_history->status = 2;
        $warranty_history->save();

        alert()->success('Success Message', 'Garansi siap untuk diambil');
        return redirect()->route('backsite.service-detail.index');
    }

    public function sendNotification(Request $request) {

        $services_item = ServiceDetail::with('service.customer')
                                ->find($request->service_detail_id);
        $contacts = $services_item->service->customer->contact;
        $kode = $services_item->service->kode_servis;
        $jenis = $services_item->service->jenis;
        $tipe = $services_item->service->tipe;
        $status = $services_item->service->status;
        $kondisi = $services_item->kondisi;
        
        //Merubah Format Biaya
        $biaya = number_format($services_item->biaya, 0, ',', '.');
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

        $trackLink = route('tracking.show', ['id' => $services_item->service->id]);
    
        // Teks pesan yang akan dikirim
        $message = "*Notifikasi | SINAR CELL*\n\n$selamat, pelanggan yang terhormat. Barang servis $jenis $tipe dengan No. Servis $kode kondisinya *$kondisinya* dan *$statusnya* dengan biaya *$biaya*. Terima Kasih.";
        $message .= "\nUntuk memantau servis barang anda, silahkan buka link dibawah ini.\n\n$trackLink";
    
        // Link whatsapp
        $waLink = "https://wa.me/$contacts?text=".urlencode($message);
    
        // Redirect ke halaman whatsapp
        return redirect($waLink);
    }
}
