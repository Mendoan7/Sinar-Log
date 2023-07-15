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

        // Validasi jika tanggal sama
        if ($start_date->isSameDay($end_date)) {
            $end_date->endOfDay(); // Atur end_date menjadi akhir hari
        }

        // Ambil data teknisi
        $teknisi = User::query();
        if (Auth::user()->detail_user->type_user_id == 3) {
            $teknisi->where('id', Auth::user()->id); // Jika tipe pengguna adalah 3 (teknisi), menampilkan hanya teknisi itu sendiri
        } else {
            $teknisi->whereHas('detail_user', function ($query) {
                $query->where('type_user_id', 3);
            }); // Jika tipe pengguna bukan 3, tampilkan semua teknisi
        }
        $teknisi = $teknisi->get();

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

        $services = Service::with(['service_detail.transaction'])
            ->whereHas('service_detail', function ($query) use ($start_date, $end_date) {
                $query->whereHas('transaction', function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                });
            })
            ->where('status', 9)
            ->get();

        // Hitung total service, biaya, modal, dan profit per teknisi
        foreach ($services as $service) {
            $teknisi_id = $service->teknisi;
            if (isset($total_service[$teknisi_id])) {
                $total_service[$teknisi_id]++;
                $total_biaya_service[$teknisi_id] += $service->service_detail->biaya;
                $total_modal_service[$teknisi_id] += $service->service_detail->modal;
                $total_profit_service[$teknisi_id] += ($service->service_detail->biaya - $service->service_detail->modal);
            }
        }

        // Menghitung total keseluruhan
        $total_servis_selesai = array_sum($total_service);
        $total_pemasukan = array_sum($total_biaya_service);
        $total_modal = array_sum($total_modal_service);
        $total_profit = array_sum($total_profit_service);

        return view('pages.backsite.report.report-employees.index', compact('teknisi', 'total_service', 'total_biaya_service', 'total_modal_service', 'total_profit_service', 'start_date', 'end_date', 'total_servis_selesai', 'total_pemasukan', 'total_modal', 'total_profit'));
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

    public function show(Request $request, $teknisiId)
    {
        $start_date = $request->query('start_date') ? Carbon::createFromFormat('Y-m-d', $request->input('start_date')) : Carbon::now()->startOfMonth();
        $end_date = $request->query('end_date') ? Carbon::createFromFormat('Y-m-d', $request->input('end_date')) : Carbon::now();
        
        // Ambil data teknisi
        $teknisi = User::findOrFail($teknisiId);

        // Ambil laporan teknisi
        $laporanTeknisi = Service::with(['service_detail.transaction'])
            ->where('teknisi', $teknisiId)
            ->whereHas('service_detail', function ($query) use ($start_date, $end_date) {
                $query->whereHas('transaction', function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                });
            })
            ->where('status', 9)
            ->orderBy('created_at', 'asc')
            ->get()
            ->sortBy('service_detail.transaction.created_at')
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
