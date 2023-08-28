@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <form id="dateForm" action="{{ route('backsite.dashboard.index') }}" method="GET">
                    <div class="row mb-4 align-items-center">
                        <div class="col-12 col-lg-auto mb-4 mb-lg-0 me-auto">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-2">Welcome Back, Sinar Cell Dashboard! &#127881</p>
                                    <h5 class="mb-2 card-title">{{ Auth::user()->name }}</h5>
                                    <p class="text-muted mb-0">{{ Auth::user()->detail_user->type_user->name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-auto">
                            <div class="d-inline-flex align-items-center me-2 mb-2">
                                <div class="input-daterange input-group" id="dateContainer" data-date-format="yyyy-mm-dd"
                                    data-date-autoclose="true" data-provide="datepicker">
                                    <input type="text" class="form-control" id="start_date" name="start_date"
                                        placeholder="Tanggal Mulai"
                                        value="{{ \Carbon\Carbon::parse($startDate)->format('Y-m-d') }}" />
                                    <input type="text" class="form-control" id="end_date" name="end_date"
                                        placeholder="Tanggal Akhir"
                                        value="{{ \Carbon\Carbon::parse($endDate)->format('Y-m-d') }}" />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-soft-success"><i
                                    class="mdi mdi-filter-outline align-middle"></i>
                                Filter
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Admin --}}
                @can('dashboard_report_admin')
                    <div class="row">
                        {{-- Servis Masuk --}}
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="mb-0 text-right">Servis Masuk</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0">{{ $total_service }}</h3>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <i class="bx bxs-log-in text-warning fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body border-top py-3">
                                    <p class="text-muted mb-0 text-center">
                                        <i class="mdi mdi-information" aria-hidden="true"></i>
                                        Total dari servis masuk
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- End Servis Masuk --}}
                        {{-- Servis Selesai --}}
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="mb-0 text-right">Bisa Diambil</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0">{{ $total_success }}</h3>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <i class="bx bxs-check-square text-primary fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body border-top py-3">
                                    <p class="text-muted mb-0 text-center">
                                        <i class="mdi mdi-information" aria-hidden="true"></i>
                                        Servis yang bisa diambil
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- End Servis Selesai --}}
                        {{-- Servis Keluar --}}
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="mb-0 text-right">Servis Keluar</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0">{{ $total_out }}</h3>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <i class="bx bxs-log-out text-success fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body border-top py-3">
                                    <p class="text-muted mb-0 text-center">
                                        <i class="mdi mdi-information" aria-hidden="true"></i>
                                        Servis yang sudah diambil
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- End Servis Keluar --}}
                        {{-- Pemasukan --}}
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="mb-0 text-right">Total Pemasukan</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0">
                                                    {{ 'Rp. ' . number_format($total_revenue) }}</h3>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <i class="mdi mdi-cube text-danger fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body border-top py-3">
                                    <p class="text-muted mb-0 text-center">
                                        <i class="mdi mdi-information" aria-hidden="true"></i>
                                        Total Pemasukan
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- End Pemasukan --}}
                    </div>
                @endcan

                {{-- Teknisi --}}
                @can('dashboard_report_technician')
                    <div class="row">
                        {{-- Servis Masuk --}}
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="mb-0 text-right">Servis Antrian</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0">{{ $total_queue }}</h3>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <i class="mdi mdi-archive text-warning fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body border-top py-3">
                                    <p class="text-muted mb-0 text-center">
                                        @if ($queue_date->isNotEmpty())
                                            <i class="mdi mdi-reload mr-1" aria-hidden="true"></i> Update :
                                            {{ $queue_date->map(function ($date) {
                                                    return $date->format('d M, Y');
                                                })->implode(', ') }}
                                        @else
                                            Tidak ada antrian saat ini.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- End Servis Masuk --}}
                        {{-- Servis Selesai --}}
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="mb-0 text-right">Proses Servis</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0">{{ $total_in_progress }}</h3>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <i class="mdi mdi-autorenew text-primary fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body border-top py-3">
                                    <p class="text-muted mb-0 text-center">
                                        @if ($progress_date->isNotEmpty())
                                            <i class="mdi mdi-reload mr-1" aria-hidden="true"></i> Update :
                                            {{ $progress_date->map(function ($date) {
                                                    return $date->format('d M, Y');
                                                })->implode(', ') }}
                                        @else
                                            Tidak proses servis saat ini.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- End Servis Selesai --}}
                        {{-- Servis Keluar --}}
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="mb-0 text-right">Servis Keluar</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0">{{ $total_out_teknisi }}
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <i class="bx bxs-log-out text-success fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body border-top py-3">
                                    <p class="text-muted mb-0 text-center">
                                        <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i>
                                        @if (request()->has('start_date'))
                                            {{ \Carbon\Carbon::parse(request('start_date'))->format('d M, Y') }}
                                            -
                                            {{ \Carbon\Carbon::parse(request('end_date'))->format('d M, Y') }}
                                        @else
                                            {{ date('d M, Y') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- End Servis Keluar --}}
                        {{-- Pemasukan --}}
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="mb-0 text-right">Total Pemasukan</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0">
                                                    {{ 'Rp. ' . number_format($total_revenue_teknisi) }}</h3>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <i class="mdi mdi-cube text-danger fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body border-top py-3">
                                    <p class="text-muted mb-0 text-center">
                                        <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i>
                                        @if (request()->has('start_date'))
                                            {{ \Carbon\Carbon::parse(request('start_date'))->format('d M, Y') }}
                                            -
                                            {{ \Carbon\Carbon::parse(request('end_date'))->format('d M, Y') }}
                                        @else
                                            {{ date('d M, Y') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- End Pemasukan --}}
                    </div>
                @endcan

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-2">Statistik Servis</h4>
                                <h6>Tahun {{ Carbon\Carbon::now()->format('Y') }}</h6>
                                <div id="service_chart" data-colors='["--bs-primary","--bs-warning", "--bs-success"]'
                                    class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Latest Transaction --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Transaksi Terakhir</h4>
                                <div class="table-responsive">
                                    <table class="table align-middle table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="align-middle">Kode Servis</th>
                                                <th class="align-middle">Tanggal</th>
                                                <th class="align-middle">Pemilik</th>
                                                <th class="align-middle">Barang</th>
                                                <th class="align-middle">Kerusakan</th>
                                                <th class="align-middle">Status</th>
                                                @if (Auth::user()->detail_user->type_user_id <= 2)
                                                    <th class="align-middle">Teknisi</th>
                                                @endif
                                                <th class="align-middle">Kondisi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($latest_services as $service)
                                                <tr>
                                                    <td class="text-body fw-bold">{{ $service->kode_servis ?? '' }}</td>
                                                    <td>{{ $service->updated_at ?? '' }}</td>
                                                    <td>{{ $service->customer->name ?? '' }}</td>
                                                    <td>{{ $service->jenis ?? '' }} {{ $service->tipe ?? '' }}</td>
                                                    <td>{{ $service->service_detail->kerusakan ?? '' }}</td>
                                                    <td>
                                                        @if ($service->status == 1)
                                                            <span
                                                                class="badge badge-pill badge-soft-secondary font-size-11">{{ 'Belum Cek' }}</span>
                                                        @elseif($service->status == 2)
                                                            <span
                                                                class="badge badge-pill badge-soft-info font-size-11">{{ 'Akan Dikerjakan' }}</span>
                                                        @elseif($service->status == 3)
                                                            <span
                                                                class="badge badge-pill badge-soft-info font-size-11">{{ 'Sedang Cek' }}</span>
                                                        @elseif($service->status == 4)
                                                            <span
                                                                class="badge badge-pill badge-soft-success font-size-11">{{ 'Sedang Dikerjakan' }}</span>
                                                        @elseif($service->status == 5)
                                                            <span
                                                                class="badge badge-pill badge-soft-warning font-size-11">{{ 'Sedang Tes' }}</span>
                                                        @elseif($service->status == 6)
                                                            <span
                                                                class="badge badge-pill badge-soft-danger font-size-11">{{ 'Menunggu Konfirmasi' }}</span>
                                                        @elseif($service->status == 7)
                                                            <span
                                                                class="badge badge-pill badge-soft-primary font-size-11">{{ 'Menunggu Sparepart' }}</span>
                                                        @elseif($service->status == 8)
                                                            <span
                                                                class="badge badge-pill badge-soft-primary font-size-11">{{ 'Bisa Diambil' }}</span>
                                                        @elseif($service->status == 9)
                                                            <span
                                                                class="badge badge-pill badge-soft-success font-size-11">{{ 'Sudah Diambil' }}</span>
                                                        @elseif($service->status == 10)
                                                            <span
                                                                class="badge badge-pill badge-soft-primary font-size-11">{{ 'Terkonfirmasi' }}</span>
                                                        @elseif($service->status == 11)
                                                            <span
                                                                class="badge badge-pill badge-soft-primary font-size-11">{{ 'Dibatalkan' }}</span>
                                                        @elseif($service->service_detail?->transaction?->warranty_history?->status == 1)
                                                            <span
                                                                class="badge badge-pill badge-soft-warning font-size-11">{{ 'Garansi' }}</span>
                                                        @elseif($service->service_detail?->transaction?->warranty_history?->status == 2)
                                                            <span
                                                                class="badge badge-pill badge-soft-warning font-size-11">{{ 'Garansi Bisa Diambil' }}</span>
                                                        @elseif($service->service_detail?->transaction?->warranty_history?->status == 3)
                                                            <span
                                                                class="badge badge-pill badge-soft-warning font-size-11">{{ 'Garansi Sudah Diambil' }}</span>
                                                        @endif
                                                    </td>
                                                    @if (Auth::user()->detail_user->type_user_id <= 2)
                                                        <!-- Check if user is an admin -->
                                                        <td>
                                                            @if ($service->teknisi)
                                                                {{ explode(' ', $service->teknisi_detail->name)[0] }}
                                                            @else
                                                                Belum Ada
                                                            @endif
                                                        </td>
                                                    @endif
                                                    <td>
                                                        @isset($service->service_detail)
                                                            @if ($service->service_detail->kondisi == 1)
                                                                <i
                                                                    class="mdi mdi-circle text-success align-middle me-1"></i>{{ 'Sudah Jadi' }}
                                                            @elseif($service->service_detail->kondisi == 2)
                                                                <i
                                                                    class="mdi mdi-circle text-danger align-middle me-1"></i>{{ 'Tidak Bisa' }}
                                                            @elseif($service->service_detail->kondisi == 3)
                                                                <i
                                                                    class="mdi mdi-circle text-secondary align-middle me-1"></i>{{ 'Dibatalkan' }}
                                                            @endif
                                                        @else
                                                            <i
                                                                class="mdi mdi-circle text-primary align-middle me-1"></i>{{ 'Proses Servis' }}
                                                        @endisset
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Latest Transaction --}}

            </div>
            <!-- container-fluid -->
        </div>
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
                    width: [0, 2, 4],
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
                        type: 'column',
                        data: @json($chartData['totalMasuk'])
                    },
                    {
                        name: 'Bisa Diambil',
                        type: 'area',
                        data: @json($chartData['totalSelesai'])
                    },
                    {
                        name: 'Servis Keluar',
                        type: 'line',
                        data: @json($chartData['totalKeluar'])
                    },
                ],
                fill: {
                    opacity: [0.85, 0.50, 1],
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
                    size: 0
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
@endpush
