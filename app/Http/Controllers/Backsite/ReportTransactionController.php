<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

// use model here
use App\Models\User;
use App\Models\Operational\Customer;
use App\Models\Operational\Service;
use App\Models\Operational\ServiceDetail;
use App\Models\Operational\Transaction;

class ReportTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

            // // Tambahkan kondisi untuk menampilkan laporan periode bulan saat ini
            // if (!$request->input('start_date') && !$request->input('end_date')) {
            //     $start_date = Carbon::now()->startOfMonth();
            //     $end_date = Carbon::now()->endOfMonth();
            // }

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        // Ambil tanggal
        $start_date = $request->input('start_date') ? Carbon::createFromFormat('Y-m-d', $request->input('start_date')) : Carbon::now()->startOfMonth();
        $end_date = $request->input('end_date') ? Carbon::createFromFormat('Y-m-d', $request->input('end_date')) : Carbon::now();

        $dates = [];
        $date = $start_date->copy();
        while ($date->lte($end_date)) {
            $dates[] = $date->copy();
            $date->addDay();
        }

        $total_service = 0;
        $total_success = 0;
        $total_out = 0;
        $total_revenue = 0;
        $total_modal = 0;
        $total_profit = 0;

        // Ambil data berdasarkan created_at
        foreach ($dates as $date) {
            $service_detail = ServiceDetail::whereDate('created_at', $date)->get();
            $transaction = Transaction::whereDate('created_at', $date)->get();
            $service = Service::selectRaw('COUNT(id) as count')
                ->whereDate('created_at', $date)
                ->whereIn('status', [1, 7, 8])
                ->first();

                // Hitung total biaya untuk setiap service yang berhasil dilakukan pada hari ini
                $total_income = 0;
                foreach ($transaction as $data) {
                    if ($data->service_detail->service->status == 8) {
                        $total_income += $data->service_detail->biaya;
                    }
                }

                $modal = 0;
                foreach ($transaction as $data) {
                    if ($data->service_detail->service->status == 8) {
                        $modal += $data->service_detail->modal;
                    }
                }

                // Menghitung profit
                $profit = $total_income - $modal;

            $report[$date->format('Y-m-d')] = [
                'date' => $date,
                'service_detail' => $service_detail->count(),
                'transaction' => $transaction->count(),
                'service' => $service->count,
                'income' => $total_income,
                'modal' => $modal,
                'profit' => $profit,
            ];

            // Mendapatkan total
            $total_service += $service->count;
            $total_success += $service_detail->count();
            $total_out += $transaction->count();
            $total_revenue += $total_income;
            $total_modal += $modal;
            $total_profit += $profit;
        }

        return view('pages.backsite.report.report-transaction.index', compact('report', 'start_date', 'end_date', 'total_service', 
            'total_success', 'total_out', 'total_revenue', 'total_modal', 'total_profit'));
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
        //
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
