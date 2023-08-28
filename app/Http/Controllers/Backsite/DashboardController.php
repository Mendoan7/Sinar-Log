<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use App\Models\Operational\Service;
use App\Models\Operational\ServiceDetail;
use App\Models\Operational\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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
        $startDate = $request->input('start_date') ? Carbon::createFromFormat('Y-m-d', $request->input('start_date'))->startOfDay() : Carbon::today()->startOfDay();
        $endDate = $request->input('end_date') ? Carbon::createFromFormat('Y-m-d', $request->input('end_date'))->endOfDay() : Carbon::today()->endOfDay();

        $user = Auth::user();
        $isTeknisi = $user->detail_user->type_user_id == 3;

        $total_queue = 0;
        $total_in_progress = 0;
        $total_success_teknisi = 0;
        $total_out_teknisi = 0;
        $total_revenue_teknisi = 0;
        $queue_date = collect([]);
        $progress_date = collect([]);

        if ($isTeknisi) {
            $total_queue = Service::where('teknisi', $user->id)
                ->where('status', 2)->count();

            $total_in_progress = Service::where('teknisi', $user->id)
                ->whereIn('status', [3, 4, 5, 6, 7, 10, 11])->count();
            
            $total_success_teknisi = Service::where('teknisi', $user->id)
                ->whereBetween('date_done', [$startDate, $endDate])->count();

            $total_out_teknisi = Service::where('teknisi', $user->id)
                ->whereBetween('date_out', [$startDate, $endDate])->count();

            $revenue_teknisi = Service::whereHas('service_detail', function ($query) use ($user) {
                $query->where('status', 9)->where('teknisi', $user->id);
            })->whereBetween('date_out', [$startDate, $endDate]);
            
            $income_teknisi = $revenue_teknisi->get();
            $total_revenue_teknisi = $income_teknisi->sum('service_detail.biaya');

            // Ambil tanggal update untuk service antrian
            $queue_date = Service::where('teknisi', $user->id)->where('status', 2)->pluck('updated_at');

            // Ambil tanggal update untuk service proses
            $progress_date = Service::where('teknisi', $user->id)->whereIn('status', [3, 4, 5, 6, 7, 10, 11])->pluck('updated_at');
        }

        $total_service = Service::whereBetween('created_at', [$startDate, $endDate])->count();

        $total_success = Service::whereBetween('date_done', [$startDate, $endDate])->count();

        $total_out = Service::whereBetween('date_out', [$startDate, $endDate])->count();

        $revenue = Service::whereBetween('date_out', [$startDate, $endDate])
            ->where('status', 9);
            
        $income = $revenue->get();
        $total_revenue = $income->sum('service_detail.biaya');

        // ChartData
        $chartData = $this->generateChartData($isTeknisi, $user);

        // LatestTransaction
        $latest_servicesQuery = $isTeknisi ? Service::where('teknisi', $user->id) : Service::query();
        $latest_services = $latest_servicesQuery->orderBy('updated_at', 'desc')->take(5)->get();

        return view('pages.backsite.dashboard.index', compact('startDate', 'endDate', 'total_service', 'total_success', 'total_out', 'total_revenue', 'total_queue', 'total_in_progress', 'total_success_teknisi', 'total_out_teknisi', 'total_revenue_teknisi', 'queue_date', 'progress_date', 'latest_services', 'chartData'));
    }

    private function generateChartData($isTeknisi, $user)
    {
        // Mendapatkan tanggal saat ini
        $currentDate = Carbon::now();

        // Inisialisasi array untuk menyimpan data grafik
        $chartData = [
            'months' => [],
            'totalMasuk' => [],
            'totalSelesai' => [],
            'totalKeluar' => [],
        ];

        // Looping untuk setiap bulan dari awal tahun hingga bulan saat ini
        for ($date = Carbon::now()->startOfYear(); $date <= $currentDate; $date->addMonth()) {
            // Mendapatkan nama bulan (e.g., January, February)
            $monthName = $date->format('F Y');

            $startDate = $date->copy()->startOfMonth();
            $endDate = $date->copy()->endOfMonth();

            // Mendapatkan total service masuk
            $totalMasuk = Service::whereBetween('created_at', [$startDate, $endDate])->count();

            // Mendapatkan total service selesai
            $totalSelesai = Service::whereBetween('date_done', [$startDate, $endDate])->count();

            // Mendapatkan total service keluar
            $totalKeluar = Service::whereBetween('date_out', [$startDate, $endDate])->where('status', 9)->count();

            // Jika user teknisi
            if ($isTeknisi) {
                $totalMasuk = Service::where('teknisi', $user->id)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count();

                $totalSelesai = Service::whereBetween('date_done', [$startDate, $endDate])
                    ->where('teknisi', $user->id)->count();

                $totalKeluar = Service::whereBetween('date_out', [$startDate, $endDate])
                    ->where('status', 9)->where('teknisi', $user->id)->count();
            }

            // Memasukkan data ke dalam array grafik
            $chartData['months'][] = $monthName;
            $chartData['totalMasuk'][] = $totalMasuk;
            $chartData['totalSelesai'][] = $totalSelesai;
            $chartData['totalKeluar'][] = $totalKeluar;
        }

        return $chartData;
    }

    // public function index(Request $request)
    // {
    //     // Mendapatkan tanggal saat ini
    //     $currentDate = Carbon::now();

    //     // Inisialisasi array untuk menyimpan data grafik
    //     $chartData = [
    //         'months' => [],
    //         'totalMasuk' => [],
    //         'totalSelesai' => [],
    //         'totalKeluar' => [],
    //     ];

    //     // Looping untuk setiap bulan dari awal tahun hingga bulan saat ini
    //     for ($date = Carbon::now()->startOfYear(); $date <= $currentDate; $date->addMonth()) {
    //         // Mendapatkan nama bulan (e.g., January, February)
    //         $monthName = $date->format('F');

    //         // Mendapatkan tanggal awal bulan
    //         $startDate = $date->copy()->startOfMonth();

    //         // Mendapatkan tanggal akhir bulan
    //         $endDate = $date->copy()->endOfMonth();

    //         // Mendapatkan total service masuk
    //         $totalMasuk = Service::whereBetween('created_at', [$startDate, $endDate])->count();

    //         // Mendapatkan total service selesai
    //         $totalSelesai = Service::whereHas('service_detail', function ($query) use ($startDate, $endDate) {
    //             $query->whereBetween('created_at', [$startDate, $endDate]);
    //         })->count();

    //         // Mendapatkan total service keluar
    //         $totalKeluar = Service::whereHas('service_detail.transaction', function ($query) use ($startDate, $endDate) {
    //             $query->whereBetween('created_at', [$startDate, $endDate]);
    //         })->where('status', 9)->count();

    //         // Memasukkan data ke dalam array grafik
    //         $chartData['months'][] = $monthName;
    //         $chartData['totalMasuk'][] = $totalMasuk;
    //         $chartData['totalSelesai'][] = $totalSelesai;
    //         $chartData['totalKeluar'][] = $totalKeluar;
    //     }

    //     // Column Information
    //     $date = $request->input('date');
    //     $selectedDate = $date ? Carbon::createFromFormat('d M, Y', $date) : Carbon::today();

    //     $user = Auth::user();
    //     $isTeknisi = $user->detail_user->type_user_id == 3;

    //     $service_detailQuery = ServiceDetail::whereDate('created_at', $selectedDate);
    //     $transactionQuery = Transaction::whereDate('created_at', $selectedDate);
    //     $serviceQuery = Service::selectRaw('COUNT(id) as count')->whereDate('created_at', $selectedDate);

    //     $service_detail = $service_detailQuery->get();
    //     $transaction = $transactionQuery->get();
    //     $service = $serviceQuery->first();

    //     $totalNotChecked = 0;
    //     $totalProcess = 0;
    //     $totalDone = 0;
    //     $totalRevenueTechnician = 0;

    //     if ($isTeknisi) {
    //         $teknisiId = $user->id;
    //         $totalNotChecked = Service::where('teknisi', $teknisiId)->where('status', 2)->count();

    //         $totalProcess = Service::where('teknisi', $teknisiId)->whereIn('status', [3, 4, 5, 6, 7, 10, 11])->count();

    //         $totalDone = Service::where('teknisi', $teknisiId)
    //             ->whereHas('service_detail', function ($query) use ($selectedDate) {
    //                 $query->whereDate('created_at', $selectedDate);
    //             })->count();

    //         $serviceRevenue = Transaction::whereHas('service_detail.service', function ($query) use ($teknisiId, $selectedDate) {
    //             $query->where('teknisi', $teknisiId)
    //                 ->where('status', 9)
    //                 ->whereDate('created_at', $selectedDate);
    //         });

    //         $totalRevenue = $serviceRevenue->get();
    //         $totalRevenueTechnician = $totalRevenue->sum('service_detail.biaya');
    //     }

    //     $total_service = 0;
    //     $total_success = 0;
    //     $total_out = 0;
    //     $total_revenue = 0;

    //     if ($transaction->isNotEmpty()) {
    //         // Hitung total biaya untuk setiap service yang berhasil dilakukan pada hari ini
    //         $total_income = $transaction->where('service_detail.service.status', 9)->sum('service_detail.biaya');
    //         // Mendapatkan total
    //         $total_service += $service->count;
    //         $total_success += $service_detail->count();
    //         $total_out += $transaction->count();
    //         $total_revenue += $total_income;
    //     }

    //     // LatestTransaction
    //     $latest_servicesQuery = $isTeknisi ? Service::where('teknisi', $user->id) : Service::query();
    //     $latest_services = $latest_servicesQuery->orderBy('updated_at', 'desc')->take(5)->get();

    //     return view('pages.backsite.dashboard.index', compact('total_service', 'total_success', 'total_out', 'total_revenue', 'totalNotChecked', 'totalProcess', 'totalDone', 'totalRevenueTechnician', 'latest_services', 'chartData'));
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
}
