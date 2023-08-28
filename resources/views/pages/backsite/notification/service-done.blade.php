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
                                        <h5 class="fw-bolder text-white m-0">Pesan Servis Selesai</h5>
                                    </div>
                                </div>
                                
                                <div class="card-body p-9">
                                    <p>Kepada Admin <span class="fw-bold">{{ Auth::user()->name }}</span>,</p>
                                    <p>Laporan pekerjaan telah selesai dikerjakan oleh Teknisi <span class="fw-bold">{{ $service->teknisi_detail->name }}</span></p>
                                    <p>Berikut detail perbaikan yang telah dilakukan :</p>
                                    
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
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4 fw-bold text-muted">Kondisi</dt>
                                        <dd class="col-sm-8">
                                            <span class="fw-bold fs-6">
                                                @if($service->service_detail->kondisi == 1)
                                                    <span class="badge bg-success">{{ 'Sudah Jadi' }}</span>
                                                @elseif($service->service_detail->kondisi == 2)
                                                    <span class="badge bg-danger">{{ 'Tidak Bisa' }}</span>
                                                @elseif($service->service_detail->kondisi == 3)
                                                    <span class="badge bg-secondary">{{ 'Dibatalkan' }}</span>   
                                                @endif
                                            </span>
                                        </dd>
                                    </dl>
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4 fw-bold text-muted">Tindakan</dt>
                                        <dd class="col-sm-8">
                                            <span class="fw-bold fs-6">
                                                @if(isset($service->service_detail->tindakan))
                                                    {{ implode(', ', json_decode($service->service_detail->tindakan)) }}
                                                @endif
                                            </span>
                                        </dd>
                                    </dl>
                                    <p>Terima Kasih. :)</p>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('backsite.notification.index') }}" class="btn btn-secondary">Kembali</a>
                                <a href="{{ route('backsite.service-detail.index') }}" class="btn btn-primary">Daftar Servis Bisa Diambil</a>
                            </div>
                                
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
