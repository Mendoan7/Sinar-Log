<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;

// use library here
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// request
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;

// use everything here
use Gate;
use Auth;

use App\Models\Operational\Customer;
use App\Models\Operational\Service;


class CustomerController extends Controller
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
        // for table grid
        $customer = Customer::with(['service.service_detail.transaction.warranty_history'])
        ->orderBy('created_at', 'desc')
        ->get();
        
        // menghitung servis selesai
        $customer->each(function ($customer_item) {
            $service_selesai = $customer_item->service->filter(function ($service) {
                return $service->status === 9 && (
                    $service->service_detail->transaction->warranty_history->isEmpty() ||
                    $service->service_detail->transaction->warranty_history->where('status', 3)->isNotEmpty()
                );
            })->count();
    
            $customer_item->service_selesai = $service_selesai;
        });

        return view('pages.backsite.operational.customer.index', compact('customer'));
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
    public function store(StoreCustomerRequest $request)
    {
        // get all request from frontsite
        $data = $request->all();
        $data['contact'] = str_replace('0', '62', $data['contact']);

        // store to database
        $customer = Customer::create($data);

        alert()->success('Success Message', 'Sukses menambahkan pelanggan baru');
        return redirect()->route('backsite.customer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('pages.backsite.operational.customer.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('pages.backsite.operational.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        // get all request
        $data = $request->all();

        // update to database
        $customer->update($data);

        alert()->success('Success Message', 'Berhasil update data pelanggan');
        return redirect()->route('backsite.customer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->forceDelete();

        alert()->success('Success Message', 'Berhasil menghapus data pelanggan');
        return back();
    }
}
