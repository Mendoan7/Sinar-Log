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
                                                            class="mdi mdi-filter-outline align-middle"></i>
                                                        Filter
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            @can('report_employee_table')
                                {{-- Tabel Report Employee --}}
                                <div class="card-body">
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive mb-0">
                                            <table id="employeeTable-buttons" class="table table-striped">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>Teknisi</th>
                                                        <th>Servis Keluar</th>
                                                        <th>Pemasukan</th>
                                                        <th>Modal</th>
                                                        <th>Profit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($teknisi) > 0)
                                                        @foreach ($teknisi as $user)
                                                            <tr>
                                                                <td>
                                                                    <a href="{{ route('backsite.report-employees.show', ['teknisiId' => $user->id, 'start_date' => $start_date->format('Y-m-d'), 'end_date' => $end_date->format('Y-m-d')]) }}"
                                                                        class="fw-bold">{{ $user->name }}
                                                                    </a>
                                                                </td>
                                                                <td>{{ $total_service[$user->id] }}</td>
                                                                <td>{{ 'RP. ' . number_format($total_biaya_service[$user->id]) }}
                                                                </td>
                                                                <td>{{ 'RP. ' . number_format($total_modal_service[$user->id]) }}
                                                                </td>
                                                                <td>{{ 'RP. ' . number_format($total_profit_service[$user->id]) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="5" class="text-center">Belum ada Teknisi</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                                <tfoot class="table-secondary">
                                                    <tr>
                                                        <th>Total</th>
                                                        <th>{{ $total_servis_selesai }}</th>
                                                        <th>{{ 'RP. ' . number_format($total_pemasukan) }}</th>
                                                        <th>{{ 'RP. ' . number_format($total_modal) }}</th>
                                                        <th>{{ 'RP. ' . number_format($total_profit) }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Tabel Report Employee --}}
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

@push('after-script')
    <script>
        $(document).ready(function() {
            $('#employeeTable-buttons').DataTable({
                searching: false,
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf', 'colvis'
                    // 'copy' // Komentari atau hilangkan baris ini untuk menyembunyikan tombol "Copy"
                ]
            });
        });
    </script>
@endpush
