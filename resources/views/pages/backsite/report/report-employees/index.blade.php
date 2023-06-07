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
                                <h5 class="mb-0 card-title flex-grow-1">Laporan Teknisi</h5>
                            </div>
                        </div>

                        <div class="card-body border-bottom">
                            <form method="GET" action="{{ route('backsite.report-employees.index') }}">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="row g-3">
                                            <div class="col-xxl-6 col-lg-8 align-self-center">
                                                <p class="mb-0 card-title">Periode : {{ $start_date->isoFormat('D MMMM Y') }} - {{ $end_date->isoFormat('D MMMM Y') }}</p>
                                            </div>
                                            <div class="col-xxl-4 col-lg-6">
                                                <div class="input-daterange input-group" id="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker'>
                                                    <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Tanggal Mulai" />
                                                    <input type="text" class="form-control" id="end_date" name="end_date" placeholder="Tanggal Akhir" />
                                                </div>
                                            </div>
                                            <div class="col-xxl-2 col-lg-4">
                                                <button type="submit" class="btn btn-soft-success w-100"><i class="mdi mdi-filter-outline align-middle"></i>Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-responsive mb-0">
                                    <table class="table table-striped">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Teknisi</th>
                                                <th>Jumlah Servis Selesai</th>
                                                <th>Pemasukan</th>
                                                <th>Modal</th>
                                                <th>Profit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($teknisi as $user)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('backsite.report-employees.show', ['teknisiId' => $user->id]) }}" class="fw-bold">{{ $user->name }}</a>
                                                    </td>
                                                    <td>{{ $total_service[$user->id] }}</td>
                                                    <td>{{ 'RP. '.number_format($total_biaya_service[$user->id]) }}</td>
                                                    <td>{{ 'RP. '.number_format($total_modal_service[$user->id]) }}</td>
                                                    <td>{{ 'RP. '.number_format($total_profit_service[$user->id]) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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