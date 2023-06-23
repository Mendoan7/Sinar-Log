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
        $customer = Customer::where('contact', $request->contact)->first();
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
        
        if ($service->status <= 7) {
            $service_detail = null;
            $transaction = null;
        } elseif ($service->status == 8) {
            $service_detail = $service->service_detail;
            $transaction = null;
        } else {
            $service_detail = $service->service_detail;
            $transaction = $service_detail?->transaction;
        }

        $warrantyInfo = [];

        if ($transaction) {
            $warranty = $transaction->garansi;
            $end_warranty = $transaction->created_at->addDays($warranty);
            $remainingTime = now()->diff($end_warranty);
            $sisa_warranty = $remainingTime->format('%d Hari %h Jam');

            $warrantyInfo[$transaction->id] = [
                'warranty' => $warranty,
                'end_warranty' => $end_warranty,
                'sisa_warranty' => $sisa_warranty,
            ];
        }
        
        return view('pages.frontsite.tracking.show', compact('service', 'service_detail', 'transaction', 'warrantyInfo'));
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
