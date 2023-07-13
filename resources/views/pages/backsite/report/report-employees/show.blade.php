@extends('layouts.app')

@section('title', 'Laporan Teknisi')

@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 card-title flex-grow-1">Laporan Transaksi Teknisi</h5>
                                </div>
                            </div>

                            <div class="card-body border-bottom">
                                <div class="row">
                                    <div class="col">
                                        <p class="mb-2">Teknisi :
                                            <span class="text-body fw-bold">{{ $teknisi->name }}
                                            </span>
                                        </p>
                                        <p class="mb-2">Rentang Tanggal :
                                            <span
                                                class="text-body fw-bold">{{ \Carbon\Carbon::parse($start_date)->isoFormat('dddd, D MMMM Y') }}
                                                -
                                                {{ \Carbon\Carbon::parse($end_date)->isoFormat('dddd, D MMMM Y') }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-rep-plugin">
                                    <div class="table-responsive mb-0">
                                        <table class="table table-striped">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Servis Keluar</th>
                                                    <th>Pemasukan</th>
                                                    <th>Modal</th>
                                                    <th>Profit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($laporanTeknisi as $date => $laporan)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('backsite.report-employees.detail', ['teknisiId' => $teknisi->id, 'tanggal' => $date]) }}"
                                                                class="fw-bold">
                                                                {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $laporan['totalService'] }}</td>
                                                        <td>{{ 'RP. ' . number_format($laporan['totalBiaya']) }}</td>
                                                        <td>{{ 'RP. ' . number_format($laporan['totalModal']) }}</td>
                                                        <td>{{ 'RP. ' . number_format($laporan['totalProfit']) }}</td>
                                                    </tr>
                                                @endforeach
                                                @if ($laporanTeknisi->isEmpty())
                                                    <tr>
                                                        <td colspan="5" class="text-center">Tidak ada transaksi</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                            <tfoot class="table-secondary">
                                                <tr>
                                                    <th>Total</th>
                                                    <th>{{ $totalService }}</th>
                                                    <th>{{ 'RP. ' . number_format($totalBiaya) }}</th>
                                                    <th>{{ 'RP. ' . number_format($totalModal) }}</th>
                                                    <th>{{ 'RP. ' . number_format($totalProfit) }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-6">
                                        <a href="{{ route('backsite.report-employees.index') }}" class="btn btn-secondary">
                                            <i class="mdi mdi-arrow-left me-1"></i> Kembali ke Laporan Teknisi
                                        </a>
                                    </div>
                                </div>
                            </div>

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
