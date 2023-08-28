@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')

<div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <!-- start page title -->
        
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        

                        <div class="card mb-4 mb-xl-10">
                            
                            <div class="card-header">
                                <div class="card-title m-0">
                                    <h5 class="fw-bolder m-0">Pekerjaan Ulangan Servis</h5>
                                </div>
                            </div>
                            
                            <div class="card-body p-9">
                                <p>Kepada {{ $service->teknisi_detail->name }},</p>
                                <p>Kami ingin memberitahumu bahwa ada servis ulangan yang perlu kamu tangani.</p>
                                
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
                                    <dt class="col-sm-4 fw-bold text-muted">Tanggal Ambil</dt>
                                    <dd class="col-sm-8">
                                        <span class="fw-bold fs-6">{{ $service->date_out }}</span>
                                    </dd>
                                </dl>
                                <dl class="row mb-0">
                                    <dt class="col-sm-4 fw-bold text-muted">Kerusakan Awal</dt>
                                    <dd class="col-sm-8">
                                        <span class="fw-bold fs-6">{{ $service->service_detail->kerusakan }}</span>
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
                                <dl class="row mb-0">
                                    <dt class="col-sm-4 fw-bold text-muted">Garansi</dt>
                                    <dd class="col-sm-8">
                                        <span class="fw-bold fs-6">{{ $service->service_detail->garansi }} Hari</span>
                                    </dd>
                                </dl>
                                <dl class="row mb-0">
                                    <dt class="col-sm-4 fw-bold text-muted">Garansi Berakhir</dt>
                                    <dd class="col-sm-8">
                                        <span class="fw-bold fs-6">Yes</span>
                                    </dd>
                                </dl>
                                <dl class="row mb-2">
                                    <dt class="col-sm-4 fw-bold text-muted">Keterangan Klaim</dt>
                                    <dd class="col-sm-8">
                                        <span class="fw-bold fs-6">{{ $service->service_detail->warranty_history->keterangan }}</span>
                                    </dd>
                                </dl>
                                <p>Harap segera melakukan pengecekan dan tindakan yang diperlukan. Terima kasih atas kerjasamanya.</p>
                            </div>
                            
                        </div>
                        <a href="{{ route('backsite.notification.index') }}" class="btn btn-secondary">Kembali</a>
                        <a href="{{ route('backsite.service.index') }}" class="btn btn-primary">Daftar Servis</a>
                        
                    </div>
                </div>
            </div>    
        </div>

        </div>
    </div>
</div>

@endsection