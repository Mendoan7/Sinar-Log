@extends('layouts.app')

@section('title', 'Servis Selesai')

@section('content')

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body border-bottom">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 card-title flex-grow-1">Sudah Diambil</h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-tabs-custom">
                                <li class="nav-item">
                                    <a class="nav-link{{ !request('status') ? ' active' : '' }}" href="{{ route('backsite.transaction.index') }}">
                                        Semua <span class="badge bg-primary ms-1">{{ $all_count }}</span>
                                    </a>
                                </li>
                                <li class="nav-item dropdown d-md-none">
                                    <a class="nav-link dropdown-toggle{{ request('status') === 'done' ? ' active' : '' }}" href="#" id="statusDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Status <i class="mdi mdi-chevron-down"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                                        <li>
                                            <a class="dropdown-item{{ request('status') === 'done' ? ' active' : '' }}" href="{{ route('backsite.transaction.index', ['status' => 'done']) }}">
                                                Sudah Jadi <span class="badge bg-success ms-1">{{ $done_count }}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item{{ request('status') === 'notdone' ? ' active' : '' }}" href="{{ route('backsite.transaction.index', ['status' => 'notdone']) }}">
                                                Tidak Bisa <span class="badge bg-danger ms-1">{{ $notdone_count }}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item{{ request('status') === 'cancel' ? ' active' : '' }}" href="{{ route('backsite.transaction.index', ['status' => 'cancel']) }}">
                                                Dibatalkan <span class="badge bg-secondary ms-1">{{ $cancel_count }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link{{ request('status') === 'done' ? ' active' : '' }}" href="{{ route('backsite.transaction.index', ['status' => 'done']) }}">
                                        Sudah Jadi <span class="badge bg-success ms-1">{{ $done_count }}</span>
                                    </a>
                                </li>
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link{{ request('status') === 'notdone' ? ' active' : '' }}" href="{{ route('backsite.transaction.index', ['status' => 'notdone']) }}">
                                        Tidak Bisa <span class="badge bg-danger ms-1">{{ $notdone_count }}</span>
                                    </a>
                                </li>
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link{{ request('status') === 'cancel' ? ' active' : '' }}" href="{{ route('backsite.transaction.index', ['status' => 'cancel']) }}">
                                        Dibatalkan <span class="badge bg-secondary ms-1">{{ $cancel_count }}</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- End nav tabs -->
                        </div>

                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-responsive">
                                    <table id="transactionTable" class="table table-bordered table-striped mb-0 table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">No. Servis</th>
                                                <th scope="col">Tgl. Ambil</th>
                                                <th scope="col">Pemilik</th>
                                                <th scope="col">Barang</th>
                                                <th scope="col">Kerusakan</th>
                                                <th scope="col">Kondisi</th>
                                                <th scope="col">Biaya</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Aksi</th>
                                                <th scope="col">Ubah Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($transactions as $key => $transaction_item)
                                                <tr data-entry-id="{{ $transaction_item->id }}">
                                                    @if ($transaction_item->warranty_history?->status == 3)
                                                        <th scope="row" class="text-body fw-bold">{{ $transaction_item->service_detail->service->kode_servis ?? '' }}</th>
                                                        <td>{{ $transaction_item->warranty_history->updated_at->isoFormat('D MMM Y') }}</td>
                                                        <input type="hidden" class="updated_at" value="{{ $transaction_item->warranty_history->updated_at }}">
                                                        <td class="text-body fw-bold">{{ $transaction_item->service_detail->service->customer->name ?? '' }}</td>
                                                        <td>{{ $transaction_item->service_detail->service->jenis ?? '' }} {{ $transaction_item->service_detail->service->tipe ?? '' }}</td>
                                                        <td>{{ $transaction_item->warranty_history->keterangan ?? '' }}</td>
                                                        <td>
                                                            @if($transaction_item->warranty_history->kondisi == 1)
                                                                <span class="badge bg-success">{{ 'Sudah Jadi' }}</span>
                                                            @elseif($transaction_item->warranty_history->kondisi == 2)
                                                                <span class="badge bg-danger">{{ 'Tidak Bisa' }}</span>
                                                            @elseif($transaction_item->warranty_history->kondisi == 3)
                                                                <span class="badge bg-secondary">{{ 'Dibatalkan' }}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ 'RP. '.number_format($transaction_item->service_detail->biaya) ?? '' }}</td>
                                                        <td>
                                                            @if($transaction_item->warranty_history->status == 2)
                                                                <span class="badge bg-primary">{{ 'Garansi Bisa Diambil' }}</span>
                                                            @elseif($transaction_item->warranty_history->status == 3)
                                                                <span class="badge bg-success">{{ 'Sudah Diambil' }}</span>
                                                            @else
                                                                <span>{{ 'N/A' }}</span>
                                                            @endif
                                                        </td>
                                                    @else
                                                        <th scope="row" class="text-body fw-bold">{{ $transaction_item->service_detail->service->kode_servis ?? '' }}</th>
                                                        <td>{{ ($transaction_item['created_at'])->isoFormat('D MMM Y') }}</td>
                                                        <input type="hidden" class="created_at" value="{{ $transaction_item->created_at }}">
                                                        <td class="text-body fw-bold">{{ $transaction_item->service_detail->service->customer->name ?? '' }}</td>
                                                        <td>{{ $transaction_item->service_detail->service->jenis ?? '' }} {{ $transaction_item->service_detail->service->tipe ?? '' }}</td>
                                                        <td>{{ $transaction_item->service_detail->service->kerusakan ?? '' }}</td>
                                                        <td>
                                                            @if($transaction_item->service_detail->kondisi == 1)
                                                                <span class="badge bg-success">{{ 'Sudah Jadi' }}</span>
                                                            @elseif($transaction_item->service_detail->kondisi == 2)
                                                                <span class="badge bg-danger">{{ 'Tidak Bisa' }}</span>
                                                            @elseif($transaction_item->service_detail->kondisi == 3)
                                                                <span class="badge bg-secondary">{{ 'Dibatalkan' }}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ 'RP. '.number_format($transaction_item->service_detail->biaya) ?? '' }}</td>
                                                        <td>
                                                            @if($transaction_item->service_detail->service->status == 8)
                                                                <span class="badge bg-primary">{{ 'Bisa Diambil' }}</span>
                                                            @elseif($transaction_item->service_detail->service->status == 9)
                                                                <span class="badge bg-success">{{ 'Sudah Diambil' }}</span>
                                                            @else
                                                                <span>{{ 'N/A' }}</span>
                                                            @endif
                                                        </td>
                                                    @endif
                                                    <td>
                                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                                            {{-- Start Button View --}}
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Servis">
                                                                <button class="btn btn-sm btn-soft-primary" 
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#show{{ $transaction_item->id }}">
                                                                        <i class="mdi mdi-eye-outline"></i>
                                                                </button>
                                                                <div class="modal fade bs-example-modal-center" id="show{{ $transaction_item->id }}" tabindex="-1" aria-hidden="true" aria-labelledby="showTransactionModalLabel" aria-expanded="false">
                                                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="showTransactionModalLabel">Detail Servis</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>

                                                                            @if ($transaction_item->warranty_history?->status == 3)
                                                                                {{-- Start Body Garansi --}}
                                                                                <div class="modal-body">
                                                                                    <table class="table table-striped">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <th scope="col">No. Servis</th>
                                                                                                <td scope="col"><span class="fw-bold">{{ isset($transaction_item->service_detail->service->kode_servis) ? $transaction_item->service_detail->service->kode_servis : 'N/A' }}</span></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Tgl. Masuk</th>
                                                                                                <td>{{ $transaction_item->service_detail->service['created_at']->isoFormat('dddd, D MMMM Y HH:mm')}} WIB
                                                                                                    [{{ isset($transaction_item->service_detail->service->penerima) ? $transaction_item->service_detail->service->penerima : 'N/A' }}]</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Pemilik</th>
                                                                                                <td>{{ isset($transaction_item->service_detail->service->customer->name) ? $transaction_item->service_detail->service->customer->name : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Barang Servis</th>
                                                                                                <td>{{ isset($transaction_item->service_detail->service->jenis) ? $transaction_item->service_detail->service->jenis : 'N/A' }}
                                                                                                    {{ isset($transaction_item->service_detail->service->tipe) ? $transaction_item->service_detail->service->tipe : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Kelengkapan</th>
                                                                                                <td>{{ isset($transaction_item->service_detail->service->kelengkapan) ? $transaction_item->service_detail->service->kelengkapan : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Kerusakan</th>
                                                                                                <td>{{ isset($transaction_item->service_detail->service->kerusakan) ? $transaction_item->service_detail->service->kerusakan : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Kondisi</th>
                                                                                                <td>@if($transaction_item->service_detail->kondisi == 1)
                                                                                                        <span class="badge bg-success">{{ 'Sudah Jadi' }}</span>
                                                                                                    @elseif($transaction_item->service_detail->kondisi == 2)
                                                                                                        <span class="badge bg-danger">{{ 'Tidak Bisa' }}</span>
                                                                                                    @elseif($transaction_item->service_detail->kondisi == 3)
                                                                                                        <span class="badge bg-secondary">{{ 'Dibatalkan' }}</span>   
                                                                                                    @endif
                                                                                                    - {{ $transaction_item->service_detail['updated_at']->isoFormat('dddd, D MMMM Y HH:mm')}} WIB
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Tindakan</th>
                                                                                                <td>{{ isset($transaction_item->service_detail->tindakan) ? $transaction_item->service_detail->tindakan : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Modal</th>
                                                                                                <td>{{ isset($transaction_item->service_detail->modal) ? 'RP. '.number_format($transaction_item->service_detail->modal) : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Biaya</th>
                                                                                                <td><span class="fw-bold">{{ isset($transaction_item->service_detail->biaya) ? 'RP. '.number_format($transaction_item->service_detail->biaya) : 'N/A' }}</span></td>
                                                                                            </tr>
                                                                                            <tr class="table-info">
                                                                                                <th colspan="2" class="text-center fw-bold">Detail Garansi</th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Tanggal Klaim</th>
                                                                                                <td>{{ $transaction_item->warranty_history->created_at->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Ket. Klaim</th>
                                                                                                <td>{{ $transaction_item->warranty_history->keterangan }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Kondisi</th>
                                                                                                <td>@if($transaction_item->warranty_history->kondisi == 1)
                                                                                                        <span class="badge bg-success">{{ 'Sudah Jadi' }}</span>
                                                                                                    @elseif($transaction_item->warranty_history->kondisi == 2)
                                                                                                        <span class="badge bg-danger">{{ 'Tidak Bisa' }}</span>
                                                                                                    @elseif($transaction_item->warranty_history->kondisi == 3)
                                                                                                        <span class="badge bg-secondary">{{ 'Dibatalkan' }}</span>   
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>   
                                                                                            <tr>
                                                                                                <th scope="row">Tindakan</th>
                                                                                                <td>{{ $transaction_item->warranty_history->tindakan }}</td>
                                                                                            </tr> 
                                                                                            <tr>
                                                                                                <th scope="row">Catatan</th>
                                                                                                <td>{{ $transaction_item->warranty_history->catatan }}</td>
                                                                                            </tr>                                           
                                                                                            <tr>
                                                                                                <th scope="row">Status</th>
                                                                                                <td>
                                                                                                    @if($transaction_item->warranty_history->status == 2)
                                                                                                        <span class="badge bg-secondary">{{ 'Garansi Bisa Diambil' }}</span>
                                                                                                    @elseif($transaction_item->warranty_history->status == 3)
                                                                                                        <span class="badge bg-warning">{{ 'Garansi Sudah Diambil' }}</span>    
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Tgl. Ambil</th>
                                                                                                <td>
                                                                                                    {{ $transaction_item->warranty_history['updated_at']->isoFormat('dddd, D MMMM Y HH:mm') }} WIB
                                                                                                    [{{ isset($transaction_item->warranty_history->penyerah) ? $transaction_item->warranty_history->penyerah : 'N/A' }}]
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Pengambil</th>
                                                                                                <td>{{ isset($transaction_item->warranty_history->pengambil) ? $transaction_item->warranty_history->pengambil : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Garansi</th>
                                                                                                @if ($transaction_item->garansi == 0)
                                                                                                    <td class="fw-bold">Tidak Ada</td>
                                                                                                @else
                                                                                                    <td class="fw-bold">{{ $transaction_item->garansi }} Hari</td>
                                                                                                @endif
                                                                                            </tr>
                                                                                            @if ($transaction_item->garansi > 0)
                                                                                                <tr>
                                                                                                    <th scope="row">Garansi Berakhir</th>
                                                                                                    <td>{{ $warrantyInfo[$transaction_item->id]['end_warranty']->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th scope="row">Status Garansi</th>
                                                                                                    @if ($warrantyInfo[$transaction_item->id]['end_warranty'] < now())
                                                                                                        <td><span class="badge bg-danger">Hangus</span></td>
                                                                                                    @else
                                                                                                        <td>Tersisa {{ $warrantyInfo[$transaction_item->id]['sisa_warranty'] }}</td>
                                                                                                    @endif
                                                                                                </tr>
                                                                                            @endif 
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                                {{-- End Body Garansi --}}
                                                                            @else
                                                                                {{-- Start Body Non-Garansi --}}
                                                                                <div class="modal-body">
                                                                                    <table class="table table-striped">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <th scope="col">No. Servis</th>
                                                                                                <td scope="col"><span class="fw-bold">{{ isset($transaction_item->service_detail->service->kode_servis) ? $transaction_item->service_detail->service->kode_servis : 'N/A' }}</span></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Tgl. Masuk</th>
                                                                                                <td>{{ $transaction_item->service_detail->service['created_at']->isoFormat('dddd, D MMMM Y HH:mm')}} WIB
                                                                                                    [{{ isset($transaction_item->service_detail->service->penerima) ? $transaction_item->service_detail->service->penerima : 'N/A' }}]</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Pemilik</th>
                                                                                                <td>{{ isset($transaction_item->service_detail->service->customer->name) ? $transaction_item->service_detail->service->customer->name : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Barang Servis</th>
                                                                                                <td>{{ isset($transaction_item->service_detail->service->jenis) ? $transaction_item->service_detail->service->jenis : 'N/A' }}
                                                                                                    {{ isset($transaction_item->service_detail->service->tipe) ? $transaction_item->service_detail->service->tipe : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Kelengkapan</th>
                                                                                                <td>{{ isset($transaction_item->service_detail->service->kelengkapan) ? $transaction_item->service_detail->service->kelengkapan : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Kerusakan</th>
                                                                                                <td>{{ isset($transaction_item->service_detail->service->kerusakan) ? $transaction_item->service_detail->service->kerusakan : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Kondisi</th>
                                                                                                <td>@if($transaction_item->service_detail->kondisi == 1)
                                                                                                    <span class="badge bg-success">{{ 'Sudah Jadi' }}</span>
                                                                                                @elseif($transaction_item->service_detail->kondisi == 2)
                                                                                                    <span class="badge bg-danger">{{ 'Tidak Bisa' }}</span>
                                                                                                @elseif($transaction_item->service_detail->kondisi == 3)
                                                                                                    <span class="badge bg-secondary">{{ 'Dibatalkan' }}</span>   
                                                                                                @endif
                                                                                                - {{ $transaction_item->service_detail['updated_at']->isoFormat('dddd, D MMMM Y HH:mm')}} WIB
                                                                                            </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Tindakan</th>
                                                                                                <td>{{ isset($transaction_item->service_detail->tindakan) ? $transaction_item->service_detail->tindakan : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Modal</th>
                                                                                                <td>{{ isset($transaction_item->service_detail->modal) ? 'RP. '.number_format($transaction_item->service_detail->modal) : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Biaya</th>
                                                                                                <td><span class="fw-bold">{{ isset($transaction_item->service_detail->biaya) ? 'RP. '.number_format($transaction_item->service_detail->biaya) : 'N/A' }}</span></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Teknisi</th>
                                                                                                <td>{{ isset($transaction_item->service_detail->service->teknisi_detail->name) ? $transaction_item->service_detail->service->teknisi_detail->name : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr class="table-success">
                                                                                                <th scope="row">Status</th>
                                                                                                <td>
                                                                                                    @if($transaction_item->service_detail->service->status == 8)
                                                                                                        <span class="badge bg-primary">{{ 'Bisa Diambil' }}</span>
                                                                                                    @elseif($transaction_item->service_detail->service->status == 9)
                                                                                                        <span class="badge bg-success">{{ 'Sudah Diambil' }}</span>
                                                                                                    @else
                                                                                                        <span>{{ 'N/A' }}</span>
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Tgl. Ambil</th>
                                                                                                <td>
                                                                                                    {{ $transaction_item['updated_at']->isoFormat('dddd, D MMMM Y HH:mm') }} WIB
                                                                                                    [{{ isset($transaction_item->penyerah) ? $transaction_item->penyerah : 'N/A' }}]
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Pengambil</th>
                                                                                                <td>{{ isset($transaction_item->pengambil) ? $transaction_item->pengambil : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Pembayaran</th>
                                                                                                <td>{{ isset($transaction_item->pembayaran) ? $transaction_item->pembayaran : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Garansi</th>
                                                                                                @if ($transaction_item->garansi == 0)
                                                                                                    <td class="fw-bold">Tidak Ada</td>
                                                                                                @else
                                                                                                    <td class="fw-bold">{{ $transaction_item->garansi }} Hari</td>
                                                                                                @endif
                                                                                            </tr>
                                                                                            @if ($transaction_item->garansi > 0)
                                                                                                <tr>
                                                                                                    <th scope="row">Garansi Berakhir</th>
                                                                                                    <td>{{ $warrantyInfo[$transaction_item->id]['end_warranty']->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th scope="row">Status Garansi</th>
                                                                                                    @if ($warrantyInfo[$transaction_item->id]['end_warranty'] < now())
                                                                                                        <td><span class="badge bg-danger">Hangus</span></td>
                                                                                                    @else
                                                                                                        <td>Tersisa {{ $warrantyInfo[$transaction_item->id]['sisa_warranty'] }}</td>
                                                                                                    @endif
                                                                                                </tr>
                                                                                            @endif
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                                {{-- End Body Non-Garansi --}}
                                                                            @endif

                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                            </div>        
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            {{-- End Button View  --}}

                                                            {{-- Start Button Confirm --}}
                                                            <form action="transaction/notification" method="POST">
                                                                @csrf
                                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="Konfirmasi Sudah Diambil Ke Pelanggan">               
                                                                    <input type="hidden" name="transaction_id" value="{{ $transaction_item->id }}">
                                                                    <button type="submit" class="btn btn-sm btn-soft-warning">
                                                                        <i class="mdi mdi-near-me"></i>
                                                                    </button>
                                                                </li>
                                                            </form>
                                                            {{-- End Button Confirm --}}

                                                            {{-- Start Button Delete --}}
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data Transaksi">
                                                                <a  data-bs-toggle="modal"
                                                                    data-bs-target="#transactionDelete{{ $transaction_item->id }}" 
                                                                    class="btn btn-sm btn-soft-danger">
                                                                    <i class="mdi mdi-delete-outline"></i>
                                                                </a>
                                                                <div class="modal fade" id="transactionDelete{{ $transaction_item->id }}" tabindex="-1" aria-labelledby="transactionDeleteLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                                                        <div class="modal-content">
                                                                            <div class="modal-body px-4 py-5 text-center">
                                                                                <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                <div class="avatar-sm mb-4 mx-auto">
                                                                                    <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                                                                                        <i class="mdi mdi-trash-can-outline"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-muted font-size-16 mb-4">Anda yakin ingin menghapus data transaksi?</p>
                                                                                <form action="{{ route('backsite.transaction.destroy', $transaction_item->id ?? '') }}" method="POST">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <div class="hstack gap-2 justify-content-center mb-0">
                                                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            {{-- End Button Delete --}}
                                                        </ul>
                                                    </td>

                                                    <td>
                                                        {{-- Start Button Status --}}
                                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $transaction_item->garansi == 0 ? 'Tidak ada garansi' : ($warrantyInfo[$transaction_item->id]['end_warranty'] < now() ? 'Garansi hangus' : 'Menerima Garansi') }}">
                                                                @if ($transaction_item->garansi > 0)
                                                                    <button class="btn btn-sm {{ $warrantyInfo[$transaction_item->id]['end_warranty'] < now() ? 'btn-soft-primary' : 'btn-primary' }}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#garansi{{ $transaction_item->id }}">
                                                                        Garansi
                                                                    </button>
                                                                @else
                                                                    <button class="btn btn-sm btn-secondary" disabled>
                                                                        Garansi
                                                                    </button>
                                                                @endif
                                                                <div class="modal fade bs-example-modal-center" id="garansi{{ $transaction_item->id }}" tabindex="-1" aria-hidden="true" aria-labelledby="garansiModalLabel">
                                                                    <form class="form form-horizontal" action="{{ route('backsite.transaction.claimWarranty') }}" method="POST">
                                                                        @csrf
                                                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="garansiModalLabel">Konfirmasi Terima Garansi</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name="transaction_id" value="{{ $transaction_item->id }}">
                                                                                <p>Pastikan kerusakan pada saat menerima garansi, sama dengan kerusakan awal servis.</p>
                                                                                <table class="table table-striped">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <th scope="col">No. Servis</th>
                                                                                            <td scope="col" class="fw-bold">{{ isset($transaction_item->service_detail->service->kode_servis) ? $transaction_item->service_detail->service->kode_servis : 'N/A' }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Barang Servis</th>
                                                                                            <td>{{ isset($transaction_item->service_detail->service->jenis) ? $transaction_item->service_detail->service->jenis : 'N/A' }}
                                                                                                {{ isset($transaction_item->service_detail->service->tipe) ? $transaction_item->service_detail->service->tipe : 'N/A' }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Teknisi</th>
                                                                                            <td>{{ isset($transaction_item->service_detail->service->teknisi_detail->name) ? $transaction_item->service_detail->service->teknisi_detail->name : 'N/A' }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Tgl. Ambil</th>
                                                                                            <td>
                                                                                                {{ $transaction_item['updated_at']->isoFormat('dddd, D MMMM Y HH:mm') }} WIB
                                                                                                [{{ isset($transaction_item->penyerah) ? $transaction_item->penyerah : 'N/A' }}]
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Pengambil</th>
                                                                                            <td>{{ isset($transaction_item->pengambil) ? $transaction_item->pengambil : 'N/A' }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Kerusakan Awal</th>
                                                                                            <td>{{ isset($transaction_item->service_detail->service->kerusakan) ? $transaction_item->service_detail->service->kerusakan : 'N/A' }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Tindakan</th>
                                                                                            <td>{{ isset($transaction_item->service_detail->tindakan) ? $transaction_item->service_detail->tindakan : 'N/A' }}</td>
                                                                                        </tr>                                                                                      
                                                                                        <tr>
                                                                                            <th scope="row">Garansi</th>
                                                                                            @if ($transaction_item->garansi == 0)
                                                                                                <td class="fw-bold">Tidak Ada</td>
                                                                                            @else
                                                                                                <td class="fw-bold">{{ $transaction_item->garansi }} Hari</td>
                                                                                            @endif
                                                                                        </tr>
                                                                                        @if ($transaction_item->garansi > 0)
                                                                                            <tr>
                                                                                                <th scope="row">Garansi Berakhir</th>
                                                                                                <td>{{ $warrantyInfo[$transaction_item->id]['end_warranty']->isoFormat('dddd, D MMMM Y HH:mm') }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row">Status Garansi</th>
                                                                                                @if ($warrantyInfo[$transaction_item->id]['end_warranty'] < now())
                                                                                                    <td><span class="badge bg-danger">Hangus</span></td>
                                                                                                @else
                                                                                                    <td>Tersisa {{ $warrantyInfo[$transaction_item->id]['sisa_warranty'] }}</td>
                                                                                                @endif
                                                                                            </tr>
                                                                                        @endif
                                                                                        <tr>
                                                                                            <th scope="row">Keterangan</th>
                                                                                            <td>
                                                                                                <textarea type="text" id="keterangan" name="keterangan" placeholder="Keterangan claim garansi" value="{{old('keterangan')}}" class="form-control"></textarea>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>

                                                                                <!-- Form Check -->
                                                                                <div class="form-check d-flex justify-content-end gap-2 mt-4">
                                                                                    <input class="form-check-input" type="checkbox" value="" id="garansiCheckbox{{ $transaction_item->id }}" required>
                                                                                    <label class="form-check-label" for="garansiCheckbox{{ $transaction_item->id }}">Dengan ini saya, <span class="text-danger">{{ Auth::user()->name }}</span> setuju menerima Garansi Servis</label>
                                                                                </div>
                                                                                <!-- End Form Check -->
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                                <button type="submit" class="btn btn-primary">Terima Garansi</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    </form>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        {{-- End Button Status --}}
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
            // Panggil DataTables pada tabel
            $('#transactionTable').DataTable({
                "order": [[ 1, "desc" ]], // Urutkan data berdasarkan tanggal (kolom 2) secara descending
                "language": {
                    "sEmptyTable":      "Tidak ada data yang tersedia pada tabel",
                    "sInfo":            "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                    "sInfoEmpty":       "Menampilkan 0 hingga 0 dari 0 data",
                    "sInfoFiltered":    "(disaring dari _MAX_ data keseluruhan)",
                    "sInfoPostFix":     "",
                    "sInfoThousands":   ",",
                    "sLengthMenu":      "Tampilkan _MENU_ data",
                    "sLoadingRecords":  "Memuat...",
                    "sProcessing":      "Sedang diproses...",
                    "sSearch":          "Cari :",
                    "sZeroRecords":     "Tidak ada data yang cocok ditemukan",
                    "oPaginate": {
                        "sFirst":       "Pertama",
                        "sLast":        "Terakhir",
                        "sNext":        "Berikutnya",
                        "sPrevious":    "Sebelumnya"
                    },
                }
            });
        });
    </script>
@endpush