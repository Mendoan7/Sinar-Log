<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Auth\AuthManager;

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
        $service = Service::orderBy('created_at', 'desc')->get();

        // for select2 = ascending a to z
        $customer = Customer::orderBy('name', 'asc')->get();
        $service = Service::whereIn('status', [1,2,3,4,5,6])->get();


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
        $data['kode_servis'] = Str::upper(Str::random(8).'-'.date('Ymd'));

        $service = new Service;
        $service->user_id = Auth::user()->id;
        $service->customer_id = $data['customer_id'];
        $service->kode_servis = $data['kode_servis'];
        $service->jenis = $data['jenis'];
        $service->tipe = $data['tipe'];
        $service->kelengkapan = $data['kelengkapan'];
        $service->kerusakan = $data['kerusakan'];
        $service->penerima = $data['penerima'];
        $service->status = 1; // set to belum cek
        $service->save();

        alert()->success('Success Message', 'Sukses menambahkan data servis baru');
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
        dd($service);
        return view('pages.backsite.operational.service.index', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('pages.backsite.operational.service.index', compact('service'));
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
        // $service->status()->sync($request->input('status', []));

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
}
