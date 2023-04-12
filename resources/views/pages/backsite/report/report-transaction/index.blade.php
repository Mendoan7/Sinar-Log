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
                            </div>
                        </div>

                        <div class="card-body border-bottom">
                            <form method="GET" action="{{ route('backsite.report-transaction.index') }}">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 card-title">Periode : {{ $start_date->isoFormat('D MMMM Y') }} - {{ $end_date->isoFormat('D MMMM Y') }}</p>
                                    <div class="flex-grow-1">
                                        <div class="row g-3">
                                            <div class="col-xxl-6 col-lg-8"></div>
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
                                            @foreach ($report as $data)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($data['date'])->isoFormat('D MMMM Y')}}</td>
                                                    <td>{{ $data['service'] }}</td>
                                                    <td>{{ $data['service_detail'] }}</td>
                                                    <td>{{ $data['transaction'] }}</td>
                                                    <td>{{ 'RP. '.number_format ($data['income']) }}</td>
                                                    <td>{{ 'RP. '.number_format ($data['modal']) }}</td>
                                                    <td>{{ 'RP. '.number_format ($data['profit']) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-primary">
                                            <tr>
                                                <th> Total Laporan Bulan Ini </th>
                                                <th>{{ $total_service }}</th>
                                                <th>{{ $total_success }}</th>
                                                <th>{{ $total_out }}</th>
                                                <th>{{ 'RP. '.number_format($total_revenue) }}</th>
                                                <th>{{ 'RP. '.number_format($total_modal) }}</th>
                                                <th>{{ 'RP. '.number_format($total_profit) }}</th>
                                            </tr>
                                        </tfoot>
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

@push('after-script')
    <!-- Responsive Table js -->
    <script src="{{ asset('/assets/backsite/libs/admin-resources/rwd-table/rwd-table.min.js') }}"></script>
    
    {{-- <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                "language": {
                    "url" : '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                }
            } );
        } );
    </script> --}}
@endpush