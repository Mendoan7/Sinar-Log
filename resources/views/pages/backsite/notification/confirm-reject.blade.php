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
                                <div class="card-header bg-danger bg-opacity-25">
                                    <div class="card-title m-0">
                                        <h5 class="fw-bolder text-danger m-0">Konfirmasi Servis Konsumen</h5>
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
                                            <span class="fw-bold fs-6">{{ $service->kerusakan }}</span>
                                        </dd>
                                    </dl>
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4 fw-bold text-muted">Tindakan</dt>
                                        <dd class="col-sm-8">
                                            <span class="fw-bold fs-6">{{ $service->estimasi_tindakan }}</span>
                                        </dd>
                                    </dl>
                                    <dl class="row mb-2">
                                        <dt class="col-sm-4 fw-bold text-muted">Estimasi Biaya</dt>
                                        <dd class="col-sm-8">
                                            <span class="fw-bold fs-6">{{ 'Rp. '.number_format($service->estimasi_biaya) ?? '' }}</span>
                                        </dd>
                                    </dl>
                                    <p>Pelanggan <span class="fw-bold">Tidak Setuju</span> dengan tindakan dan biaya servis yang akan dilakukan. Dan membatalkan proses servis.</p>
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
