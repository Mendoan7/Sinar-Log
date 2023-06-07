<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Notification;

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
        $teknisi = User::whereHas('detail_user', function ($query) {
            $query->where('type_user_id', 3);
        })->get();

        // Inisialisasi variabel total
        $total_service = [];
        $total_biaya_service = [];
        $total_modal_service = [];
        $total_profit_service = [];

        foreach ($teknisi as $user) {
            $teknisi_id = $user->id;
            $total_service[$teknisi_id] = 0;
            $total_biaya_service[$teknisi_id] = 0;
            $total_modal_service[$teknisi_id] = 0;
            $total_profit_service[$teknisi_id] = 0;
        }

        // Filter service berdasarkan rentang tanggal dan status selesai
        $services = Service::with('service_detail', 'service_detail.transaction')
            ->whereHas('service_detail', function ($query) use ($start_date, $end_date) {
                $query->whereHas('transaction');
            })
            ->where('status', 9)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        // Hitung total service, biaya, modal, dan profit per teknisi
        foreach ($services as $service) {
            $teknisi_id = $service->teknisi;
            $total_service[$teknisi_id]++;
            $total_biaya_service[$teknisi_id] += $service->service_detail->biaya;
            $total_modal_service[$teknisi_id] += $service->service_detail->modal;
            $total_profit_service[$teknisi_id] += ($service->service_detail->biaya - $service->service_detail->modal);
        }

        return view('pages.backsite.report.report-employees.index', compact('teknisi', 'total_service', 'total_biaya_service', 'total_modal_service', 'total_profit_service', 'start_date', 'end_date'));
    }

    // public function index(Request $request)
    // {
    //     // Ambil tanggal
    //     $start_date = $request->input('start_date') ? Carbon::createFromFormat('Y-m-d', $request->input('start_date')) : Carbon::now()->startOfMonth();
    //     $end_date = $request->input('end_date') ? Carbon::createFromFormat('Y-m-d', $request->input('end_date')) : Carbon::now();

    //     //Ambil data teknisi
    //     $all_teknisi = User::whereHas('detail_user', function ($query) {
    //         $query->where('type_user_id', 3);
    //     })->pluck('name');

    //     // Ambil semua tanggal pada rentang waktu yang diinputkan
    //     $dates = [];
    //     $current_date = $start_date->copy();
    //     while ($current_date->lte($end_date)) {
    //         $dates[] = $current_date->copy();
    //         $current_date->addDay();
    //     }

    //     // Inisialisasi variabel total
    //     $total_biaya_service = [];
    //     $total_modal_service = [];
    //     $total_profit_service = [];
    //     $total_all_service = [];
    //     $total_all_biaya_service = [];
    //     $total_all_modal_service = [];
    //     $total_all_profit_service = [];
    //     foreach ($all_teknisi as $teknisi) {
    //         $total_biaya_service[$teknisi] = 0;
    //         $total_modal_service[$teknisi] = 0;
    //         $total_profit_service[$teknisi] = 0;
    //         $total_all_service[$teknisi] = 0;
    //         $total_all_biaya_service[$teknisi] = 0;
    //         $total_all_modal_service[$teknisi] = 0;
    //         $total_all_profit_service[$teknisi] = 0;
    //     }

    //     // Hitung total servis per teknisi pada tiap tanggal
    //     $total_service = [];
    //     foreach ($dates as $date) {
    //         // Filter service berdasarkan teknisi dan status pada tanggal tertentu
    //         $services = Service::with('teknisi_detail', 'service_detail.transaction')
    //             ->whereHas('service_detail', function ($query) use ($request, $date) {
    //                 if ($request->has('teknisi') && $request->input('teknisi') != '') {
    //                     $query->where('teknisi', $request->input('teknisi'));
    //                 }
    //                 $query->whereHas('transaction', function ($query) use ($date) {
    //                     $query->whereDate('created_at', $date->format('Y-m-d'));
    //                 });
    //                 $query->where('kondisi', 1);
    //             })
    //             ->where('status', 9)
    //             ->get();

    //         // Hitung total servis per teknisi pada tanggal tertentu
    //         $total_service[$date->format('Y-m-d')] = [];
    //         foreach ($all_teknisi as $teknisi) {
    //             $total_service_teknisi = $services->where('teknisi_detail.name', $teknisi)->count();
    //             if ($total_service_teknisi > 0) {
    //                 $total_service[$date->format('Y-m-d')][$teknisi] = $total_service_teknisi;
    //             }
    //             // Tambahkan ke total all service per teknisi
    //             $total_all_service[$teknisi] += $total_service_teknisi;
    //         }

    //         // Hitung total biaya servis per teknisi pada tanggal tertentu
    //         foreach ($services as $service) {
    //             $teknisi = $service->teknisi_detail->name;
    //             $biaya_service = $service->service_detail->biaya;
    //             $modal_service = $service->service_detail->modal;
    //             $profit_service = $biaya_service - $modal_service;
    //             if (!isset($total_biaya_service[$teknisi])) {
    //                 $total_biaya_service[$teknisi] = 0;
    //             }
    //             $total_biaya_service[$teknisi] += $biaya_service;
    
    //             if (!isset($total_modal_service[$teknisi])) {
    //                 $total_modal_service[$teknisi] = 0;
    //             }
    //             $total_modal_service[$teknisi] += $modal_service;
    
    //             if (!isset($total_profit_service[$teknisi])) {
    //                 $total_profit_service[$teknisi] = 0;
    //             }
    //             $total_profit_service[$teknisi] += $profit_service;
    
    //             $total_all_biaya_service[$teknisi] += $biaya_service;
    //             $total_all_modal_service[$teknisi] += $modal_service;
    //             $total_all_profit_service[$teknisi] += $profit_service;
    //         }
    //     }

    //     return view('pages.backsite.report.report-employees.index', compact('all_teknisi', 'total_service', 'total_biaya_service', 'total_modal_service', 'total_profit_service', 'total_all_service', 'total_all_biaya_service', 'total_all_modal_service', 'total_all_profit_service', 'start_date', 'end_date', 'dates'));
    // }

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

    public function show(Request $request, $teknisiId)
    {
        // Ambil tanggal
        $start_date = $request->input('start_date') ? Carbon::createFromFormat('Y-m-d', $request->input('start_date'))->startOfDay() : Carbon::now()->startOfMonth();
        $end_date = $request->input('end_date') ? Carbon::createFromFormat('Y-m-d', $request->input('end_date'))->endOfDay() : Carbon::now()->endOfDay();

        // Ambil data teknisi
        $teknisi = User::findOrFail($teknisiId);

        // Ambil laporan teknisi
        $laporanTeknisi = Service::with('service_detail')
            ->where('teknisi', $teknisiId)
            ->whereHas('service_detail', function ($query) {
                $query->whereHas('transaction');
            })
            ->where('status', 9)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get()
            ->groupBy(function ($item) {
                return $item->service_detail->transaction->created_at->format('Y-m-d');
            })
            ->map(function ($group) {
                $totalService = $group->count();
                $totalBiaya = $group->sum(function ($item) {
                    return $item->service_detail->biaya;
                });
                $totalModal = $group->sum(function ($item) {
                    return $item->service_detail->modal;
                });
                $totalProfit = $group->sum(function ($item) {
                    return $item->service_detail->biaya - $item->service_detail->modal;
                });

                return [
                    'totalService' => $totalService,
                    'totalBiaya' => $totalBiaya,
                    'totalModal' => $totalModal,
                    'totalProfit' => $totalProfit,
                ];
            });
        
        // Hitung total dari rentang tanggal
        $totalService = $laporanTeknisi->sum('totalService');
        $totalBiaya = $laporanTeknisi->sum('totalBiaya');
        $totalModal = $laporanTeknisi->sum('totalModal');
        $totalProfit = $laporanTeknisi->sum('totalProfit');

        return view('pages.backsite.report.report-employees.show', compact('teknisi', 'laporanTeknisi', 'start_date', 'end_date', 'totalService', 'totalBiaya', 'totalModal', 'totalProfit'));
    }

    // public function show(Request $request, $teknisiId)
    // {
    //     // Ambil tanggal
    //     $start_date = $request->input('start_date') ? Carbon::createFromFormat('Y-m-d', $request->input('start_date')) : Carbon::now()->startOfMonth();
    //     $end_date = $request->input('end_date') ? Carbon::createFromFormat('Y-m-d', $request->input('end_date')) : Carbon::now();
    
    //     // Ambil data teknisi berdasarkan ID
    //     $teknisi = User::findOrFail($teknisiId);

    //      // Inisialisasi variabel total
    //     $report = [];

    //     // Ambil laporan teknisi berdasarkan rentang tanggal
    //     $services = Service::with('service_detail', 'service_detail.transaction')
    //         ->where('teknisi', $teknisiId)
    //         ->whereHas('service_detail', function ($query) {
    //             $query->whereHas('transaction')
    //                 ->where('kondisi', 1);
    //         })
    //         ->where('status', 9)
    //         ->whereBetween('created_at', [$start_date, $end_date])
    //         ->get();
        
    //     // Hitung total service, biaya, modal, dan profit per tanggal
    //     foreach ($services as $service) {
    //         $tanggal = $service->created_at->format('Y-m-d');
    //         if (!isset($report[$tanggal])) {
    //             $report[$tanggal] = [
    //                 'totalService' => 0,
    //                 'totalBiaya' => 0,
    //                 'totalModal' => 0,
    //                 'totalProfit' => 0
    //             ];
    //         }
    //         $report[$tanggal]['totalService']++;
    //         $report[$tanggal]['totalBiaya'] += $service->service_detail->biaya;
    //         $report[$tanggal]['totalModal'] += $service->service_detail->modal;
    //         $report[$tanggal]['totalProfit'] += ($service->service_detail->biaya - $service->service_detail->modal);
    //     }

    //     return view('pages.backsite.report.report-employees.show', compact('teknisi', 'report', 'start_date', 'end_date'));
    // }

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

    // custom
    public function detailReport($teknisiId, $tanggal)
    {
        $teknisi = User::findOrFail($teknisiId);

        // Ambil data servis
        $dataService = Service::with('service_detail.transaction')
            ->where('teknisi', $teknisiId)
            ->whereHas('service_detail', function ($query) {
                $query->whereHas('transaction');
            })
            ->where('status', 9)
            ->whereHas('service_detail.transaction', function ($query) use ($tanggal) {
                $query->whereDate('created_at', $tanggal);
            })
            ->get();

        return view('pages.backsite.report.report-employees.detail', compact('teknisi', 'dataService', 'tanggal'));
    }
}
