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

                            <div class="card mb-4 mb-xl-10">          
                                <div class="card-header bg-primary">
                                    <div class="card-title m-0">
                                        <h5 class="fw-bolder text-white m-0">Pekerjaan Servis Baru</h5>
                                    </div>
                                </div>
                                
                                <div class="card-body p-9">
                                    <p>Kepada <span class="fw-bold">{{ $service->teknisi_detail->name }}</span>,</p>
                                    <p>Kami ingin memberitahumu bahwa ada pekerjaan servis baru yang perlu segera kamu tangani. Berikut informasi lengkap :</p>
                                    
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
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4 fw-bold text-muted">Kerusakan</dt>
                                        <dd class="col-sm-8">
                                            <span class="fw-bold fs-6">{{ $service->service_detail->kerusakan }}</span>
                                        </dd>
                                    </dl>
                                    <dl class="row mb-3">
                                        <dt class="col-sm-4 fw-bold text-muted">Status</dt>
                                        <dd class="col-sm-8">
                                            @if($service->status == 1)
                                                <span class="badge bg-secondary">{{ 'Belum Cek' }}</span>
                                            @elseif($service->status == 2)
                                                <span class="badge bg-info">{{ 'Akan Dikerjakan' }}</span>
                                            @elseif($service->status == 3)
                                                <span class="badge bg-info">{{ 'Sedang Cek' }}</span>
                                            @elseif($service->status == 4)
                                                <span class="badge bg-success">{{ 'Sedang Dikerjakan' }}</span>
                                            @elseif($service->status == 5)
                                                <span class="badge bg-warning">{{ 'Sedang Tes' }}</span>
                                            @elseif($service->status == 6)
                                                <span class="badge bg-danger">{{ 'Menunggu Konfirmasi' }}</span>
                                            @elseif($service->status == 7)
                                                <span class="badge bg-primary">{{ 'Menunggu Sparepart' }}</span>    
                                            @endif
                                        </dd>
                                    </dl>
                                    <p>Harap segera dilakukan pengecekan dan berikan tindakan yang terbaik. Terima kasih atas kerjasamanya.</p>
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
