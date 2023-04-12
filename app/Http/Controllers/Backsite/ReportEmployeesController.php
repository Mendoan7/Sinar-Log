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

class ReportEmployeesController extends Controller
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
        // Ambil tanggal
        $start_date = $request->input('start_date') ? Carbon::createFromFormat('Y-m-d', $request->input('start_date')) : Carbon::now()->startOfMonth();
        $end_date = $request->input('end_date') ? Carbon::createFromFormat('Y-m-d', $request->input('end_date')) : Carbon::now();

        // Ambil data teknisi
        $all_teknisi = ServiceDetail::groupBy('teknisi')->pluck('teknisi');

        // Ambil semua tanggal pada rentang waktu yang diinputkan
        $dates = [];
        $current_date = $start_date->copy();
        while ($current_date->lte($end_date)) {
            $dates[] = $current_date->copy();
            $current_date->addDay();
        }

        // Inisialisasi variabel total
        $total_biaya_service = [];
        $total_modal_service = [];
        $total_profit_service = [];
        $total_all_service = [];
        $total_all_biaya_service = [];
        $total_all_modal_service = [];
        $total_all_profit_service = [];
            foreach ($all_teknisi as $teknisi) {
                $total_biaya_service[$teknisi] = 0;
                $total_modal_service[$teknisi] = 0;
                $total_profit_service[$teknisi] = 0;
                $total_all_service[$teknisi] = 0;
                $total_all_biaya_service[$teknisi] = 0;
                $total_all_modal_service[$teknisi] = 0;
                $total_all_profit_service[$teknisi] = 0;
            }

        // Hitung total servis per teknisi pada tiap tanggal
        $total_service = [];
        foreach ($dates as $date) {
            // Filter service berdasarkan teknisi dan status pada tanggal tertentu
            $services = Service::whereHas('service_detail', function ($query) use ($request, $date) {
                    if ($request->has('teknisi') && $request->input('teknisi') != '') {
                        $query->where('teknisi', $request->input('teknisi'));
                    }
                    $query->whereDate('created_at', $date->format('Y-m-d'));
                })
                ->where('status', 8)
                ->get();

            // Hitung total servis per teknisi pada tanggal tertentu
            $total_service[$date->format('Y-m-d')] = [];
            foreach ($all_teknisi as $teknisi) {
                $total_service_teknisi = $services->where('service_detail.teknisi', $teknisi)->count();
                if ($total_service_teknisi > 0) {
                    $total_service[$date->format('Y-m-d')][$teknisi] = $total_service_teknisi;
                }
                // Tambahkan ke total all service per teknisi
                $total_all_service[$teknisi] += $total_service_teknisi;
            }


            // Hitung total biaya servis per teknisi pada tanggal tertentu
            foreach ($services as $service) {
                $teknisi = $service->service_detail->teknisi;
                $biaya_service = $service->service_detail->biaya;
                $modal_service = $service->service_detail->modal;
                $profit_service = $biaya_service - $modal_service;
                if (!isset($total_biaya_service[$date->format('Y-m-d')][$teknisi])) {
                    $total_biaya_service[$date->format('Y-m-d')][$teknisi] = 0;
                }
                $total_biaya_service[$date->format('Y-m-d')][$teknisi] += $biaya_service;

                if (!isset($total_modal_service[$date->format('Y-m-d')][$teknisi])) {
                    $total_modal_service[$date->format('Y-m-d')][$teknisi] = 0;
                }
                $total_modal_service[$date->format('Y-m-d')][$teknisi] += $modal_service;

                if (!isset($total_profit_service[$date->format('Y-m-d')][$teknisi])) {
                    $total_profit_service[$date->format('Y-m-d')][$teknisi] = 0;
                }
                $total_profit_service[$date->format('Y-m-d')][$teknisi] += $profit_service;

                $total_all_biaya_service[$teknisi] += $biaya_service;
                $total_all_modal_service[$teknisi] += $modal_service;
                $total_all_profit_service[$teknisi] += $profit_service;
            }
        }

        return view('pages.backsite.report.report-employees.index', compact('all_teknisi', 'total_service', 'total_biaya_service', 'total_modal_service', 'total_profit_service', 'total_all_service', 'total_all_biaya_service', 'total_all_modal_service', 'total_all_profit_service', 'start_date', 'end_date', 'dates'));
    }
    

    // public function index(Request $request)
    // {
    //     // Ambil tanggal
    //     $start_date = $request->input('start_date') ? Carbon::createFromFormat('Y-m-d', $request->input('start_date')) : Carbon::now()->startOfMonth();
    //     $end_date = $request->input('end_date') ? Carbon::createFromFormat('Y-m-d', $request->input('end_date')) : Carbon::now()->endOfMonth();

    //     // Ambil data teknisi
    //     $all_teknisi = ServiceDetail::groupBy('teknisi')->pluck('teknisi');

    //     // Filter service berdasarkan teknisi dan status
    //     $services = Service::whereHas('service_detail', function ($query) use ($request) {
    //             if ($request->has('teknisi') && $request->input('teknisi') != '') {
    //                 $query->where('teknisi', $request->input('teknisi'));
    //             }
    //         })
    //         ->where('status', 8)
    //         ->whereBetween('updated_at', [$start_date, $end_date])
    //         ->get();

    //     $dates = [];
    //     $date = $start_date;
    //     while ($date <= $end_date) {
    //         $dates[] = $date->format('Y-m-d');
    //         $date->addDay();
    //     }

    //     return view('pages.backsite.report.report-employees.index', compact('all_teknisi', 'services', 'start_date', 'end_date'));
    // }

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
