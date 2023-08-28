<?php

namespace App\Http\Controllers\Frontsite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Operational\Customer;
use App\Models\Operational\Service;
use App\Models\Operational\ServiceDetail;
use App\Models\Tracking;

class TrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.frontsite.tracking.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function track(Request $request)
    {
        // Ambil nomor telepon yang dimasukkan oleh pengguna
        $inputContact = $request->contact;

        // Ubah format nomor telepon menjadi '6285815203540'
        if (substr($inputContact, 0, 2) !== '62') {
            $formattedContact = '62' . ltrim($inputContact, '0');
        } else {
            $formattedContact = $inputContact;
        }

        // Cari data pelanggan berdasarkan nomor telepon yang sudah diubah formatnya
        $customer = Customer::where('contact', $formattedContact)->first();

        if (!$customer) {
            return redirect()->back()->with('error', 'Pelanggan dengan nomor telepon tersebut tidak ditemukan.');
        }

        $track = Customer::with('service')->find($customer->id);

        return view('pages.frontsite.tracking.data', compact('track'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $service = Service::findOrFail($id);
        $customers = Service::where('customer_id', $service->customer_id)->get();
        $count = $customers->count();

        if ($count > 1) {
            $remainingCount = $count - 1;
            $buttonSisa = "Cek {$remainingCount} Servis Lainnya";
        } else {
            $buttonSisa = "";
        }
        
        if ($service->status <= 7) {
            $service_detail = null;
        } elseif ($service->status == 8) {
            $service_detail = $service->service_detail;
        } else {
            $service_detail = $service->service_detail;
        }

        $warrantyInfo = [];

        if ($service) {
            $warranty = $service_detail->garansi;
            $end_warranty = Carbon::parse($service->date_out)->addDays($warranty);
            $remainingTime = now()->diff($end_warranty);
            $sisa_warranty = $remainingTime->format('%d Hari %h Jam');

            $warrantyInfo[$service->id] = [
                'warranty' => $warranty,
                'end_warranty' => $end_warranty,
                'sisa_warranty' => $sisa_warranty,
            ];
        }
        
        return view('pages.frontsite.tracking.show', compact('service', 'service_detail', 'warrantyInfo', 'buttonSisa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
