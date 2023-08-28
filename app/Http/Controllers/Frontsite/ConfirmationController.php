<?php

namespace App\Http\Controllers\Frontsite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

use App\Notifications\ServiceConfirmationNotification;
use App\Models\User;
use App\Models\Operational\Customer;
use App\Models\Operational\Service;

class ConfirmationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return abort(404);
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
        return abort(404);
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
    public function destroy($id)
    {
        return abort(404);
    }

    // Custom
    public function confirmService(Request $request, $token)
    {
        $serviceItem = Service::where('confirmation_token', $token)->first();
        $status = '';

        if ($serviceItem) {
            $expired_time = Carbon::parse($serviceItem->expired_time);
            if ($expired_time->isPast()) {
                // Waktu kadaluwarsa
                $status = 'expired';
            } else {
                // Konfirmasi masih valid
                if ($request->has('action')) {
                    $action = $request->input('action');

                    if ($action == 'approve') {
                        $serviceItem->status = 10; // Ubah status menjadi "approve"
                        $serviceItem->save();
                        // Kirim notifikasi ke teknisi
                        $teknisi = User::find($serviceItem->teknisi);
                        if ($teknisi) {
                            $teknisi->notify(new ServiceConfirmationNotification($serviceItem));
                        }
                        $status = 'approve';
                    } elseif ($action == 'reject') {
                        $serviceItem->status = 11; // Ubah status menjadi "reject"
                        $serviceItem->save();
                        // Kirim notifikasi ke teknisi
                        $teknisi = User::find($serviceItem->teknisi);
                        if ($teknisi) {
                            $teknisi->notify(new ServiceConfirmationNotification($serviceItem));
                        }
                        $status = 'reject';
                    }
                } else {
                    if ($serviceItem->status == 10 || $serviceItem->status == 11) {
                        // Konfirmasi sudah dilakukan sebelumnya
                        $status = 'already_confirm';
                    } else {
                        // Tampilkan halaman konfirmasi jika tidak ada aksi yang diberikan
                        $estimasiTindakan = json_decode($serviceItem->estimasi_tindakan);
                        $estimasiBiaya = json_decode($serviceItem->estimasi_biaya);
                        $totalBiaya = array_sum($estimasiBiaya);

                        return view('pages.frontsite.confirmation.index', compact('serviceItem', 'status', 'estimasiTindakan', 'estimasiBiaya', 'totalBiaya'));
                    }
                }
            }
        } else {
            $status = 'invalid_token';
        }
        return view('pages.frontsite.confirmation.index', compact('status'));
    }


}
