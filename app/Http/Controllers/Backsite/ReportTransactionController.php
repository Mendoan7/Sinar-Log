<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use App\Models\Operational\Service;

// use model here
use App\Models\Operational\ServiceDetail;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportTransactionController extends Controller
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
        $total_modal_all = 0;
        $total_profit = 0;
        $report = [];

        $user = Auth::user();
        $isTeknisi = $user->detail_user->type_user_id == 3;

        // Ambil data berdasarkan created_at
        foreach ($dates as $date) {
            $serviceQuery = Service::whereDate('created_at', $date);
            $service_detailQuery = ServiceDetail::whereHas('service', function ($query) use ($date) {
                $query->whereDate('date_done', $date);
            });
            $transactionQuery = Service::whereDate('date_out', $date);

            if ($isTeknisi) {
                $teknisiId = $user->id;
                $serviceQuery->where('teknisi', $teknisiId);
                $service_detailQuery->whereHas('service', function ($query) use ($teknisiId) {
                    $query->where('teknisi', $teknisiId);
                });
                $transactionQuery->where('teknisi', $teknisiId);
            }

            $service = $serviceQuery->count();
            $service_detail = $service_detailQuery->count();
            $transaction = $transactionQuery->count();

            $total_income = $service_detailQuery->whereHas('service', function ($query) {
                $query->where('status', 9);
            })->sum('biaya');

            $service_detail_records = $service_detailQuery->whereHas('service', function ($query) {
                $query->where('status', 9);
            })->get();

            $total_modal = 0;

            foreach ($service_detail_records as $service_detail_record) {
                $modal = json_decode($service_detail_record->modal, true);

                if (is_array($modal)) {
                    $total_modal += array_sum($modal);
                }
            }

            $profit = $total_income - $total_modal;

            // Menambahkan kondisi untuk hanya menampilkan data yang ada pada tanggal tersebut
            if ($service > 0 || $service_detail > 0 || $transaction > 0) {
                $report[$date->format('Y-m-d')] = [
                    'date' => $date,
                    'service' => $service,
                    'service_detail' => $service_detail,
                    'transaction' => $transaction,
                    'income' => $total_income,
                    'modal' => $total_modal,
                    'profit' => $profit,
                ];

                $total_service += $service;
                $total_success += $service_detail;
                $total_out += $transaction;
                $total_revenue += $total_income;
                $total_modal_all += $total_modal;
                $total_profit += $profit;
            }

        }
        // ChartData
        $chartData = $this->generateChartData($isTeknisi, $user);

        return view('pages.backsite.report.report-transaction.index', compact('report', 'start_date', 'end_date', 'total_service',
            'total_success', 'total_out', 'total_revenue', 'total_modal_all', 'total_profit', 'chartData'));
    }

    private function generateChartData($isTeknisi, $user)
    {
        // Mendapatkan tanggal saat ini
        $currentDate = Carbon::now();
        $currentYear = $currentDate->year;

        // Inisialisasi array untuk menyimpan data grafik
        $chartData = [
            'months' => [],
            'totalMasuk' => [],
            'totalSelesai' => [],
            'totalKeluar' => [],
        ];

        // Looping untuk setiap bulan dari awal tahun hingga bulan saat ini
        for ($month = 1; $month <= 12; $month++) {
            // Mendapatkan nama bulan (e.g., January, February)
            $monthName = Carbon::createFromDate($currentYear, $month, 1)->format('F Y');

            // Mendapatkan tanggal awal dan akhir bulan
            $startDate = Carbon::createFromDate($currentYear, $month, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($currentYear, $month, 1)->endOfMonth();

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
    //     // Ambil tanggal
    //     $start_date = $request->input('start_date') ? Carbon::createFromFormat('Y-m-d', $request->input('start_date')) : Carbon::now()->startOfMonth();
    //     $end_date = $request->input('end_date') ? Carbon::createFromFormat('Y-m-d', $request->input('end_date')) : Carbon::now();

    //     $dates = [];
    //     $date = $start_date->copy();
    //     while ($date->lte($end_date)) {
    //         $dates[] = $date->copy();
    //         $date->addDay();
    //     }

    //     $total_service = 0;
    //     $total_success = 0;
    //     $total_out = 0;
    //     $total_revenue = 0;
    //     $total_modal = 0;
    //     $total_profit = 0;
    //     $report = [];

    //     // Dapatkan tipe pengguna saat ini
    //     $userType = auth()->user()->detail_user->type_user_id;

    //     // Ambil data berdasarkan created_at
    //     foreach ($dates as $date) {
    //         $service_detail = ServiceDetail::whereDate('created_at', $date);

    //         // Jika tipe pengguna adalah 3 (teknisi), tambahkan filter berdasarkan teknisi yang terkait
    //         if ($userType == 3) {
    //             $service_detail->where('teknisi', $userType->id);
    //         }

    //         $service_detail = $service_detail->get();
    //         $transaction = Transaction::whereDate('created_at', $date)->get();
    //         $service = Service::selectRaw('COUNT(id) as count')
    //             ->whereDate('created_at', $date)
    //             ->whereIn('status', [1, 8, 9])
    //             ->first();

    //         if ($transaction->isNotEmpty()) {

    //             // Hitung total biaya untuk setiap service yang berhasil dilakukan pada hari ini
    //             $total_income = 0;
    //             foreach ($transaction as $data) {
    //                 if ($data->service_detail->service->status == 9) {
    //                     $total_income += $data->service_detail->biaya;
    //                 }
    //             }

    //             $modal = 0;
    //             foreach ($transaction as $data) {
    //                 if ($data->service_detail->service->status == 9) {
    //                     $modal += $data->service_detail->modal;
    //                 }
    //             }

    //             // Menghitung profit
    //             $profit = $total_income - $modal;

    //             $report[$date->format('Y-m-d')] = [
    //                 'date' => $date,
    //                 'service_detail' => $service_detail->count(),
    //                 'transaction' => $transaction->count(),
    //                 'service' => $service->count,
    //                 'income' => $total_income,
    //                 'modal' => $modal,
    //                 'profit' => $profit,
    //             ];

    //             // Mendapatkan total
    //             $total_service += $service->count;
    //             $total_success += $service_detail->count();
    //             $total_out += $transaction->count();
    //             $total_revenue += $total_income;
    //             $total_modal += $modal;
    //             $total_profit += $profit;
    //         }
    //     }

    //     return view('pages.backsite.report.report-transaction.index', compact('report', 'start_date', 'end_date', 'total_service',
    //         'total_success', 'total_out', 'total_revenue', 'total_modal', 'total_profit'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $start_date = $request->input('start_date') ? Carbon::createFromFormat('Y-m-d', $request->input('start_date')) : Carbon::now()->startOfMonth();
        $end_date = $request->input('end_date') ? Carbon::createFromFormat('Y-m-d', $request->input('end_date')) : Carbon::now();

        $date = $start_date->copy();
        while ($date->lte($end_date)) {
            $dates[] = $date->copy();
            $date->addDay();
        }

        // Mendapatkan total service masuk
        $totalMasuk = Service::whereBetween('created_at', $date)->count();

        $totalSelesai = Service::whereBetween('date_done', $date)->where('status', 8)->count();

        $totalKeluar = Service::whereBetween('date_out', $date)->where('status', 9)->count();
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
