@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')

<div class="main-content">
    <div class="page-content">
      <div class="container-fluid">

        <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="card mb-2 mb-xl-10">          
                                <div class="card-header bg-success bg-opacity-25">
                                    <div class="card-title m-0">
                                        <h5 class="fw-bolder text-success m-0">Konfirmasi Servis Konsumen</h5>
                                    </div>
                                </div>
                                
                                <div class="card-body p-9">
                                    <p>Kepada <span class="fw-bold">{{ $service->teknisi_detail->name }}</span>,</p>
                                    <p>Kami ingin memberitahumu bahwa pelanggan telah melakukan konfirmasi, untuk servis berikut :</p>
                                    
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4 fw-bold text-muted">Kode Servis</dt>
                                        <dd class="col-sm-8">
                                            <span class="fw-bold fs-6">{{ $service->kode_servis }}</span>
                                        </dd>
                                    </dl>
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4 fw-bold text-muted">Pemilik</dt>
                                        <dd class="col-sm-8">
                                            <span class="fw-bold fs-6">{{ $service->customer->name }}</span>
                                        </dd>
                                    </dl>
                                    <dl class="row mb-0">                                    
                                        <dt class="col-sm-4 fw-bold text-muted">Barang Servis</dt>
                                        <dd class="col-sm-8">
                                            <span class="fw-bold fs-6">{{ $service->jenis ?? '' }} {{ $service->tipe ?? '' }}</span>
                                        </dd>
                                    </dl>
                                    <dl class="row mb-2">
                                        <dt class="col-sm-4 fw-bold text-muted">Kerusakan</dt>
                                        <dd class="col-sm-8">
                                            <span class="fw-bold fs-6">{{ $service->service_detail->kerusakan }}</span>
                                        </dd>
                                    </dl>

                                    {{-- Estimasi Tindakan dan Biaya --}}
                                    <dl class="row mb-2">
                                        <dt class="col-sm-4 fw-bold text-muted">Estimasi Tindakan dan Biaya</dt>
                                        <dd class="col-sm-8">
                                            <span class="fw-bold fs-6">
                                            @if (count(json_decode($service->estimasi_tindakan)) === 1)
                                                {{ json_decode($service->estimasi_tindakan)[0] }} ({{ 'Rp. '.number_format(json_decode($service->estimasi_biaya)[0]) }})
                                            @else
                                                <ul class="list-unstyled">
                                                    @foreach (json_decode($service->estimasi_tindakan) as $index => $tindakan)
                                                        <li>{{ $tindakan }} ({{ 'Rp. '.number_format(json_decode($service->estimasi_biaya)[$index]) }})</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                            </span>
                                        </dd>
                                    </dl>
                                    @if (count(json_decode($service->estimasi_tindakan)) > 1)
                                        <dl class="row mb-2">
                                            <dt class="col-sm-4 fw-bold text-muted">Total Estimasi Biaya</dt>
                                            <dd class="col-sm-8">
                                                <span class="fw-bold fs-6">{{ 'Rp. '.number_format(array_sum(json_decode($service->estimasi_biaya))) }}</span>
                                            </dd>
                                        </dl>
                                    @endif
                                    {{-- End Estimasi Tindakan dan Biaya --}}
                                    
                                    <p>Pelanggan telah <span class="fw-bold">Setuju</span> dengan tindakan dan biaya servis yang akan dilakukan.</p>
                                    <p>Silahkan segera melakukan servis sesuai dengan kesepakatan dengan pelanggan. Terima kasih atas kerjasamanya.</p>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('backsite.notification.index') }}" class="btn btn-secondary">Kembali</a>
                                <a href="{{ route('backsite.service.index') }}" class="btn btn-primary">Daftar Servis</a>
                            </div>
                                
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
