@extends('layouts.app')

@section('title', 'Laporan Teknisi')

@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">

                            <div class="card-header bg-opacity-25 bg-primary">
                                <h5 class="fw-bold text-dark m-0">Detail Transaksi Teknisi</h5>
                            </div>

                            <div class="card-body border-bottom">
                                <div class="row">
                                    <div class="col">
                                        <p class="mb-2">Berikut servis yang selesai ditangani oleh <span
                                                class="text-body fw-bold">{{ $teknisi->name }}</span></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xxl-6 col-lg-8">
                                        <p class="mb-2">Tanggal Transaksi : <span
                                                class="fw-bold">{{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM Y') }}</span>
                                        </p>
                                    </div>
                                    <div class="col-xxl-3 col-lg-4 offset-xxl-3">
                                        <p class="mb-0">Total :
                                            {{ 'RP. ' . number_format($dataService->sum('service_detail.biaya')) }}</span>
                                        </p>
                                        <p class="mb-0 fw-bolder">Profit :
                                            {{ 'RP. ' . number_format($dataService->sum('service_detail.biaya') - $dataService->sum('service_detail.modal')) }}
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
                                                    <th>Pemilik</th>
                                                    <th>Barang</th>
                                                    <th>Kerusakan</th>
                                                    <th>Kondisi</th>
                                                    <th>Tindakan</th>
                                                    <th>Modal</th>
                                                    <th>Biaya</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dataService as $service)
                                                    <tr>
                                                        <td>{{ $service->service_detail->transaction->created_at ? date('d/m/Y H:i', strtotime($service->service_detail->transaction->created_at)) : '' }}
                                                        </td>

                                                        <td class="fw-bold">{{ $service->customer->name }}</td>
                                                        <td>{{ $service->jenis ?? '' }} {{ $service->tipe ?? '' }}</td>
                                                        <td>{{ $service->kerusakan }}</td>
                                                        <td>
                                                            @if ($service->service_detail->kondisi == 1)
                                                                <span class="badge bg-success">{{ 'Sudah Jadi' }}</span>
                                                            @elseif($service->service_detail->kondisi == 2)
                                                                <span class="badge bg-danger">{{ 'Tidak Bisa' }}</span>
                                                            @elseif($service->service_detail->kondisi == 3)
                                                                <span class="badge bg-secondary">{{ 'Dibatalkan' }}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $service->service_detail->tindakan ?? '' }}</td>
                                                        <td>{{ 'RP. ' . number_format($service->service_detail->modal) }}
                                                        </td>
                                                        <td>{{ 'RP. ' . number_format($service->service_detail->biaya) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-6">
                                        <a href="{{ route('backsite.report-employees.show', ['teknisiId' => $teknisi->id]) }}"
                                            class="btn btn-secondary">
                                            <i class="mdi mdi-arrow-left me-1"></i> Lihat Transaksi Lainnya
                                        </a>
                                    </div> <!-- end col -->
                                </div> <!-- end row-->
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
