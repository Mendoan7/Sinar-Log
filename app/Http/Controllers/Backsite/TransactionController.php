<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\ClaimWarrantyRequest;
use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Http\Requests\Transaction\WarrantyTransactionRequest;
use App\Jobs\Notification\ServiceOutEmailNotificationJob;
use App\Jobs\Notification\ServiceOutWhatsappNotificationJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

// use model here
use App\Notifications\TaskWarrantyNotification;
use App\Models\User;
use App\Models\Operational\Customer;
use App\Models\Operational\Service;
use App\Models\Operational\ServiceDetail;
use App\Models\Operational\WarrantyHistory;

class TransactionController extends Controller
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

        $serviceQuery = Service::with(['service_detail.warranty_history'])
            ->where('status', 9)
            ->where(function ($query) {
                $query->whereDoesntHave('service_detail.warranty_history')
                    ->orWhereHas('service_detail.warranty_history', function ($query) {
                        $query->where('status', 3);
                    });
            });
            
        // Login sebagai teknisi
        if ($user->detail_user->type_user_id == 3) {
            $serviceQuery->whereHas('service_detail.service', function ($query) use ($user) {
                $query->where('teknisi', $user->id);
            });
        }

        // Filter Rentang Tanggal
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        if ($start_date && $end_date) {
            $serviceQuery->where(function ($query) use ($start_date, $end_date) {
                $query->whereDate('date_done', '>=', $start_date)
                    ->whereDate('date_done', '<=', $end_date)
                    ->orWhereHas('service_detail.warranty_history', function ($query) use ($start_date, $end_date) {
                        $query->whereDate('updated_at', '>=', $start_date)
                            ->whereDate('updated_at', '<=', $end_date);
                    });
            });
        }

        // Counting
        $services = $serviceQuery->get();
        $all_count = $services->count();
        $done_count = $services->filter(function ($service) {
            if ($service->service_detail->warranty_history) {
                return $service->service_detail->warranty_history->kondisi == 1;
            } else {
                return $service->service_detail->kondisi == 1;
            }
        })->count();
        $notdone_count = $services->filter(function ($service) {
            if ($service->service_detail->warranty_history) {
                return $service->service_detail->warranty_history->kondisi == 2;
            } else {
                return $service->service_detail->kondisi == 2;
            }
        })->count();
        $cancel_count = $services->filter(function ($service) {
            if ($service->service_detail->warranty_history) {
                return $service->service_detail->warranty_history->kondisi == 3;
            } else {
                return $service->service_detail->kondisi == 3;
            }
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

            $serviceQuery->where(function ($query) use ($kondisi) {
                $query->where(function ($query) use ($kondisi) {
                    $query->whereHas('service_detail.warranty_history', function ($query) use ($kondisi) {
                        $query->where('kondisi', $kondisi);
                    });
                })->orWhere(function ($query) use ($kondisi) {
                    $query->whereHas('service_detail', function ($query) use ($kondisi) {
                        $query->where('kondisi', $kondisi);
                    })->whereDoesntHave('service_detail.warranty_history');
                });
            });
        }

        // $serviceQuery->where(function ($query) use ($kondisi) {
        //     $query->whereHas('service_detail', function ($query) use ($kondisi) {
        //         $query->where('kondisi', $kondisi);
        //     })->orWhereHas('service_detail.warranty_history', function ($query) use ($kondisi) {
        //         $query->where('kondisi', $kondisi);
        //     });
        // });

        // Garansi
        $warrantyInfo = [];
        foreach ($services as $service) {
            $warranty = $service->service_detail->garansi;
            $end_warranty = Carbon::parse($service->date_out)->addDays($warranty);
            $remainingTime = now()->diff($end_warranty);
            $sisa_warranty = $remainingTime->format('%d Hari %h Jam');

            $warrantyInfo[$service->id] = [
                'warranty' => $warranty,
                'end_warranty' => $end_warranty,
                'sisa_warranty' => $sisa_warranty,
            ];
        }

        $services = $serviceQuery->orderBy('created_at', 'desc')->get();

        return view('pages.backsite.operational.transaction.index', compact('services', 'all_count', 'done_count', 'notdone_count', 'cancel_count', 'warrantyInfo'));
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
    public function store(StoreTransactionRequest $request)
    {
        $data = $request->all();

        $service_detail = ServiceDetail::findOrFail($data['service_detail_id']);
        
        // Update service detail
        $service_detail->pembayaran = $data['pembayaran'];
        $service_detail->garansi = $data['garansi'];
        $service_detail->save();

        $service = $service_detail->service;

        if ($service) {
            // Update service
            $service->status = 9;
            $service->pengambil = $data['pengambil'];
            $service->penyerah = Auth::user()->name;
            $service->date_out = Carbon::now();
            $service->save();
            
            // Cek checkbox apakah akan mengirim notifikasi
            $sendNotification = $request->input('send_notification'); // Ambil nilai dari input checkbox
            if ($sendNotification) {
                
                // Kirim Notif Whatsapp Queue
                ServiceOutWhatsappNotificationJob::dispatch($service)->onQueue('notifications');

                // Kirim Notif Email Queue
                ServiceOutEmailNotificationJob::dispatch($service)->onQueue('notifications');
            }
        }

        alert()->success('Success Message', 'Barang telah selesai diambil');
        return redirect()->route('backsite.transaction.index');
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
    public function destroy(Service $service)
    {
        // Menghapus data dari tabel Service
        $service->forceDelete();

        // Menghapus data dari tabel Service_Detail
        $service->service_detail->forceDelete();

        alert()->success('Success Message', 'Berhasil menghapus data transaksi');
        return back();
    }

    // Custom
    public function warranty(WarrantyTransactionRequest $request)
    {
        $data = $request->only(['pengambil', 'penyerah']);

        $service_detail_id = $request->input('service_detail_id');
        $service_detail = ServiceDetail::where('id', $service_detail_id)->first();

        $warranty_history = $service_detail->warranty_history;

        // Cek apakah sudah ada warranty_history terkait
        if (!$warranty_history) {
            $warranty_history = new WarrantyHistory;
            $warranty_history->service_detail_id = $service_detail->id;
        }

        // save to database
        $warranty_history->pengambil = $data['pengambil'];
        $warranty_history->penyerah = Auth::user()->name;
        $warranty_history->status = 3;
        $warranty_history->save();

        alert()->success('Success Message', 'Garansi sudah diambil');
        return redirect()->route('backsite.transaction.index');
    }

    public function claimWarranty(ClaimWarrantyRequest $request)
    {
        $data = $request->all();
        
        $service_detail = ServiceDetail::where('id', $data['service_detail_id'])->first();

        // Buat record baru pada tabel warranty_history
        $warrantyHistory = new WarrantyHistory;
        $warrantyHistory->service_detail_id = $service_detail->id;
        $warrantyHistory->keterangan = $data['keterangan'];
        $warrantyHistory->status = 1;
        $warrantyHistory->save();

        // Kirim notifikasi tugas ke teknisi sebelumnya
        $taskTeknisi = $service_detail->service->teknisi;
        if ($taskTeknisi) {
            $teknisi = User::where('id', $taskTeknisi)->first();

            if ($teknisi) {
                $teknisi->notify(new TaskWarrantyNotification($service_detail));
                alert()->success('Success Message', 'Berhasil mengklaim garansi');
            } else {
                alert()->error('Error Message', 'Teknisi tidak ditemukan');
            }
        }
        return back();
    }
    
    // Send Whatsapp Customer
    public function sendNotification(Request $request) 
    {

        $service_item = Service::with('service_detail.service.customer')
                        ->find($request->service_id);

        $contacts = $service_item->customer->contact;
        $kode = $service_item->kode_servis;
        $jenis = $service_item->jenis;
        $tipe = $service_item->tipe;
        $status = $service_item->status;
        $kondisi = $service_item->service_detail->kondisi;
        $tanggal = Carbon::parse($service_item->date_out)->isoFormat('D MMMM Y HH:mm');
        $pengambil = $service_item->pengambil;
        $pembayaran = $service_item->service_detail->pembayaran;
        $garansi = $service_item->service_detail->garansi;
        $trackLink = route('tracking.show', ['id' => $service_item->id]);
        
        //Merubah Format Biaya
        $biaya = number_format($service_item->service_detail->biaya, 0, ',', '.');
        $biaya = "Rp. " . $biaya;

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

        if ($service_item->service_detail->garansi == 0) {
            $garansi = "Tidak Ada";
        } else {
            $garansi = $service_item->service_detail->garansi . " Hari";
        }
    
        // Teks pesan yang akan dikirim
        $message = "*Notifikasi | SINAR CELL*\n\nBarang servis $jenis $tipe dengan No. Servis $kode, *$statusnya* dalam kondisi *$kondisinya* pada tanggal $tanggal oleh *$pengambil* dengan pembayaran *$pembayaran*. Garansi *$garansi*. Terima Kasih atas kepercayaan Anda telah melakukan Servis di *SINAR CELL*.";
        $message .= "\nUntuk mengecek masa garansi Anda, dapat buka link dibawah ini.\n\n$trackLink";
        
        // Link whatsapp
        $waLink = "https://wa.me/$contacts?text=".urlencode($message);
    
        // Redirect ke halaman whatsapp
        return redirect($waLink);
    }
}


