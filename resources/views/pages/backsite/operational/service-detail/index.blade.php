@extends('layouts.app')

@section('title', 'Bisa Diambil')

@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 card-title flex-grow-1">Bisa Diambil</h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom">
                                    <li class="nav-item">
                                        <a class="nav-link{{ !request('status') ? ' active' : '' }}"
                                            href="{{ route('backsite.service-detail.index') }}">
                                            Semua <span class="badge bg-primary ms-1">{{ $all_count }}</span>
                                        </a>
                                    </li>

                                    <li class="nav-item dropdown d-md-none">
                                        <a class="nav-link dropdown-toggle{{ request('status') === 'done' ? ' active' : '' }}"
                                            href="#" id="statusDropdown" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Status <i class="mdi mdi-chevron-down"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                                            <li>
                                                <a class="dropdown-item{{ request('status') === 'done' ? ' active' : '' }}"
                                                    href="{{ route('backsite.service-detail.index', ['status' => 'done']) }}">
                                                    Sudah Jadi <span
                                                        class="badge bg-success ms-1">{{ $done_count }}</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item{{ request('status') === 'notdone' ? ' active' : '' }}"
                                                    href="{{ route('backsite.service-detail.index', ['status' => 'notdone']) }}">
                                                    Tidak Bisa <span
                                                        class="badge bg-danger ms-1">{{ $notdone_count }}</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item{{ request('status') === 'cancel' ? ' active' : '' }}"
                                                    href="{{ route('backsite.service-detail.index', ['status' => 'cancel']) }}">
                                                    Dibatalkan <span
                                                        class="badge bg-secondary ms-1">{{ $cancel_count }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item d-none d-md-block">
                                        <a class="nav-link{{ request('status') === 'done' ? ' active' : '' }}"
                                            href="{{ route('backsite.service-detail.index', ['status' => 'done']) }}">
                                            Sudah Jadi <span class="badge bg-success ms-1">{{ $done_count }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item d-none d-md-block">
                                        <a class="nav-link{{ request('status') === 'notdone' ? ' active' : '' }}"
                                            href="{{ route('backsite.service-detail.index', ['status' => 'notdone']) }}">
                                            Tidak Bisa <span class="badge bg-danger ms-1">{{ $notdone_count }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item d-none d-md-block">
                                        <a class="nav-link{{ request('status') === 'cancel' ? ' active' : '' }}"
                                            href="{{ route('backsite.service-detail.index', ['status' => 'cancel']) }}">
                                            Dibatalkan <span class="badge bg-secondary ms-1">{{ $cancel_count }}</span>
                                        </a>
                                    </li>
                                </ul>
                                <!-- End nav tabs -->
                            </div>

                            @can('service_detail_table')
                                {{-- Tabel Service --}}
                                <div class="card-body">
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table id="servicesTable" class="table table-bordered table-striped mb-0"
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No. Servis</th>
                                                        <th scope="col">Tgl. Ditangani</th>
                                                        <th scope="col">Pemilik</th>
                                                        <th scope="col">Barang</th>
                                                        <th scope="col">Kerusakan</th>
                                                        <th scope="col">Kondisi</th>
                                                        <th scope="col">Tindakan</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Aksi</th>
                                                        <th scope="col">Ubah Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($service_detail as $key => $services_item)
                                                        <tr data-entry-id="{{ $services_item->id }}"
                                                            data-condition="@if ($services_item->kondisi == 1) done @elseif ($services_item->kondisi == 2) notdone @elseif ($services_item->kondisi == 3) cancel @endif">
                                                            @if ($services_item->warranty_history?->status == 2)
                                                                <td class="text-body fw-bold">
                                                                    {{ $services_item->service->kode_servis ?? '' }}</td>
                                                                <td
                                                                    data-order="{{ $services_item->warranty_history->updated_at }}">
                                                                    {{ $services_item->warranty_history?->updated_at->isoFormat('D MMM Y') }}
                                                                </td>
                                                                <td class="text-body fw-bold">
                                                                    {{ $services_item->service->customer->name ?? '' }}</td>
                                                                <td>{{ $services_item->service->jenis ?? '' }}
                                                                    {{ $services_item->service->tipe ?? '' }}</td>
                                                                <td>{{ $services_item->warranty_history->keterangan ?? '' }}
                                                                </td>
                                                                <td>
                                                                    @if ($services_item->warranty_history->kondisi == 1)
                                                                        <span
                                                                            class="badge bg-success">{{ 'Sudah Jadi' }}</span>
                                                                    @elseif($services_item->warranty_history->kondisi == 2)
                                                                        <span
                                                                            class="badge bg-danger">{{ 'Tidak Bisa' }}</span>
                                                                    @elseif($services_item->warranty_history->kondisi == 3)
                                                                        <span
                                                                            class="badge bg-secondary">{{ 'Dibatalkan' }}</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $services_item->warranty_history->tindakan ?? '' }}
                                                                </td>
                                                            @else
                                                                <td class="text-body fw-bold">
                                                                    {{ $services_item->service->kode_servis ?? '' }}</td>
                                                                <td data-order="{{ $services_item->service->date_done }}">
                                                                    {{ \Carbon\Carbon::parse($services_item->service->date_done)->isoFormat('D MMM Y HH:mm') }}
                                                                </td>
                                                                <td class="text-body fw-bold">
                                                                    {{ $services_item->service->customer->name ?? '' }}</td>
                                                                <td>{{ $services_item->service->jenis ?? '' }}
                                                                    {{ $services_item->service->tipe ?? '' }}</td>
                                                                <td>{{ $services_item->kerusakan ?? '' }}</td>
                                                                <td>
                                                                    @if ($services_item->kondisi == 1)
                                                                        <span
                                                                            class="badge bg-success">{{ 'Sudah Jadi' }}</span>
                                                                    @elseif($services_item->kondisi == 2)
                                                                        <span
                                                                            class="badge bg-danger">{{ 'Tidak Bisa' }}</span>
                                                                    @elseif($services_item->kondisi == 3)
                                                                        <span
                                                                            class="badge bg-secondary">{{ 'Dibatalkan' }}</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if(isset($services_item->tindakan))
                                                                        {{ implode(', ', json_decode($services_item->tindakan)) }}
                                                                    @endif
                                                                </td>
                                                            @endif
                                                            <td>
                                                                @if ($services_item->service->status == 8)
                                                                    <span class="badge bg-primary">{{ 'Bisa Diambil' }}</span>
                                                                @elseif($services_item->warranty_history->status == 2)
                                                                    <span
                                                                        class="badge bg-warning">{{ 'Garansi Bisa Diambil' }}</span>
                                                                @else
                                                                    <span>{{ 'N/A' }}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <ul class="list-unstyled hstack gap-1 mb-0">
                                                                    @can('service_detail_show')
                                                                        {{-- Start Button Show --}}
                                                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Servis" class="disable-tooltip">
                                                                            <button class="btn btn-sm btn-soft-primary"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#showModal{{ $services_item->id }}">
                                                                                <i class="mdi mdi-eye-outline"></i>
                                                                            </button>
                                                                            {{-- Content Modal --}}
                                                                            <div class="modal fade bs-example-modal-center" id="showModal{{ $services_item->id }}" tabindex="-1" aria-hidden="true" aria-labelledby="showServicesModalLabel" aria-expanded="false">
                                                                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title"
                                                                                                id="showServicesModalLabel">Detail
                                                                                                Servis</h5>
                                                                                            <button type="button" class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close"></button>
                                                                                        </div>
                                                                                        @if ($services_item->warranty_history?->status == 2)
                                                                                            {{-- start body garansi --}}
                                                                                            <div class="modal-body">
                                                                                                <table
                                                                                                    class="table table-striped mb-0 table-hover">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <th scope="col">No.
                                                                                                                Servis</th>
                                                                                                            <td scope="col">
                                                                                                                {{ isset($services_item->service->kode_servis) ? $services_item->service->kode_servis : 'N/A' }}
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="row">Tgl.
                                                                                                                Klaim</th>
                                                                                                            <td>{{ $services_item->warranty_history->created_at->isoFormat('dddd, D MMMM Y HH:mm') }}
                                                                                                                WIB</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="row">
                                                                                                                Pemilik</th>
                                                                                                            <td>{{ isset($services_item->service->customer->name) ? $services_item->service->customer->name : 'N/A' }}
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="row">
                                                                                                                Barang Servis</th>
                                                                                                            <td>{{ isset($services_item->service->jenis) ? $services_item->service->jenis : 'N/A' }}
                                                                                                                {{ isset($services_item->service->tipe) ? $services_item->service->tipe : 'N/A' }}
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="row">
                                                                                                                Kerusakan Awal</th>
                                                                                                            <td>{{ isset($services_item->kerusakan) ? $services_item->kerusakan : 'N/A' }}
                                                                                                            </td>
                                                                                                        </tr>

                                                                                                        {{-- Tindakan dan Modal --}}
                                                                                                        @if(isset($services_item->tindakan) && isset($services_item->modal))
                                                                                                            @php
                                                                                                                $tindakan = json_decode($services_item->tindakan, true);
                                                                                                                $modal = json_decode($services_item->modal);
                                                                                                                $totalModal = array_sum($modal);
                                                                                                            @endphp

                                                                                                            @if(count($tindakan) === 1)
                                                                                                                <tr>
                                                                                                                    <th scope="row">Tindakan</th>
                                                                                                                    <td>{{ $tindakan[0] }}</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <th scope="row">Modal</th>
                                                                                                                    <td>RP. {{ number_format($modal[0]) }}</td>
                                                                                                                </tr>
                                                                                                            @else
                                                                                                                <tr>
                                                                                                                    <td colspan="2">
                                                                                                                        <div class="accordion" id="accordionFlushShow">
                                                                                                                            <div class="accordion-item">
                                                                                                                                <h2 class="accordion-header" id="flush-headingOne">
                                                                                                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                                                                                                                                        <span class="fw-bold">Tindakan dan Modal</span>
                                                                                                                                    </button>
                                                                                                                                </h2>
                                                                                                                                <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushShow">
                                                                                                                                    <div class="accordion-body">
                                                                                                                                        <table class="table table-striped mb-0">
                                                                                                                                            <thead class="table-secondary">
                                                                                                                                                <tr>
                                                                                                                                                    <th scope="col">#</th>
                                                                                                                                                    <th scope="col">Tindakan</th>
                                                                                                                                                    <th scope="col">Modal</th>
                                                                                                                                                </tr>
                                                                                                                                            </thead>
                                                                                                                                            <tbody>
                                                                                                                                                @foreach($tindakan as $index => $item)
                                                                                                                                                    <tr>
                                                                                                                                                        <th scope="row">{{ $index + 1 }}</th>
                                                                                                                                                        <td>{{ $item }}</td>
                                                                                                                                                        <td>RP. {{ number_format($modal[$index]) }}</td>
                                                                                                                                                    </tr>
                                                                                                                                                @endforeach
                                                                                                                                            </tbody>
                                                                                                                                            <tfoot class="table-secondary">
                                                                                                                                                <tr>
                                                                                                                                                    <th colspan="2" scope="row" class="fw-bold">Total Modal</th>
                                                                                                                                                    <td class="fw-bold">RP. {{ number_format($totalModal) }}</td>
                                                                                                                                                </tr>
                                                                                                                                            </tfoot>
                                                                                                                                        </table>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            @endif
                                                                                                        @else
                                                                                                            <tr>
                                                                                                                <td colspan="2">N/A</td>
                                                                                                            </tr>
                                                                                                        @endif
                                                                                                        {{-- End Tindakan dan Modal --}}

                                                                                                        <tr>
                                                                                                            <th scope="row">Biaya</th>
                                                                                                            <td><span class="fw-bold">{{ isset($services_item->biaya) ? 'RP. ' . number_format($services_item->biaya) : 'N/A' }}</span></td>
                                                                                                        </tr>
                                                                                                        <tr class="table-info">
                                                                                                            <th colspan="2"
                                                                                                                class="text-center fw-bold">
                                                                                                                Detail Garansi</th>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="row">Ket.
                                                                                                                Klaim</th>
                                                                                                            <td>{{ isset($services_item->warranty_history->keterangan) ? $services_item->warranty_history->keterangan : 'N/A' }}
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="row">
                                                                                                                Tindakan Garansi
                                                                                                            </th>
                                                                                                            <td>{{ isset($services_item->warranty_history->tindakan) ? $services_item->warranty_history->tindakan : 'N/A' }}
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="row">
                                                                                                                Kondisi</th>
                                                                                                            <td>
                                                                                                                @if ($services_item->warranty_history->kondisi == 1)
                                                                                                                    <span
                                                                                                                        class="badge bg-success">{{ 'Sudah Jadi' }}</span>
                                                                                                                @elseif($services_item->warranty_history->kondisi == 2)
                                                                                                                    <span
                                                                                                                        class="badge bg-danger">{{ 'Tidak Bisa' }}</span>
                                                                                                                @elseif($services_item->warranty_history->kondisi == 3)
                                                                                                                    <span
                                                                                                                        class="badge bg-secondary">{{ 'Dibatalkan' }}</span>
                                                                                                                @endif
                                                                                                                -
                                                                                                                {{ $services_item->warranty_history->updated_at->isoFormat('dddd, D MMMM Y HH:mm') }}
                                                                                                                WIB
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="row">
                                                                                                                Catatan</th>
                                                                                                            <td>{{ isset($services_item->warranty_history->catatan) ? $services_item->warranty_history->catatan : 'N/A' }}
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="row">
                                                                                                                Status</th>
                                                                                                            <td>
                                                                                                                @if ($services_item->service->status == 8)
                                                                                                                    <span
                                                                                                                        class="badge bg-primary">{{ 'Bisa Diambil' }}</span>
                                                                                                                @elseif($services_item->warranty_history->status == 2)
                                                                                                                    <span
                                                                                                                        class="badge bg-primary">{{ 'Garansi Bisa Diambil' }}</span>
                                                                                                                @endif
                                                                                                                - [Teknisi :
                                                                                                                {{ $services_item->service->teknisi_detail->name }}]
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                            {{-- end body garansi --}}
                                                                                        @else
                                                                                            {{-- start body non-garansi --}}
                                                                                            <div class="modal-body">
                                                                                                <table
                                                                                                    class="table table-striped mb-0 table-hover">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <th scope="col">No.
                                                                                                                Servis</th>
                                                                                                            <td scope="col">
                                                                                                                {{ isset($services_item->service->kode_servis) ? $services_item->service->kode_servis : 'N/A' }}
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="row">Tgl.
                                                                                                                Masuk</th>
                                                                                                            <td>{{ \Carbon\Carbon::parse($services_item->service->created_at)->isoFormat('dddd, D MMMM Y HH:mm') }}
                                                                                                                WIB
                                                                                                                [{{ isset($services_item->service->penerima) ? $services_item->service->penerima : 'N/A' }}]
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="row">
                                                                                                                Pemilik</th>
                                                                                                            <td>{{ isset($services_item->service->customer->name) ? $services_item->service->customer->name : 'N/A' }}
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="row">
                                                                                                                Barang Servis</th>
                                                                                                            <td>{{ isset($services_item->service->jenis) ? $services_item->service->jenis : 'N/A' }}
                                                                                                                {{ isset($services_item->service->tipe) ? $services_item->service->tipe : 'N/A' }}
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="row">
                                                                                                                Kelengkapan</th>
                                                                                                            <td>{{ isset($services_item->service->kelengkapan) ? $services_item->service->kelengkapan : 'N/A' }}
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="row">
                                                                                                                Kerusakan</th>
                                                                                                            <td>{{ isset($services_item->kerusakan) ? $services_item->kerusakan : 'N/A' }}
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="row">
                                                                                                                Kondisi</th>
                                                                                                            <td>
                                                                                                                @if ($services_item->kondisi == 1)
                                                                                                                    <span
                                                                                                                        class="badge bg-success">{{ 'Sudah Jadi' }}</span>
                                                                                                                @elseif($services_item->kondisi == 2)
                                                                                                                    <span
                                                                                                                        class="badge bg-danger">{{ 'Tidak Bisa' }}</span>
                                                                                                                @elseif($services_item->kondisi == 3)
                                                                                                                    <span
                                                                                                                        class="badge bg-secondary">{{ 'Dibatalkan' }}</span>
                                                                                                                @endif
                                                                                                                -
                                                                                                                {{ \Carbon\Carbon::parse($services_item->service->date_done)->isoFormat('dddd, D MMMM Y HH:mm') }}
                                                                                                                WIB
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        {{-- Tindakan dan Modal --}}
                                                                                                        @if(isset($services_item->tindakan) && isset($services_item->modal))
                                                                                                            @php
                                                                                                                $tindakan = json_decode($services_item->tindakan, true);
                                                                                                                $modal = json_decode($services_item->modal);
                                                                                                                $totalModal = array_sum($modal);
                                                                                                            @endphp

                                                                                                            @if(count($tindakan) === 1)
                                                                                                                <tr>
                                                                                                                    <th scope="row">Tindakan</th>
                                                                                                                    <td>{{ $tindakan[0] }}</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <th scope="row">Modal</th>
                                                                                                                    <td>RP. {{ number_format($modal[0]) }}</td>
                                                                                                                </tr>
                                                                                                            @else
                                                                                                                <tr>
                                                                                                                    <td colspan="2">
                                                                                                                        <div class="accordion accordion-flush" id="accordionFlushShow">
                                                                                                                            <div class="accordion-item">
                                                                                                                                <h2 class="accordion-header" id="flush-headingOne">
                                                                                                                                    <a class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                                                                                                                                        Tindakan dan Modal
                                                                                                                                    </a>
                                                                                                                                </h2>
                                                                                                                                <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushShow">
                                                                                                                                    <div class="accordion-body">
                                                                                                                                        <table class="table table-striped mb-0">
                                                                                                                                            <thead class="table-dark">
                                                                                                                                                <tr>
                                                                                                                                                    <th scope="col">#</th>
                                                                                                                                                    <th scope="col">Tindakan</th>
                                                                                                                                                    <th scope="col">Modal</th>
                                                                                                                                                </tr>
                                                                                                                                            </thead>
                                                                                                                                            <tbody>
                                                                                                                                                @foreach($tindakan as $index => $item)
                                                                                                                                                    <tr>
                                                                                                                                                        <th scope="row">{{ $index + 1 }}</th>
                                                                                                                                                        <td>{{ $item }}</td>
                                                                                                                                                        <td>RP. {{ number_format($modal[$index]) }}</td>
                                                                                                                                                    </tr>
                                                                                                                                                @endforeach
                                                                                                                                            </tbody>
                                                                                                                                            <tfoot class="table-secondary">
                                                                                                                                                <tr>
                                                                                                                                                    <th colspan="2" scope="row" class="fw-bold">Total Modal</th>
                                                                                                                                                    <td>RP. {{ number_format($totalModal) }}</td>
                                                                                                                                                </tr>
                                                                                                                                            </tfoot>
                                                                                                                                        </table>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            @endif
                                                                                                        @else
                                                                                                            <tr>
                                                                                                                <td colspan="2">N/A</td>
                                                                                                            </tr>
                                                                                                        @endif
                                                                                                        {{-- End Tindakan dan Modal --}}
                                                                                                        
                                                                                                        <tr>
                                                                                                            <th scope="row">
                                                                                                                Biaya</th>
                                                                                                            <td>{{ isset($services_item->biaya) ? 'RP. ' . number_format($services_item->biaya) : 'N/A' }}
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        
                                                                                                        <tr>
                                                                                                            <th scope="row">
                                                                                                                Status</th>
                                                                                                            <td>
                                                                                                                @if ($services_item->service->status == 8)
                                                                                                                    <span
                                                                                                                        class="badge bg-primary">{{ 'Bisa Diambil' }}</span>
                                                                                                                @elseif($services_item->service->status == 11)
                                                                                                                    <span
                                                                                                                        class="badge bg-primary">{{ 'Garansi Bisa Diambil' }}</span>
                                                                                                                @endif
                                                                                                                - [Teknisi :
                                                                                                                {{ $services_item->service->teknisi_detail->name }}]
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                            {{-- end body non-garansi --}}
                                                                                        @endif
                                                                                        <div class="modal-footer">
                                                                                            <button type="button"
                                                                                                class="btn btn-secondary"
                                                                                                data-bs-dismiss="modal">Close</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            {{-- End Content Modal --}}
                                                                        </li>
                                                                        {{-- End Button Show --}}
                                                                    @endcan

                                                                    @can('service_detail_confirmation')
                                                                        {{-- Start Button Notif --}}
                                                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Konfirmasi Bisa Diambil Ke Pelanggan" class="disable-tooltip">

                                                                            <form action="service-detail/notification" method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="service_detail_id"
                                                                                    value="{{ $services_item->id }}">
                                                                                <button type="submit"
                                                                                    class="btn btn-sm btn-soft-warning">
                                                                                    <i class="mdi mdi-near-me"></i>
                                                                                </button>
                                                                            </form>
                                                                        </li>
                                                                        {{-- End Button Notif --}}
                                                                    @endcan

                                                                    @can('service_detail_delete')
                                                                        {{-- Start Button Delete --}}
                                                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data Transaksi" class="disable-tooltip">
                                                                            <a data-bs-toggle="modal"
                                                                                data-bs-target="#servicesDelete{{ $services_item->id }}"
                                                                                class="btn btn-sm btn-soft-danger">
                                                                                <i class="mdi mdi-delete-outline"></i>
                                                                            </a>
                                                                            <div class="modal fade"
                                                                                id="servicesDelete{{ $services_item->id }}"
                                                                                tabindex="-1"
                                                                                aria-labelledby="servicesDeleteLabel"
                                                                                aria-hidden="true">
                                                                                <div
                                                                                    class="modal-dialog modal-dialog-centered modal-sm">
                                                                                    <div class="modal-content">
                                                                                        <div
                                                                                            class="modal-body px-4 py-5 text-center">
                                                                                            <button type="button"
                                                                                                class="btn-close position-absolute end-0 top-0 m-3"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close"></button>
                                                                                            <div class="avatar-sm mb-4 mx-auto">
                                                                                                <div
                                                                                                    class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                                                                                                    <i
                                                                                                        class="mdi mdi-trash-can-outline"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <p
                                                                                                class="text-muted font-size-16 mb-4">
                                                                                                Anda yakin ingin menghapus data
                                                                                                pelanggan?</p>
                                                                                            <form
                                                                                                action="{{ route('backsite.service-detail.destroy', $services_item->id ?? '') }}"
                                                                                                method="POST">
                                                                                                @csrf
                                                                                                @method('DELETE')
                                                                                                <div
                                                                                                    class="hstack gap-2 justify-content-center mb-0">
                                                                                                    <button type="submit"
                                                                                                        class="btn btn-danger">Hapus</button>
                                                                                                    <button type="button"
                                                                                                        class="btn btn-secondary"
                                                                                                        data-bs-dismiss="modal">Tutup</button>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        {{-- End Button Delete --}}
                                                                    @endcan
                                                                </ul>
                                                            </td>
                                                            <td>
                                                                <ul class="list-unstyled hstack gap-1 mb-0">
                                                                    <div class="d-flex flex-column">
                                                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah
                                                                            {{ $services_item->service->kode_servis }} menjadi
                                                                            Proses Servis kembali." class="disable-tooltip">
                                                                            <button class="btn btn-sm btn-soft-danger mb-1"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#servisKembali{{ $services_item->id }}">
                                                                                Servis Ulang
                                                                            </button>
                                                                        </li>
                                                                        <div class="modal fade bs-example-modal-center" id="servisKembali{{ $services_item->id }}" tabindex="-1" aria-hidden="true" aria-labelledby="servisKembaliModalLabel" aria-expanded="false">
                                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="servisKembaliModalLabel">Konfirmasi Servis Ulang</h5>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <form class="form form-horizontal" action="{{ route('backsite.service-detail.reservice', $services_item->service_id) }}" method="POST">
                                                                                        @csrf
                                                                                            <div class="modal-body">
                                                                                                <p>Servis ulang kode servis <strong>{{ $services_item->service->kode_servis }}</strong>, dikarenakan sebelum barang diambil kondisinya rusak kembali.</p>
                                                                                                <div class="form-check d-flex justify-content-end gap-2 mt-4">
                                                                                                    <input class="form-check-input" type="checkbox" value="" id="servisKembaliCheckbox{{ $services_item->id }}" required>
                                                                                                    <label class="form-check-label" for="servisKembaliCheckbox{{ $services_item->id }}">Dengan ini saya, <span class="text-danger">{{ Auth::user()->name }}</span> setuju untuk dilakukan servis ulang.</label>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                                                <button type="submit" class="btn btn-primary">Servis Ulang</button>
                                                                                            </div>
                                                                                    </form>        
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        @can('service_detail_update')
                                                                        {{-- Button Sudah Diambil --}}
                                                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Status
                                                                            {{ $services_item->service->kode_servis }} menjadi
                                                                            Sudah Diambil" class="disable-tooltip">
                                                                            <button class="btn btn-sm btn-soft-success"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#sudahDiambil{{ $services_item->id }}">
                                                                                Sudah Diambil
                                                                            </button>
                                                                        </li>
                                                                        {{-- End Button Sudah Diambil --}}
                                                                        @endcan
                                                                        {{-- Start Modal Sudah Diambil --}}
                                                                        <form class="form form-horizontal"
                                                                            action="{{ $services_item->warranty_history?->status == 2 ? route('backsite.transaction.warranty') : route('backsite.transaction.store') }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <div class="modal fade bs-example-modal-center"
                                                                                id="sudahDiambil{{ $services_item->id }}"
                                                                                tabindex="-1" aria-hidden="true"
                                                                                aria-labelledby="bisaDiambilModalLabel">
                                                                                <div class="modal-dialog modal-dialog-scrollable"
                                                                                    role="document">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title">Ubah data
                                                                                                menjadi Sudah Diambil</h5>
                                                                                            <button type="button"
                                                                                                class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close"></button>
                                                                                        </div>
                                                                                        @if ($services_item->warranty_history?->status == 2)
                                                                                            {{-- start body garansi --}}
                                                                                            <div class="modal-body">
                                                                                                @if ($errors->any())
                                                                                                    <div class="alert alert-danger alert-dismissible fade show"
                                                                                                        role="alert">
                                                                                                        <ul>
                                                                                                            @foreach ($errors->all() as $error)
                                                                                                                <li>{{ $error }}
                                                                                                                </li>
                                                                                                            @endforeach
                                                                                                        </ul>
                                                                                                        <button type="button"
                                                                                                            class="btn-close"
                                                                                                            data-bs-dismiss="alert"
                                                                                                            aria-label="Close"></button>
                                                                                                    </div>
                                                                                                @endif
                                                                                                <input type="hidden"
                                                                                                    name="service_detail_id"
                                                                                                    value="{{ $services_item->id }}">

                                                                                                <div class="mb-2">
                                                                                                    <label for="customer_id"
                                                                                                        class="form-label">Pemilik
                                                                                                        Barang</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        disabled
                                                                                                        value="{{ $services_item->service->customer->name ?? '' }} - No.Telp {{ $services_item->service->customer->contact ?? '' }}">
                                                                                                </div>

                                                                                                <div class="mb-2">
                                                                                                    <label for="jenis"
                                                                                                        class="form-label">Nama
                                                                                                        Barang</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        disabled
                                                                                                        value="{{ $services_item->service->jenis ?? '' }} {{ $services_item->service->tipe ?? '' }}">
                                                                                                </div>

                                                                                                <div class="mb-2">
                                                                                                    <label for="kerusakan"
                                                                                                        class="form-label">Kerusakan
                                                                                                        Awal</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        disabled
                                                                                                        value="{{ $services_item->kerusakan ?? '' }}">
                                                                                                </div>

                                                                                                <div class="mb-2">
                                                                                                    <label for="tindakan"
                                                                                                        class="form-label">Tindakan
                                                                                                        Awal</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        disabled
                                                                                                        value="{{ isset($services_item->tindakan) ? implode(', ', json_decode($services_item->tindakan)) : '' }}"
                                                                                                        required>
                                                                                                </div>

                                                                                                <div class="mb-2">
                                                                                                    <label for="biaya"
                                                                                                        class="form-label">Biaya
                                                                                                        Sebelumnya</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        disabled
                                                                                                        value="{{ 'RP. ' . number_format($services_item->biaya) ?? '' }}"
                                                                                                        required>
                                                                                                </div>

                                                                                                <div class="mb-2">
                                                                                                    <label for="tindakan"
                                                                                                        class="form-label">Ket.
                                                                                                        Klaim</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        disabled
                                                                                                        value="{{ $services_item->warranty_history->keterangan ?? '' }}"
                                                                                                        required>
                                                                                                </div>

                                                                                                <div class="mb-2">
                                                                                                    <label for="tindakan"
                                                                                                        class="form-label">Tindakan</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        disabled
                                                                                                        value="{{ $services_item->warranty_history->tindakan ?? '' }}"
                                                                                                        required>
                                                                                                </div>

                                                                                                <div class="mb-2">
                                                                                                    <label for="catatan"
                                                                                                        class="form-label">Catatan</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        disabled
                                                                                                        value="{{ $services_item->warranty_history->catatan ?? '' }}"
                                                                                                        required>
                                                                                                </div>

                                                                                                <div class="mb-2">
                                                                                                    <label for="pengambil"
                                                                                                        class="form-label">Pengambil</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        name="pengambil"
                                                                                                        id="pengambil"
                                                                                                        placeholder="Nama Pengambil"
                                                                                                        required>
                                                                                                </div>

                                                                                                <div class="mb-4">
                                                                                                    <label for="penyerah"
                                                                                                        class="form-label">Penyerah</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        name="penyerah"
                                                                                                        id="penyerah"
                                                                                                        placeholder="Penyerah"
                                                                                                        value="{{ Auth::user()->name }}"
                                                                                                        disabled required>
                                                                                                </div>

                                                                                                <div class="form-check">
                                                                                                    <label class="form-check-label" for="send_notification">
                                                                                                        <input class="form-check-input" type="checkbox" id="send_notification" name="send_notification" value="1">
                                                                                                        Kirim Notifikasi
                                                                                                    </label>
                                                                                                    <p class="text-muted">Centang untuk mengirimkan notifikasi ke pelanggan</p>
                                                                                                </div>

                                                                                                <!-- Form Check -->
                                                                                                <div
                                                                                                    class="form-check d-flex justify-content-end gap-2 mt-4">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="checkbox"
                                                                                                        value=""
                                                                                                        id="sudahDiambilCheckbox{{ $services_item->id }}"
                                                                                                        required>
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="sudahDiambilCheckbox{{ $services_item->id }}">Dengan
                                                                                                        ini saya, <span
                                                                                                            class="text-danger">{{ Auth::user()->name }}</span>
                                                                                                        setuju mengubah Status
                                                                                                        menjadi Bisa
                                                                                                        Diambil</label>
                                                                                                </div>
                                                                                                <!-- End Form Check -->
                                                                                            </div>
                                                                                            {{-- end body garansi --}}
                                                                                        @else
                                                                                            {{-- start body non-garansi --}}
                                                                                            <div class="modal-body">
                                                                                                @if ($errors->any())
                                                                                                    <div class="alert alert-danger alert-dismissible fade show"
                                                                                                        role="alert">
                                                                                                        <ul>
                                                                                                            @foreach ($errors->all() as $error)
                                                                                                                <li>{{ $error }}
                                                                                                                </li>
                                                                                                            @endforeach
                                                                                                        </ul>
                                                                                                        <button type="button"
                                                                                                            class="btn-close"
                                                                                                            data-bs-dismiss="alert"
                                                                                                            aria-label="Close"></button>
                                                                                                    </div>
                                                                                                @endif
                                                                                                <input type="hidden"
                                                                                                    name="service_detail_id"
                                                                                                    value="{{ $services_item->id }}">

                                                                                                <div class="mb-2">
                                                                                                    <label for="customer_id"
                                                                                                        class="form-label">Pemilik
                                                                                                        Barang</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        disabled
                                                                                                        value="{{ $services_item->service->customer->name ?? '' }} - No.Telp {{ $services_item->service->customer->contact ?? '' }}">
                                                                                                </div>

                                                                                                <div class="mb-2">
                                                                                                    <label for="jenis"
                                                                                                        class="form-label">Nama
                                                                                                        Barang</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        disabled
                                                                                                        value="{{ $services_item->service->jenis ?? '' }} {{ $services_item->service->tipe ?? '' }}">
                                                                                                </div>

                                                                                                <div class="mb-2">
                                                                                                    <label for="kerusakan"
                                                                                                        class="form-label">Kerusakan</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        disabled
                                                                                                        value="{{ $services_item->kerusakan ?? '' }}">
                                                                                                </div>

                                                                                                <div class="mb-2">
                                                                                                    <label for="kondisi"
                                                                                                        class="form-label">Kondisi</label>
                                                                                                    <div class="form-group">
                                                                                                        @if ($services_item->kondisi == 1)
                                                                                                            <input
                                                                                                                type="text"
                                                                                                                name="kondisi"
                                                                                                                id="kondisi"
                                                                                                                class="form-control"
                                                                                                                disabled
                                                                                                                value="Sudah Jadi">
                                                                                                        @elseif($services_item->kondisi == 2)
                                                                                                            <input
                                                                                                                type="text"
                                                                                                                name="kondisi"
                                                                                                                id="kondisi"
                                                                                                                class="form-control"
                                                                                                                disabled
                                                                                                                value="Tidak Bisa">
                                                                                                        @elseif($services_item->kondisi == 3)
                                                                                                            <input
                                                                                                                type="text"
                                                                                                                name="kondisi"
                                                                                                                id="kondisi"
                                                                                                                class="form-control"
                                                                                                                disabled
                                                                                                                value="Dibatalkan">
                                                                                                        @else
                                                                                                            <input
                                                                                                                type="text"
                                                                                                                name="kondisi"
                                                                                                                id="kondisi"
                                                                                                                class="form-control"
                                                                                                                disabled
                                                                                                                value="{{ 'N/A' }}">
                                                                                                        @endif
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="mb-2">
                                                                                                    <label for="tindakan"
                                                                                                        class="form-label">Tindakan</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        disabled
                                                                                                        value="{{ isset($services_item->tindakan) ? implode(', ', json_decode($services_item->tindakan)) : '' }}"
                                                                                                        required>
                                                                                                </div>

                                                                                                <div class="mb-2">
                                                                                                    <label for="biaya"
                                                                                                        class="form-label">Biaya</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        disabled
                                                                                                        value="{{ 'RP. ' . number_format($services_item->biaya) ?? '' }}"
                                                                                                        required>
                                                                                                </div>

                                                                                                <div class="mb-2">
                                                                                                    <label for="pembayaran"
                                                                                                        class="form-label">Pembayaran</label>
                                                                                                    <select name="pembayaran"
                                                                                                        id="pembayaran"
                                                                                                        class="form-select"
                                                                                                        aria-label="Pembayaran"
                                                                                                        required>
                                                                                                        <option
                                                                                                            value="{{ '' }}"
                                                                                                            disabled selected>
                                                                                                            Pilih Pembayaran
                                                                                                        </option>
                                                                                                        <option
                                                                                                            value="Tidak Ada">
                                                                                                            Tidak Ada</option>
                                                                                                        <option value="Tunai">
                                                                                                            Tunai</option>
                                                                                                        <option
                                                                                                            value="Transfer">
                                                                                                            Transfer</option>
                                                                                                    </select>
                                                                                                </div>

                                                                                                <div class="mb-2">
                                                                                                    <label for="garansi"
                                                                                                        class="form-label">Garansi</label>
                                                                                                    <select name="garansi"
                                                                                                        id="garansi"
                                                                                                        class="form-select"
                                                                                                        aria-label="Garansi"
                                                                                                        required>
                                                                                                        <option
                                                                                                            value="{{ '' }}"
                                                                                                            disabled selected>
                                                                                                            Pilih Masa Garansi
                                                                                                        </option>
                                                                                                        <option value="0">
                                                                                                            Tidak Ada</option>
                                                                                                        <option value="1">
                                                                                                            1 Hari</option>
                                                                                                        <option value="3">
                                                                                                            3 Hari</option>
                                                                                                        <option value="7">
                                                                                                            1 Minggu</option>
                                                                                                        <option value="14">
                                                                                                            2 Minggu</option>
                                                                                                        <option value="30">
                                                                                                            1 Bulan</option>
                                                                                                    </select>
                                                                                                </div>

                                                                                                <div class="mb-2">
                                                                                                    <label for="pengambil"
                                                                                                        class="form-label">Pengambil</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        name="pengambil"
                                                                                                        id="pengambil"
                                                                                                        placeholder="Nama Pengambil"
                                                                                                        required>
                                                                                                </div>

                                                                                                <div class="mb-4">
                                                                                                    <label for="penyerah"
                                                                                                        class="form-label">Penyerah</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        name="penyerah"
                                                                                                        id="penyerah"
                                                                                                        placeholder="Penyerah"
                                                                                                        value="{{ Auth::user()->name }}"
                                                                                                        disabled required>
                                                                                                </div>

                                                                                                <div class="form-check">
                                                                                                    <label class="form-check-label" for="send_notification1">
                                                                                                        <input class="form-check-input" type="checkbox" id="send_notification1" name="send_notification" value="1">
                                                                                                        Kirim Notifikasi
                                                                                                    </label>
                                                                                                    <p class="text-muted">Centang untuk mengirimkan notifikasi ke pelanggan</p>
                                                                                                </div>

                                                                                                <!-- Form Check -->
                                                                                                <div
                                                                                                    class="form-check d-flex justify-content-end gap-2 mt-4">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="checkbox"
                                                                                                        value=""
                                                                                                        id="sudahDiambilCheckbox{{ $services_item->id }}"
                                                                                                        required>
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="sudahDiambilCheckbox{{ $services_item->id }}">Dengan
                                                                                                        ini saya, <span
                                                                                                            class="text-danger">{{ Auth::user()->name }}</span>
                                                                                                        setuju mengubah Status
                                                                                                        menjadi Bisa
                                                                                                        Diambil</label>
                                                                                                </div>
                                                                                                <!-- End Form Check -->
                                                                                            </div>
                                                                                            {{-- end body non-garansi --}}
                                                                                        @endif
                                                                                        <div class="modal-footer">
                                                                                            <button type="button"
                                                                                                class="btn btn-secondary"
                                                                                                data-bs-dismiss="modal">Batal</button>
                                                                                            <button type="submit"
                                                                                                class="btn btn-primary">Bisa
                                                                                                Diambil</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                        {{-- End Modal Sudah Diambil --}}
                                                                    </div>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        {{-- not found --}}
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Tabel Service --}}
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
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal Merubah Status Menjadi Sudah Diambil',
                text: 'Harap cek dan isi form dengan benar',
            });
        @endif
    </script>

    <script>
        $(document).on('shown.bs.modal', function() {
            $('.disable-tooltip').tooltip('dispose');
        });

        $(document).on('hidden.bs.modal', function() {
            $('.disable-tooltip').tooltip('enable');
        });
    </script>

    <script>
        $(document).ready(function() {
            // show all data on page load
            $("#service-detail tbody tr").show();

            // filter data when tab is clicked
            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                var target = $(e.target).attr("href"); // activated tab
                if (target == "#all") {
                    $("#service-detail tbody tr").show();
                } else {
                    $("#service-detail tbody tr").hide();
                    $("#service-detail tbody tr[data-condition='" + target.slice(1) + "']").show();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Panggil DataTables pada tabel
            $('#servicesTable').DataTable({
                "order": [
                    [1, "desc"]
                ], // Urutkan data berdasarkan tanggal (kolom 2) secara descending
                "language": {
                    "sEmptyTable": "Tidak ada data yang tersedia pada tabel",
                    "sInfo": "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                    "sInfoEmpty": "Menampilkan 0 hingga 0 dari 0 data",
                    "sInfoFiltered": "(disaring dari _MAX_ data keseluruhan)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ",",
                    "sLengthMenu": "Tampilkan _MENU_ data",
                    "sLoadingRecords": "Memuat...",
                    "sProcessing": "Sedang diproses...",
                    "sSearch": "Cari :",
                    "sZeroRecords": "Tidak ada data yang cocok ditemukan",
                    "oPaginate": {
                        "sFirst": "Pertama",
                        "sLast": "Terakhir",
                        "sNext": "Berikutnya",
                        "sPrevious": "Sebelumnya"
                    },
                },
            });
        });
    </script>
@endpush
