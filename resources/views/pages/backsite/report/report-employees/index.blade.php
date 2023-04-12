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
                                    <table class="table table-striped-columns table-hover mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                              <th>Tanggal</th>
                                              @foreach($all_teknisi as $teknisi)
                                                <th>{{ $teknisi }}</th>
                                              @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dates as $date)
                                                @if(isset($total_service[$date->format('Y-m-d')]) && array_sum($total_service[$date->format('Y-m-d')]) > 0)
                                                    <tr>
                                                        <td>{{ $date->isoFormat('dddd, D MMMM Y') }}</td>
                                                        @foreach($all_teknisi as $teknisi)
                                                            @if(isset($total_service[$date->format('Y-m-d')][$teknisi]))
                                                                <td>{{ $total_service[$date->format('Y-m-d')][$teknisi] }}</td>
                                                            @else
                                                                <td>0</td>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-primary font-weight-bold">
                                            <tr>
                                                <th>Total Servis Selesai</th>
                                                @foreach($all_teknisi as $teknisi)
                                                    <th> {{ isset($total_all_service[$teknisi]) ? $total_all_service[$teknisi] : 0 }}</th>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th>Total Pemasukan</th>
                                                @foreach($all_teknisi as $teknisi)
                                                    <th> {{ isset($total_all_biaya_service[$teknisi]) ? 'RP. '.number_format($total_all_biaya_service[$teknisi]) : 'RP. 0' }}</th>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th>Total Modal</th>
                                                @foreach ($all_teknisi as $teknisi)
                                                    <th> {{ isset($total_all_modal_service[$teknisi]) ? 'RP. '.number_format($total_all_modal_service[$teknisi]) : 'RP. 0' }}</th>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th>Total Profit</th>
                                                @foreach ($all_teknisi as $teknisi)
                                                    <th> {{ isset($total_all_profit_service[$teknisi]) ? 'RP. '.number_format($total_all_profit_service[$teknisi]) : 'RP. 0' }}</th>
                                                @endforeach
                                            </tr>
                                        </tfoot>
                                    </table>
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
                                                <th>Teknisi</th>
                                                <th>Jumlah Servis Selesai</th>
                                                <th>Pemasukan</th>
                                                <th>Modal</th>
                                                <th>Profit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dates as $date)
                                                @foreach($total_service[$date->format('Y-m-d')] as $teknisi => $jumlah_servis)
                                                    <tr>
                                                        <td>{{ $date->isoFormat('dddd, D MMMM Y') }}</td>
                                                        <td>{{ $teknisi }}</td>
                                                        <td>{{ $jumlah_servis }}</td>
                                                        <td>
                                                            @if (isset($total_biaya_service[$date->format('Y-m-d')][$teknisi]))
                                                                {{ 'RP. '.number_format ($total_biaya_service[$date->format('Y-m-d')][$teknisi]) }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (isset($total_modal_service[$date->format('Y-m-d')][$teknisi]))
                                                                {{ 'RP. '.number_format ($total_modal_service[$date->format('Y-m-d')][$teknisi]) }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (isset($total_profit_service[$date->format('Y-m-d')][$teknisi]))
                                                                {{ 'RP. '.number_format ($total_profit_service[$date->format('Y-m-d')][$teknisi]) }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-primary">
                                            @foreach ($all_teknisi as $teknisi)
                                            <tr>
                                                <th>Total</th>
                                                <th>{{ $teknisi }}</th>
                                                <th>{{ $total_all_service[$teknisi] }}</th>
                                                <th>{{ 'RP. '.number_format($total_all_biaya_service[$teknisi]) }}</th>
                                                <th>{{ 'RP. '.number_format($total_all_modal_service[$teknisi])  }}</th>
                                                <th>{{ 'RP. '.number_format($total_all_profit_service[$teknisi])  }}</th>
                                            </tr>
                                            @endforeach
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

