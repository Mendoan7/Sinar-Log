<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Auth\AuthManager;

use Carbon\Carbon;

// request
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;

// use model here
use App\Models\User;
use App\Models\Operational\Customer;
use App\Models\Operational\Service;

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
        $service = Service::orderBy('created_at', 'asc')->whereIn('status', [1,2,3,4,5,6])->get();

        // hitung lama servis yang masuk
        foreach ($service as $service_item) {
            $now = Carbon::now();
            $created_at = Carbon::parse($service_item->created_at);
            
            if ($created_at->isToday()) {
                $service_item->duration = "Hari Ini";
            } else {
                $service_item->duration = $created_at->diffInDays($now) . " Hari";
            }
        }

        // for select2 = ascending a to z
        $customer = Customer::orderBy('name', 'asc')->get();

        return view('pages.backsite.operational.service.index', compact('service', 'customer'));
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
        // // get all request from frontsite
        $data = $request->all();

        // set random code for transaction code
        $data['kode_servis'] = Str::upper(Str::random(6).date('dmy'));

        $service = new Service;
        $service->user_id = Auth::user()->id;
        $service->customer_id = $data['customer_id'];
        $service->kode_servis = $data['kode_servis'];
        $service->jenis = $data['jenis'];
        $service->tipe = $data['tipe'];
        $service->kelengkapan = $data['kelengkapan'];
        $service->kerusakan = $data['kerusakan'];
        $service->penerima =  Auth::user()->name;
        $service->status = 1; // set to belum cek
        $service->save();

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

        alert()->success('Success Message', 'Berhasil menghapus data pelanggan');
        return back();
    }

    // Custom
    public function sendConfirmation(Request $request) {

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
    
        // Teks pesan yang akan dikirim
        $tindakan = $request->input('tindakan');
        $biaya = $request->input('biaya');
        $message = "*Konfirmasi Servis | SINAR CELL*\n\n$selamat, pelanggan yang terhormat.\nKami ingin melakukan konfirmasi untuk mengatasi kerusakan pada barang servis $jenis $tipe dengan No. Servis $kode akan dilakukan tindakan *$tindakan* dengan biaya *$biaya*.\nMohon segera konfirmasi kembali untuk melanjutkan tidaknya servis. Terima Kasih.";
    
        // Link whatsapp
        $waLink = "https://wa.me/$contacts?text=".urlencode($message);
    
        // Redirect ke halaman whatsapp
        return redirect($waLink);
    }
}
