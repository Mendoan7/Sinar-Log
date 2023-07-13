<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Operational\Service;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.backsite.notification.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();
        // Ambil data tugas servis berdasarkan ID
        $service = Service::findOrFail($id);

        // Tampilkan tampilan detail tugas servis
        return view('pages.backsite.notification.show', compact('service'));
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

    // custom
    public function serviceDone($id)
    {
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();
        // Ambil data tugas servis berdasarkan ID
        $service = Service::findOrFail($id);

        // Tampilkan tampilan detail tugas servis
        return view('pages.backsite.notification.service-done', compact('service'));
    }

    public function warranty($id)
    {
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();
        // Ambil data tugas servis berdasarkan ID
        $service = Service::findOrFail($id);

        // Tampilkan tampilan detail tugas servis
        return view('pages.backsite.notification.warranty', compact('service'));
    }

    public function confirmation($id)
    {
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();
        // Ambil data tugas servis berdasarkan ID
        $service = Service::findOrFail($id);

        // Tampilkan tampilan detail tugas servis
        return view('pages.backsite.notification.confirm-approve', compact('service'));
    }

    public function confirmReject($id)
    {
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();
        // Ambil data tugas servis berdasarkan ID
        $service = Service::findOrFail($id);

        // Tampilkan tampilan detail tugas servis
        return view('pages.backsite.notification.confirm-reject', compact('service'));
    }
}
