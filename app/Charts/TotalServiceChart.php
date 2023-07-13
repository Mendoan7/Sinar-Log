<?php

namespace App\Charts;

use App\Models\Operational\Service;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class TotalServiceChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\HorizontalBar
    {
        // Mendapatkan data total servis masuk, selesai, dan keluar per bulan pada tahun saat ini
        $data = Service::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereIn('status', [8, 9]) // Hanya menghitung servis selesai dan keluar
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Mendapatkan nama bulan untuk sumbu X
        $months = array_keys($data);
        $monthNames = [];
        foreach ($months as $month) {
            $monthNames[] = Carbon::create()->month($month)->format('F');
        }

        return $this->chart->horizontalBarChart()
            ->setTitle('Total Service')
            ->setSubtitle('Total servis masuk, selesai, dan keluar per bulan')
            ->addData('Servis Masuk', array_values($data))
            ->setXAxis($monthNames);
    }
}
