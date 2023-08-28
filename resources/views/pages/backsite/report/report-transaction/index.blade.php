@extends('layouts.app')

@section('title', 'Laporan Servis')

@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 card-title flex-grow-1">Laporan Servis</h5>
                                    <div class="flex-shrink-0">
                                        <a class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#chartServiceModal">
                                            <i class="bx bx-line-chart"></i>
                                            Chart
                                        </a>
                                        <div class="modal fade bs-example-modal-xl" id="chartServiceModal" tabindex="-1"
                                            aria-hidden="true" aria-labelledby="chartServiceModalLabel">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <h5 class="mb-4 text-center">Chart Laporan Servis 
                                                            @if(Auth::user()->detail_user->type_user_id == 3)
                                                                <strong>{{ Auth::user()->name }}</strong>
                                                            @else
                                                                <strong>Sinar Cell</strong>
                                                            @endif
                                                            Tahun {{ Carbon\Carbon::now()->format('Y') }}
                                                        </h5>
                                                        
                                                        <div id="service_chart"
                                                            data-colors='["--bs-primary","--bs-warning", "--bs-success"]'
                                                            class="apex-charts" dir="ltr">
                                                        </div>
                                                        <div class="d-flex flex-wrap gap-2 mt-4 justify-content-center">
                                                            <button class="btn btn-light btn-block" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Total Barang Servis Masuk Tahun {{ Carbon\Carbon::now()->format('Y') }}">
                                                                Total Servis Masuk :
                                                                {{ array_sum($chartData['totalMasuk']) }}
                                                            </button>
                                                            <button class="btn btn-light btn-block" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Total Barang Servis Selesai Ditangani Tahun {{ Carbon\Carbon::now()->format('Y') }}">
                                                                Total Servis Selesai Ditangani :
                                                                {{ array_sum($chartData['totalSelesai']) }}
                                                            </button>
                                                            <button class="btn btn-light btn-block" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Total Barang Servis Keluar Tahun {{ Carbon\Carbon::now()->format('Y') }}">
                                                                Total Servis Keluar :
                                                                {{ array_sum($chartData['totalKeluar']) }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body border-bottom">
                                <form method="GET" action="{{ route('backsite.report-transaction.index') }}">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="row g-3">
                                                <div class="col-xxl-6 col-lg-8 align-self-center">
                                                    <p class="mb-0 card-title">Periode :
                                                        {{ $start_date->isoFormat('D MMMM Y') }} -
                                                        {{ $end_date->isoFormat('D MMMM Y') }}</p>
                                                </div>
                                                <div class="col-xxl-4 col-lg-6">
                                                    <div class="input-daterange input-group" id="datepicker"
                                                        data-date-format="yyyy-mm-dd" data-date-autoclose="true"
                                                        data-provide="datepicker" data-date-container='#datepicker'>
                                                        <input type="text" class="form-control" id="start_date"
                                                            name="start_date" placeholder="Tanggal Mulai" />
                                                        <input type="text" class="form-control" id="end_date"
                                                            name="end_date" placeholder="Tanggal Akhir" />
                                                    </div>
                                                </div>
                                                <div class="col-xxl-2 col-lg-4">
                                                    <button type="submit" class="btn btn-soft-success w-100"><i
                                                            class="mdi mdi-filter-outline align-middle"></i>Filter</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            @can('report_service_table')
                                {{-- Tabel Report Service --}}
                                <div class="card-body">
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive mb-0">
                                            <table id="transactionTable-buttons" class="table table-striped">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th scope="col">Hari, Tanggal</th>
                                                        <th data-priority="1" scope="col">Servis Masuk</th>
                                                        <th data-priority="1" scope="col">Servis Selesai Ditangani</th>
                                                        <th data-priority="1" scope="col">Servis Keluar</th>
                                                        <th data-priority="1" scope="col">Total Pemasukan</th>
                                                        <th data-priority="1" scope="col">Modal</th>
                                                        <th data-priority="1" scope="col">Profit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($report) > 0)
                                                        @foreach ($report as $data)
                                                            <tr>
                                                                <td>{{ $data['date']->isoFormat('dddd, D MMMM Y') }}</td>
                                                                <td>{{ $data['service'] }}</td>
                                                                <td>{{ $data['service_detail'] }}</td>
                                                                <td>{{ $data['transaction'] }}</td>
                                                                <td>{{ 'RP. ' . number_format($data['income']) }}</td>
                                                                <td>{{ 'RP. ' . number_format($data['modal']) }}</td>
                                                                <td>{{ 'RP. ' . number_format($data['profit']) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="7" class="text-center">Belum ada transaksi servis</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                                <tfoot class="table-primary">
                                                    <tr>
                                                        <th> Total Laporan Bulan Ini </th>
                                                        <th>{{ $total_service }}</th>
                                                        <th>{{ $total_success }}</th>
                                                        <th>{{ $total_out }}</th>
                                                        <th>{{ 'RP. ' . number_format($total_revenue) }}</th>
                                                        <th>{{ 'RP. ' . number_format($total_modal_all) }}</th>
                                                        <th>{{ 'RP. ' . number_format($total_profit) }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Tabel Report Service --}}
                            @endcan

                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>

@endsection

@push('before-script')
    <script src="{{ asset('/assets/backsite/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('/assets/backsite/js/pages/apexcharts.init.js') }}"></script>
@endpush

@push('after-script')
    <script>
        var mixedChartColors = getChartColorsArray('service_chart');
        mixedChartColors && (function() {
            var options = {
                chart: {
                    height: 350,
                    type: 'line',
                    stacked: false,
                    toolbar: {
                        show: true
                    }
                },
                stroke: {
                    width: [2, 2, 2],
                    curve: 'smooth'
                },
                plotOptions: {
                    bar: {
                        columnWidth: '30%'
                    }
                },
                colors: mixedChartColors,
                series: [{
                        name: 'Servis Masuk',
                        type: 'area',
                        data: @json($chartData['totalMasuk'])
                    },
                    {
                        name: 'Servis Selesai Ditangani',
                        type: 'area',
                        data: @json($chartData['totalSelesai'])
                    },
                    {
                        name: 'Servis Keluar',
                        type: 'area',
                        data: @json($chartData['totalKeluar'])
                    },
                ],
                fill: {
                    opacity: [0.25, 0.25, 0.25],
                    gradient: {
                        inverseColors: false,
                        shade: 'light',
                        type: 'vertical',
                        opacityFrom: 0.85,
                        opacityTo: 0.55,
                        stops: [0, 100, 100, 100],
                    },
                },
                labels: @json($chartData['months']),
                markers: {
                    size: 2,
                    colors: mixedChartColors,
                    strokeColor: mixedChartColors,
                    strokeWidth: 3
                },
                xaxis: {
                    type: 'category'
                },
                yaxis: {
                    title: {
                        text: 'Total Keseluruhan'
                    },
                    labels: {
                        formatter: function(value) {
                            return Math.round(value)
                                .toString(); // Menggunakan Math.round() untuk membulatkan ke bilangan bulat
                        }
                    }
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function(e) {
                            return e !== undefined ? e.toFixed(0) + ' Servis' : e;
                        },
                    },
                },
                grid: {
                    borderColor: '#f1f1f1'
                },
            };

            var chart = new ApexCharts(document.querySelector('#service_chart'), options);
            chart.render();
        })();
    </script>
    <script>
        $(document).ready(function() {
            $('#transactionTable-buttons').DataTable({
                searching: false,
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf', 'colvis'
                ]
            });
        });
    </script>
@endpush
