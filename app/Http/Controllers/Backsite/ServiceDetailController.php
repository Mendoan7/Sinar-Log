<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Auth\AuthManager;

// use model here
use App\Models\User;
use App\Models\Operational\Customer;
use App\Models\Operational\Service;
use App\Models\Operational\ServiceDetail;
use App\Models\Operational\Transaction;
use App\Models\Operational\WarrantyHistory;

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
        // filter data berdasarkan parameter di URL
        $status = $request->query('status');

        $all_count = ServiceDetail::with('service')->whereHas('service', function ($query) {
            $query->whereIn('status', [8,11]);
        })->count();
    
        $done_count = ServiceDetail::with('service')->whereHas('service', function ($query) {
            $query->whereIn('status', [8,11]);
        })->where('kondisi', 1)->count();
    
        $notdone_count = ServiceDetail::with('service')->whereHas('service', function ($query) {
            $query->whereIn('status', [8,11]);
        })->where('kondisi', 2)->count();
    
        $cancel_count = ServiceDetail::with('service')->whereHas('service', function ($query) {
            $query->whereIn('status', [8,11]);
        })->where('kondisi', 3)->count();

        $service_detail = ServiceDetail::with('service')->whereHas('service', function ($query) {
            $query->whereIn('status', [8,11]);
        });

        if ($status == 'done') {
            $service_detail->where('kondisi', 1);
        } elseif ($status == 'notdone') {
            $service_detail->where('kondisi', 2);
        } elseif ($status == 'cancel') {
            $service_detail->where('kondisi', 3);
        }

        $service_detail = $service_detail->orderBy('created_at', 'desc')->get();

        // Warranty
        
        
        return view('pages.backsite.operational.service-detail.index', compact('service_detail', 'all_count', 'done_count', 'notdone_count', 'cancel_count' ));
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
    public function store(Request $request)
    {
        $data = $request->all();
    
        $service = Service::where('id', $data['service_id'])->first();
        
        $data['modal'] = str_replace(',', '', $data['modal']);
        $data['modal'] = str_replace('RP. ', '', $data['modal']);
        $data['biaya'] = str_replace(',', '', $data['biaya']);
        $data['biaya'] = str_replace('RP. ', '', $data['biaya']);

        // save to database
        $service_detail = new ServiceDetail;
        $service_detail->service_id = $service->id;
        $service_detail->kondisi = $data['kondisi'];
        $service_detail->tindakan = $data['tindakan'];
        $service_detail->modal = $data['modal'];
        $service_detail->biaya = $data['biaya'];
        $service_detail->save();
        $service->status = 8;
        $service->save();

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
        $service_detail->service->forceDelete();

        alert()->success('Success Message', 'Berhasil menghapus data transaksi');
        return back();
    }

    // Custom
    public function warranty(Request $request)
    {
        $data = $request->only(['kondisi', 'tindakan', 'catatan']);

        $service_id = $request->input('service_id');
        $service_detail = ServiceDetail::where('service_id', $service_id)->first();

        $warranty_history = $service_detail->transaction->warranty_history;

        // Cek apakah sudah ada warranty_history terkait
        if (!$warranty_history) {
            $warranty_history = new WarrantyHistory;
            $warranty_history->transaction_id = $service_detail->transaction_id;
        }

        // save to database
        $warranty_history->kondisi = $data['kondisi'];
        $warranty_history->tindakan = $data['tindakan'];
        $warranty_history->catatan = $data['catatan'];
        $warranty_history->save();

        // Ubah status transaksi
        $service_detail->service->status = 11;
        $service_detail->service->save();

        alert()->success('Success Message', 'Garansi siap untuk diambil');
        return redirect()->route('backsite.transaction.index');
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
    
        // Teks pesan yang akan dikirim
        $message = "*Notifikasi | SINAR CELL*\n\n$selamat, pelanggan yang terhormat. Barang servis $jenis $tipe dengan No. Servis $kode kondisinya *$kondisinya* dan *$statusnya* dengan biaya *$biaya*.\nTerima Kasih.";
    
        // Link whatsapp
        $waLink = "https://wa.me/$contacts?text=".urlencode($message);
    
        // Redirect ke halaman whatsapp
        return redirect($waLink);
    }
}
