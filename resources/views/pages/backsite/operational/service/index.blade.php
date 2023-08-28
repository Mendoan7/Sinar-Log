@extends('layouts.app')

@section('title', 'Servis')

@section('content')

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
 
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body border-bottom">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 card-title flex-grow-1">Proses Servis</h5>
                                @can('service_create')
                                {{-- Button Add Service --}}
                                <div class="flex-shrink-0">
                                    <button class="btn btn-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#addServiceModal">
                                            Servis Baru
                                    </button>
                                </div>
                                {{-- End Button Add Service --}}
                                @endcan
                                
                                {{-- Add Service Modal --}}
                                <form class="form form-horizontal" action="{{ route('backsite.service.store') }}" method="POST">
                                    @csrf
                                    <div class="modal fade bs-example-modal-center" id="addServiceModal" tabindex="-1" aria-hidden="true" aria-labelledby="addServiceModalLabel">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah Data Servis Baru</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if ($errors->any())
                                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                            <div>
                                                                @foreach ($errors->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach
                                                            </div>
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>
                                                    @endif
                                                    <div class="mb-2">
                                                        <label for="customer_id" class="form-label">Pemilik Barang</label>
                                                        <select class="form-control select2" 
                                                            data-placeholder="Pilih Pemilik Barang" 
                                                            title="customer_id" 
                                                            name="customer_id" 
                                                            id="customer_id" required>
                                                            <option value="{{ '' }}" disabled selected>Pilih Pemilik Barang</option>
                                                                @foreach($customer as $key => $customer_item)
                                                                    <option value="{{ $customer_item->id }}">{{ $customer_item->name }} - No.Telepon {{ $customer_item->contact }}</option>
                                                                @endforeach
                                                        </select>  
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="jenis" class="form-label">Jenis Barang</label>
                                                        <input type="text" class="form-control @error('jenis') is-invalid @enderror" list="jenisOption" name="jenis" id="jenis" placeholder="Jenis barang">
                                                            <datalist id="jenisOption">
                                                                <option value="HP">
                                                                <option value="Tablet">
                                                                <option value="Notebook">
                                                                <option value="Laptop">
                                                                <option value="Powerbank">
                                                            </datalist>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="tipe" class="form-label">Tipe/Merek</label>
                                                        <input type="text" class="form-control @error('tipe') is-invalid @enderror" name="tipe" id="tipe" placeholder="Tipe barang yang di servis" required>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="kelengkapan" class="form-label">Kelengkapan</label>
                                                        <input type="text" class="form-control @error('kelengkapan') is-invalid @enderror" list="kelengkapanOption" name="kelengkapan" id="kelengkapan" placeholder="Isi kelengkapan barang yang diterima" required>
                                                            <datalist id="kelengkapanOption">
                                                                <option value="Unit Only">
                                                                <option value="Unit, Simcard, dan MicroSD">
                                                                <option value="Unit dan Simcard">
                                                            </datalist>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="kerusakan" class="form-label">Kerusakan</label>
                                                        <input type="text" class="form-control @error('kerusakan') is-invalid @enderror" name="kerusakan" id="kerusakan" placeholder="Silahkan isi kerusakan barang" required>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="penerima" class="form-label">Penerima</label>
                                                        <input type="text" class="form-control" name="penerima" id="penerima" placeholder="Penerima Servis" value="{{ Auth::user()->name }}" disabled>
                                                    </div>

                                                    <div class="form-check">
                                                        <label class="form-check-label" for="send_notification">
                                                            <input class="form-check-input" type="checkbox" id="send_notification" name="send_notification" value="1">
                                                            Kirim Notifikasi
                                                        </label>
                                                        <p class="text-muted">Centang untuk mengirimkan notifikasi ke pelanggan</p>
                                                    </div>

                                                    <!-- Form Check -->
                                                    <div class="form-check d-flex justify-content-end gap-2 mt-4">
                                                        <input class="form-check-input" type="checkbox" value="" id="marketingEmailsCheckbox" required>
                                                        <label class="form-check-label" for="marketingEmailsCheckbox">Dengan ini saya, <span class="text-danger">{{ Auth::user()->name }}</span> setuju untuk menerima servis.</label>
                                                    </div>
                                                    <!-- End Form Check -->
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{ route('backsite.customer.index') }}" class="btn btn-secondary">Buat Data Pelanggan Baru</a>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                {{-- End Add Service Modal --}}
                            </div>
                        </div>

                        @can('service_table')
                        {{-- Tabel Service --}}
                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-responsive">
                                    <table id="serviceTable" class="table table-bordered table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">No. Servis</th>
                                                <th scope="col">Tgl. Terima</th>
                                                <th scope="col">Pemilik</th>
                                                <th scope="col">Barang</th>
                                                <th scope="col">Kerusakan</th>
                                                <th scope="col">Lama</th>
                                                <th scope="col">Status</th>
                                                @can('add_technician')
                                                <th scope="col">Teknisi</th>
                                                @endcan
                                                <th scope="col">Aksi</th>
                                                <th scope="col">Ubah Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($service as $key => $service_item)
                                                <tr data-entry-id="{{ $service_item->id }}">
                                                    <th scope="row" class="text-body fw-bold">{{ $service_item->kode_servis ?? '' }}</th>
                                                    <td data-order="{{ $service_item->service_detail?->warranty_history?->status == 1 
                                                        ? $service_item->service_detail->warranty_history->created_at : $service_item->created_at ?? '' }}">
                                                        {{ $service_item->service_detail?->warranty_history?->status == 1 
                                                            ? $service_item->service_detail->warranty_history->created_at->isoFormat('D MMM Y') 
                                                            : $service_item->created_at->isoFormat('D MMM Y') ?? '' }}
                                                    </td>
                                                    <td class="text-body fw-bold">{{ $service_item->customer->name ?? '' }}</td>
                                                    <td data-toggle="tooltip" data-placement="top" title="{{ $service_item->jenis ?? '' }} {{ $service_item->tipe ?? '' }}">
                                                        {{ $service_item->jenis ?? '' }} {{ $service_item->tipe ?? '' }}</td>
                                                    <td>
                                                        {{ $service_item->service_detail?->warranty_history?->status == 1 ? $service_item->service_detail->warranty_history->keterangan : $service_item->service_detail->kerusakan ?? '' }}
                                                    </td>
                                                    <td>{{ $service_item->duration ?? '' }}</td>

                                                    <td>
                                                        @if($service_item->status == 1)
                                                            <span class="badge bg-secondary">{{ 'Belum Cek' }}</span>
                                                        @elseif($service_item->status == 2)
                                                            <span class="badge bg-info">{{ 'Akan Dikerjakan' }}</span>
                                                        @elseif($service_item->status == 3)
                                                            <span class="badge bg-info">{{ 'Sedang Cek' }}</span>
                                                        @elseif($service_item->status == 4)
                                                            <span class="badge bg-success">{{ 'Sedang Dikerjakan' }}</span>
                                                        @elseif($service_item->status == 5)
                                                            <span class="badge bg-warning">{{ 'Sedang Tes' }}</span>
                                                        @elseif($service_item->status == 6)
                                                            <span class="badge bg-danger">{{ 'Menunggu Konfirmasi' }}</span>
                                                        @elseif($service_item->status == 7)
                                                            <span class="badge bg-primary">{{ 'Menunggu Sparepart' }}</span>
                                                        @elseif($service_item->status == 10)
                                                            <span class="badge bg-primary">{{ 'Terkonfirmasi' }}</span>
                                                        @elseif($service_item->status == 11)
                                                            <span class="badge bg-primary">{{ 'Dibatalkan' }}</span>
                                                        @elseif($service_item->service_detail?->warranty_history?->status == 1)
                                                            <span class="badge bg-warning">{{ 'Garansi' }}</span>          
                                                        @endif
                                                    </td>

                                                    @can('add_technician')
                                                    <td>
                                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Pilih Teknisi" class="disable-tooltip">
                                                                @if ($service_item->teknisi)
                                                                    <button class="btn btn-sm btn-soft-primary fw-bold" data-bs-toggle="modal" data-bs-target="#teknisiModal{{ $service_item->id }}">
                                                                        {{ explode(' ', $service_item->teknisi_detail->name)[0] }}
                                                                    </button>
                                                                @else
                                                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#teknisiModal{{ $service_item->id }}">
                                                                        Teknisi
                                                                    </button>
                                                                @endif
                                                                <div class="modal fade bs-example-modal-center" id="teknisiModal{{ $service_item->id }}" tabindex="-1" aria-hidden="true" aria-labelledby="teknisiModalLabel">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Teknisi</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>

                                                                            <form class="form form-horizontal" action="{{ route('backsite.service.addTechnician', [$service_item->id]) }}" method="POST">
                                                                            
                                                                                @csrf

                                                                                <div class="modal-body">
                                                                                    @if ($service_item->teknisi)
                                                                                        <p>No. Servis <b>{{ $service_item->kode_servis}}</b> ini telah diserahkan oleh : <b>{{ $service_item->teknisi_detail->name }}</b>
                                                                                        <br>Dengan status saat ini 
                                                                                            @if($service_item->status == 1)
                                                                                                <b>{{ 'Belum Cek' }}</b>
                                                                                            @elseif($service_item->status == 2)
                                                                                                <b>{{ 'Akan Dikerjakan' }}</b>
                                                                                            @elseif($service_item->status == 3)
                                                                                                <b>{{ 'Sedang Cek' }}</b>
                                                                                            @elseif($service_item->status == 4)
                                                                                                <b>{{ 'Sedang Dikerjakan' }}</b>
                                                                                            @elseif($service_item->status == 5)
                                                                                                <b>{{ 'Sedang Tes' }}</b>
                                                                                            @elseif($service_item->status == 6)
                                                                                                <b>{{ 'Menunggu Konfirmasi' }}</b>
                                                                                            @elseif($service_item->status == 7)
                                                                                                <b>{{ 'Menunggu Sparepart' }}</b>    
                                                                                            @endif
                                                                                        </p>
                                                                                        <input type="hidden" name="service_id" value="{{ $service_item->id }}">

                                                                                        <div class="form-group mb-2">
                                                                                            <label for="teknisi" class="form-label">Edit Teknisi</label>
                                                                                            <select class="form-control select2" data-placeholder="Pilih Teknisi" title="teknisi" name="teknisi" id="teknisi" required>
                                                                                                <option value="" disabled selected>Pilih Teknisi</option>
                                                                                                @foreach($technicians as $technician)
                                                                                                    @if ($technician->id != $service_item->teknisi)
                                                                                                        <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                                                                                                    @endif
                                                                                                @endforeach
                                                                                            </select>
                                                                                            @if($errors->has('teknisi'))
                                                                                                <p style="font-style: bold; color: red;">{{ $errors->first('teknisi') }}</p>
                                                                                            @endif
                                                                                        </div>
                                                                                        <!-- Form Check -->
                                                                                        <div class="form-check d-flex justify-content-end gap-2 mt-4">
                                                                                            <input class="form-check-input" type="checkbox" value="" id="teknisiCheckbox{{ $service_item->id }}" required>
                                                                                            <label class="form-check-label" for="teknisiCheckbox{{ $service_item->id }}">Dengan ini saya, <span class="text-danger">{{ Auth::user()->name }}</span> setuju untuk mengganti teknisi</label>
                                                                                        </div>
                                                                                        <!-- End Form Check -->
                                                                                    @else
                                                                                        <p>Pilih teknisi untuk melakukan perbaikan pada No. Servis <b>{{ $service_item->kode_servis}}</b></p>
                                                                                        <input type="hidden" name="service_id" value="{{ $service_item->id }}">

                                                                                        <div class="form-group mb-2">
                                                                                            <label for="teknisi" class="form-label">Teknisi</label>
                                                                                            <select class="form-control select2" data-placeholder="Pilih Teknisi" title="teknisi" name="teknisi" id="teknisi" required>
                                                                                                <option value="" disabled selected>Pilih Teknisi</option>
                                                                                                @foreach($technicians as $technician)
                                                                                                    <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                            @if($errors->has('teknisi'))
                                                                                                <p style="font-style: bold; color: red;">{{ $errors->first('teknisi') }}</p>
                                                                                            @endif
                                                                                        </div>
                                                                                        <!-- Form Check -->
                                                                                        <div class="form-check d-flex justify-content-end gap-2 mt-4">
                                                                                            <input class="form-check-input" type="checkbox" value="" id="teknisiCheckbox{{ $service_item->id }}" required>
                                                                                            <label class="form-check-label" for="teknisiCheckbox{{ $service_item->id }}">Dengan ini saya, <span class="text-danger">{{ Auth::user()->name }}</span> setuju untuk dikerjakan oleh teknisi</label>
                                                                                        </div>
                                                                                        <!-- End Form Check -->
                                                                                    @endif
                                                                                </div>
                                                                                
                                                                                <div class="modal-footer">
                                                                                    @if ($service_item->teknisi)
                                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                                        <button type="submit" class="btn btn-primary" onclick="return confirm('Yakin mengganti teknisi {{ $service_item->teknisi }} ?')">Simpan</button>
                                                                                    @else
                                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                                                    @endif
                                                                                </div>
                                                                            </form>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    @endcan

                                                    <td>
                                                        <ul class="list-unstyled hstack gap-2 mb-0">
                                                            @can('service_confirmation')
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Konfirmasi Biaya Servis" class="disable-tooltip">
                                                            {{-- Button Konfirmasi --}}
                                                            @if ($service_item->teknisi)                                                                
                                                                <button class="btn btn-sm btn-soft-warning" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#cash{{ $service_item->id }}">
                                                                    <i class="mdi mdi-near-me"></i>
                                                                </button>
                                                            @else
                                                                <button class="btn btn-sm btn-soft-warning"
                                                                    data-bs-toggle="popover"
                                                                    data-bs-placement="top"  
                                                                    data-bs-trigger="focus"
                                                                    data-bs-content="Pilih teknisi terlebih dahulu.">
                                                                    <i class="mdi mdi-near-me"></i>
                                                                </button>
                                                            @endif
                                                            {{-- End Button Konfirmasi --}}
                                                            {{-- Start Modal Konfirmasi --}}
                                                            <form class="form form-horizontal" action="service/confirmation" method="POST" target="_blank">
                                                                @csrf
                                                                <div class="modal fade" id="cash{{ $service_item->id }}" tabindex="-1" aria-hidden="true" aria-labelledby="cashServiceModalLabel">
                                                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="cashServiceModalLabel">Konfirmasi Biaya Servis</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name="service_id" value="{{ $service_item->id }}">
                                                                                <div class="repeater" enctype="multipart/form-data">
                                                                                    <div data-repeater-list="group-a">
                                                                                        <div data-repeater-item class="row">
                                                                                            <h6 class="mb-2">Konfirmasi</h6>
                                                                                            <div class="mb-2">
                                                                                                <label for="tindakan">Tindakan</label>
                                                                                                <input type="text" id="tindakan" name="tindakan[]" class="form-control" placeholder="Tindakan Servis" required/>
                                                                                            </div>
                                                                                            <div class="mb-2">
                                                                                                <label for="biaya">Biaya</label>
                                                                                                <div class="input-group">
                                                                                                    <div class="input-group-text">RP.</div>
                                                                                                    <input type="text" id="biaya" class="form-control input-mask text-start" name="biaya[]" placeholder="Biaya Servis" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': 0" required>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="mb-4 align-self-center">
                                                                                                <div class="d-grid">
                                                                                                    <input data-repeater-delete type="button" class="btn btn-primary" value="Hapus" />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="Tambah" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                                <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                                                            </div>     
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>                                                            
                                                            {{-- End Modal Konfirmasi --}}
                                                            </li>
                                                            @endcan

                                                            @can('service_show')
                                                            {{-- Button View --}}
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Melihat Detail Servis" class="disable-tooltip">               
                                                                <button class="btn btn-sm btn-soft-primary" 
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#show{{ $service_item->id }}">
                                                                        <i class="mdi mdi-eye-outline"></i>
                                                                </button>
                                                                
                                                                <div class="modal fade bs-example-modal-center" id="show{{ $service_item->id }}" tabindex="-1" aria-hidden="true" aria-labelledby="showServiceModalLabel" aria-expanded="false">
                                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="showServiceModalLabel">Detail Servis</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            @if ($service_item->service_detail?->warranty_history?->status == 1)
                                                                            {{-- Start Body Garansi --}}
                                                                            <div class="modal-body">
                                                                                <table class="table table-striped mb-0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <th scope="row">No. Servis</th>
                                                                                            <td>{{ isset($service_item->kode_servis) ? $service_item->kode_servis : 'N/A' }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Tgl. Masuk</th>
                                                                                            <td>{{ $service_item['created_at']->isoFormat('dddd, D MMMM Y HH:mm') }} WIB
                                                                                                [{{ isset($service_item->penerima) ? $service_item->penerima : 'N/A' }}]
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Pemilik</th>
                                                                                            <td>{{ isset($service_item->customer->name) ? $service_item->customer->name : 'N/A' }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Barang Servis</th>
                                                                                            <td>{{ isset($service_item->tipe) ? $service_item->tipe : 'N/A' }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Kerusakan Awal</th>
                                                                                            <td>{{ isset($service_item->service_detail->kerusakan) ? $service_item->service_detail->kerusakan : 'N/A' }}</td>
                                                                                        </tr>

                                                                                        {{-- Tindakan dan Modal --}}
                                                                                        @if(isset($service_item->service_detail->tindakan) && isset($service_item->service_detail->modal))
                                                                                            @php
                                                                                                $tindakan = json_decode($service_item->service_detail->tindakan, true);
                                                                                                $modal = json_decode($service_item->service_detail->modal);
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
                                                                                            <td><span class="fw-bold">{{ isset($service_item->service_detail->biaya) ? 'RP. '.number_format($service_item->service_detail->biaya) : 'N/A' }}</span></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Status</th>
                                                                                            <td>
                                                                                                @if($service_item->status == 1)
                                                                                                    <span class="badge bg-secondary">{{ 'Belum Cek' }}</span>
                                                                                                @elseif($service_item->status == 2)
                                                                                                    <span class="badge bg-info">{{ 'Akan Dikerjakan' }}</span>
                                                                                                @elseif($service_item->status == 3)
                                                                                                    <span class="badge bg-info">{{ 'Sedang Cek' }}</span>
                                                                                                @elseif($service_item->status == 4)
                                                                                                    <span class="badge bg-success">{{ 'Sedang Dikerjakan' }}</span>
                                                                                                @elseif($service_item->status == 5)
                                                                                                    <span class="badge bg-warning">{{ 'Sedang Tes' }}</span>
                                                                                                @elseif($service_item->status == 6)
                                                                                                    <span class="badge bg-danger">{{ 'Menunggu Konfirmasi' }}</span>
                                                                                                @elseif($service_item->status == 7)
                                                                                                    <span class="badge bg-primary">{{ 'Menunggu Sparepart' }}</span>
                                                                                                @elseif($service_item->service_detail->warranty_history->status == 1)
                                                                                                    <span class="badge bg-warning">{{ 'Proses Garansi' }}</span>    
                                                                                                @endif
                                                                                            </td>
                                                                                        </tr>
                                                                                        {{-- Detail Garansi --}}
                                                                                        <tr>
                                                                                            <td colspan="2">
                                                                                                <div class="accordion" id="accordionFlushGaransi">
                                                                                                    <div class="accordion-item">
                                                                                                        <h2 class="accordion-header" id="flush-headingGaransi">
                                                                                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseGaransi" aria-expanded="true" aria-controls="flush-collapseGaransi">
                                                                                                                <span class="fw-bold">Detail Garansi</span>
                                                                                                            </button>
                                                                                                        </h2>
                                                                                                        <div id="flush-collapseGaransi" class="accordion-collapse collapse show" aria-labelledby="flush-headingGaransi" data-bs-parent="#accordionFlushGaransi">
                                                                                                            <div class="accordion-body">
                                                                                                                <table class="table table-striped mb-0">
                                                                                                                    <tbody>
                                                                                                                        <tr>
                                                                                                                            <th scope="row">Tanggal Klaim</th>
                                                                                                                            <td>{{ $service_item->service_detail->warranty_history->created_at->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                            <th scope="row">Ket. Klaim</th>
                                                                                                                            <td>{{ $service_item->service_detail->warranty_history->keterangan }}</td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                            <th scope="row">Garansi</th>
                                                                                                                            <td>{{ isset($service_item->service_detail->garansi) ? $service_item->service_detail->garansi : 'N/A' }} Hari</td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                            <th scope="row">Garansi Berakhir</th>
                                                                                                                            <td>{{ $warrantyInfo[$service_item->id]['end_warranty']->isoFormat('dddd, D MMMM Y HH:mm') }}</td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                            <th scope="row">Status Garansi</th>
                                                                                                                            <td>Tersisa {{ $warrantyInfo[$service_item->id]['sisa_warranty'] }}</td>
                                                                                                                        </tr>
                                                                                                                    </tbody>
                                                                                                                </table>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                        {{-- End Detail Garansi --}}
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            {{-- End Body Garansi --}}
                                                                            @else
                                                                            {{-- Start Body Non-Garansi --}}
                                                                            <div class="modal-body">
                                                                                <table class="table table-striped mb-0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <th scope="row">No. Servis</th>
                                                                                            <td>{{ isset($service_item->kode_servis) ? $service_item->kode_servis : 'N/A' }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Tgl. Masuk</th>
                                                                                            <td>{{ $service_item['created_at']->isoFormat('dddd, D MMMM Y HH:mm') }} WIB
                                                                                                [{{ isset($service_item->penerima) ? $service_item->penerima : 'N/A' }}]
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Pemilik</th>
                                                                                            <td>{{ isset($service_item->customer->name) ? $service_item->customer->name : 'N/A' }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Barang Servis</th>
                                                                                            <td>{{ isset($service_item->tipe) ? $service_item->tipe : 'N/A' }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Kelengkapan</th>
                                                                                            <td>{{ isset($service_item->kelengkapan) ? $service_item->kelengkapan : 'N/A' }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Kerusakan</th>
                                                                                            <td>{{ isset($service_item->service_detail->kerusakan) ? $service_item->service_detail->kerusakan : 'N/A' }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Status</th>
                                                                                            <td>
                                                                                                @if($service_item->status == 1)
                                                                                                    <span class="badge bg-secondary">{{ 'Belum Cek' }}</span>
                                                                                                @elseif($service_item->status == 2)
                                                                                                    <span class="badge bg-info">{{ 'Akan Dikerjakan' }}</span>
                                                                                                @elseif($service_item->status == 3)
                                                                                                    <span class="badge bg-info">{{ 'Sedang Cek' }}</span>
                                                                                                @elseif($service_item->status == 4)
                                                                                                    <span class="badge bg-success">{{ 'Sedang Dikerjakan' }}</span>
                                                                                                @elseif($service_item->status == 5)
                                                                                                    <span class="badge bg-warning">{{ 'Sedang Tes' }}</span>
                                                                                                @elseif($service_item->status == 6)
                                                                                                    <span class="badge bg-danger">{{ 'Menunggu Konfirmasi' }}</span>
                                                                                                @elseif($service_item->status == 7)
                                                                                                    <span class="badge bg-primary">{{ 'Menunggu Sparepart' }}</span>
                                                                                                @elseif($service_item->status == 10)
                                                                                                    <span class="badge bg-warning">{{ 'Proses Garansi' }}</span>    
                                                                                                @endif
                                                                                            </td>
                                                                                        </tr>
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
                                                            {{-- End Button View --}}
                                                            @endcan
                                                            @can('service_edit')
                                                            {{-- Button Edit --}}
                                                            @if (!$service_item->service_detail?->warranty_history?->status == 1)
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Status Servis" class="disable-tooltip">
                                                                <button class="btn btn-sm btn-soft-info" 
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#edit{{ $service_item->id }}">
                                                                        <i class="mdi mdi-pencil-outline"></i>
                                                                </button>
                                                                <div class="modal fade bs-example-modal-center" id="edit{{ $service_item->id }}" tabindex="-1" aria-hidden="true" aria-labelledby="editServiceModalLabel">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="editServiceModalLabel">Perbarui Status Servis</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                            
                                                                            <form class="form form-horizontal" action="{{ route('backsite.service.update', [$service_item->id]) }}" method="POST" enctype="multipart/form-data">
                                                                                
                                                                                @method('PUT')
                                                                                @csrf
                                                                                
                                                                                    <div class="modal-body">
                                                                                        <p>Pilih progres perbaikan untuk No. Servis <b>{{ $service_item->kode_servis}}</b></p>
                                                                                        <div class="row">
                                                                                            {{-- bagian pertama --}}
                                                                                            <div class="col-md-6">
                                                                                                <div class="form-group">
                                                                                                    <div class="mb-2">
                                                                                                        <input class="form-check-input" type="radio" name="status" id="status1{{ $service_item->id }}" value="1" {{ $service_item->status == '1' ? 'checked' : '' }} {{ $service_item->teknisi ? 'disabled' : '' }}>
                                                                                                        <label class="form-check-label" for="status1{{ $service_item->id }}">
                                                                                                            <span class="badge bg-secondary"> Belum Cek</span>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <div class="mb-2">
                                                                                                        <input class="form-check-input" type="radio" name="status" id="status2{{ $service_item->id }}" value="2" {{ $service_item->status == '2' ? 'checked' : '' }} {{ $service_item->teknisi ? '' : 'disabled' }}>
                                                                                                        <label class="form-check-label" for="status2{{ $service_item->id }}">
                                                                                                            <span class="badge bg-info"> Akan Dikerjakan</span>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <div class="mb-2">
                                                                                                        <input class="form-check-input" type="radio" name="status" id="status3{{ $service_item->id }}" value="3" {{ $service_item->status == '3' ? 'checked' : '' }} {{ $service_item->teknisi ? '' : 'disabled' }}>
                                                                                                        <label class="form-check-label" for="status3{{ $service_item->id }}">
                                                                                                            <span class="badge bg-info"> Sedang Cek</span>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <div class="mb-2">
                                                                                                        <input class="form-check-input" type="radio" name="status" id="status4{{ $service_item->id }}" value="4" {{ $service_item->status == '4' ? 'checked' : '' }} {{ $service_item->teknisi ? '' : 'disabled' }}>
                                                                                                        <label class="form-check-label" for="status4{{ $service_item->id }}">
                                                                                                            <span class="badge bg-success"> Sedang Dikerjakan</span>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            {{-- bagian kedua --}}
                                                                                            <div class="col-md-6">
                                                                                                <div class="form-group">
                                                                                                    <div class="mb-2">
                                                                                                        <input class="form-check-input" type="radio" name="status" id="status5{{ $service_item->id }}" value="5" {{ $service_item->status == '5' ? 'checked' : '' }} {{ $service_item->teknisi ? '' : 'disabled' }}>
                                                                                                        <label class="form-check-label" for="status5{{ $service_item->id }}">
                                                                                                            <span class="badge bg-warning"> Sedang Tes</span>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <div class="mb-2">
                                                                                                        <input class="form-check-input" type="radio" name="status" id="status6{{ $service_item->id }}" value="6" {{ $service_item->status == '6' ? 'checked' : '' }} {{ $service_item->teknisi ? '' : 'disabled' }}>
                                                                                                        <label class="form-check-label" for="status6{{ $service_item->id }}">
                                                                                                            <span class="badge bg-danger"> Menunggu Konfirmasi</span>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <div class="mb-2">
                                                                                                        <input class="form-check-input" type="radio" name="status" id="status7{{ $service_item->id }}" value="7" {{ $service_item->status == '7' ? 'checked' : '' }} {{ $service_item->teknisi ? '' : 'disabled' }}>
                                                                                                        <label class="form-check-label" for="status7{{ $service_item->id }}">
                                                                                                            <span class="badge bg-primary"> Menunggu Sparepart</span>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <p class="mt-4">Informasi : Detail Status Proses Servis ini akan muncul saat Pelanggan melakukan Cek Status (Tracking).</p>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                                        <button type="submit" class="btn btn-primary" onclick="return confirm('Yakin ingin merubah status servis?')">Perbarui Status</button>
                                                                                    </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>    
                                                            </li>
                                                            @endif
                                                            {{-- End Button Edit --}}
                                                            @endcan
                                                            @can('service_delete')
                                                            {{-- Button Delete --}}
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data Transaksi" class="disable-tooltip">
                                                                <a  data-bs-toggle="modal"
                                                                    data-bs-target="#serviceDelete{{ $service_item->id }}" 
                                                                    class="btn btn-sm btn-soft-danger">
                                                                    <i class="mdi mdi-delete-outline"></i>
                                                                </a>
                                                                <div class="modal fade" id="serviceDelete{{ $service_item->id }}" tabindex="-1" aria-labelledby="serviceDeleteLabel" aria-hidden="true">
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
                                                                                <form action="{{ route('backsite.service.destroy', $service_item->id ?? '') }}" method="POST">
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
                                                            @endcan
                                                        </ul>
                                                    </td>

                                                    <td>
                                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                                            @can('service_update')
                                                            {{-- Start Button Bisa Diambil --}}
                                                            <li>
                                                                @if ($service_item->teknisi)
                                                                    <div data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Status
                                                                    {{ $service_item->kode_servis }} menjadi
                                                                    Bisa Diambil" class="disable-tooltip">
                                                                        <button class="btn btn-sm btn-primary"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#bisaDiambil{{ $service_item->id }}">
                                                                            Bisa Diambil
                                                                        </button>
                                                                    </div>
                                                                @else
                                                                    <button class="btn btn-sm btn-soft-primary waves-effect"
                                                                        data-bs-toggle="popover"
                                                                        data-bs-placement="top"  
                                                                        data-bs-trigger="focus"
                                                                        data-bs-content="Pilih teknisi terlebih dahulu.">
                                                                        Bisa Diambil
                                                                    </button>
                                                                @endif
                                                                <form class="form form-horizontal" action="{{ $service_item->service_detail?->warranty_history?->status == 1 ? route('backsite.service-detail.warranty') : route('backsite.service-detail.store') }}" method="POST">
                                                                    @csrf
                                                                    <div class="modal fade bs-example-modal-center" id="bisaDiambil{{ $service_item->id }}" tabindex="-1" aria-hidden="true" aria-labelledby="bisaDiambilModalLabel">
                                                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Ubah data menjadi Bisa Diambil</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                @if ($service_item->service_detail?->warranty_history?->status == 1)
                                                                                    <div class="modal-body">
                                                                                        @if ($errors->any())
                                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                                <ul>
                                                                                                    @foreach ($errors->all() as $error)
                                                                                                        <li>{{ $error }}</li>
                                                                                                    @endforeach
                                                                                                </ul>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                                                            </div>
                                                                                        @endif
                                                                                        <input type="hidden" name="service_id" value="{{ $service_item->id }}">

                                                                                        <div class="mb-2">
                                                                                            <label for="customer_id" class="form-label">Pemilik Barang</label>
                                                                                            <input type="text" class="form-control" disabled value="{{ $service_item->customer->name ?? '' }} - No.Telp {{ $service_item->customer->contact ?? '' }}">    
                                                                                        </div>

                                                                                        <div class="mb-2">
                                                                                            <label for="jenis" class="form-label">Nama Barang</label>
                                                                                            <input type="text" class="form-control" disabled value="{{ $service_item->jenis ?? '' }} {{ $service_item->tipe ?? '' }}">
                                                                                        </div>

                                                                                        <div class="mb-2">
                                                                                            <label for="kerusakan" class="form-label">Kerusakan Awal</label>
                                                                                            <input type="text" class="form-control" disabled value="{{ $service_item->service_detail->kerusakan ?? '' }}">
                                                                                        </div>

                                                                                        <div class="mb-2">
                                                                                            <label for="tindakans" class="form-label">Tindakan Sebelumnya</label>
                                                                                            <input type="text" class="form-control" disabled value="{{ isset($service_item->service_detail->tindakan) ? implode(', ', json_decode($service_item->service_detail->tindakan)) : '' }}">
                                                                                        </div>

                                                                                        <div class="mb-2">
                                                                                            <label for="biaya" class="form-label">Biaya Sebelumnya</label>
                                                                                            <input type="text" class="form-control" disabled value="{{ 'RP. '.number_format($service_item->service_detail->biaya) ?? '' }}">
                                                                                        </div>

                                                                                        <div class="mb-2">
                                                                                            <label for="kondisi1" class="form-label">Kondisi</label>
                                                                                            <select class="form-control select2" data-minimum-results-for-search="Infinity" data-placeholder="Pilih kondisi" title="kondisi" name="kondisi">
                                                                                                <option value="{{ '' }}" disabled selected>Pilih Kondisi Servis</option>
                                                                                                    <option value="1">Sudah Jadi</option>
                                                                                                    <option value="2">Tidak Bisa</option>
                                                                                                    <option value="3">Dibatalkan</option>
                                                                                            </select>
                                                                                        </div>

                                                                                        <div class="mb-2">
                                                                                            <label for="tindakan" class="form-label">Tindakan</label>
                                                                                            <input type="text" class="form-control" name="tindakan" id="tindakan" placeholder="Tindakan Servis" required>
                                                                                        </div>

                                                                                        <div class="mb-4">
                                                                                            <label for="catatan" class="form-label">Catatan</label>
                                                                                            <textarea type="text" id="catatan" name="catatan" placeholder="Keterangan claim garansi" value="{{old('catatan')}}" class="form-control"></textarea>
                                                                                        </div>

                                                                                        <div class="form-check">
                                                                                            <label class="form-check-label" for="send_notification1">
                                                                                                <input class="form-check-input" type="checkbox" id="send_notification1" name="send_notification" value="1">
                                                                                                Kirim Notifikasi
                                                                                            </label>
                                                                                            <p class="text-muted">Centang untuk mengirimkan notifikasi ke pelanggan</p>
                                                                                        </div>

                                                                                        <!-- Form Check -->
                                                                                        <div class="form-check d-flex justify-content-end gap-2 mt-4">
                                                                                            <input class="form-check-input" type="checkbox" value="" id="bisaDiambilCheckbox{{ $service_item->id }}" required>
                                                                                            <label class="form-check-label" for="bisaDiambilCheckbox{{ $service_item->id }}">Dengan ini saya, <span class="text-danger">{{ Auth::user()->name }}</span> setuju mengubah Status menjadi Bisa Diambil</label>
                                                                                        </div>
                                                                                        <!-- End Form Check -->
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                                        <button type="submit" class="btn btn-primary">Bisa Diambil</button>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="modal-body">
                                                                                        @if ($errors->any())
                                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                                <ul>
                                                                                                    @foreach ($errors->all() as $error)
                                                                                                        <li>{{ $error }}</li>
                                                                                                    @endforeach
                                                                                                </ul>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                                                            </div>
                                                                                        @endif
                                                                                        <input type="hidden" name="service_id" value="{{ $service_item->id }}">

                                                                                        <div class="mb-2">
                                                                                            <label for="customer_id" class="form-label">Pemilik Barang</label>
                                                                                            <input type="text" class="form-control" disabled value="{{ $service_item->customer->name ?? '' }} - No.Telp {{ $service_item->customer->contact ?? '' }}">    
                                                                                        </div>

                                                                                        <div class="mb-2">
                                                                                            <label for="jenis" class="form-label">Nama Barang</label>
                                                                                            <input type="text" class="form-control" disabled value="{{ $service_item->jenis ?? '' }} {{ $service_item->tipe ?? '' }}">
                                                                                        </div>

                                                                                        <div class="mb-2">
                                                                                            <label for="kerusakan" class="form-label">Kerusakan</label>
                                                                                            <input type="text" class="form-control" disabled value="{{ $service_item->service_detail->kerusakan ?? '' }}">
                                                                                        </div>

                                                                                        <div class="mb-2">
                                                                                            <label for="kondisi" class="form-label">Kondisi</label>
                                                                                            <select class="form-control select2" data-minimum-results-for-search="Infinity" data-placeholder="Pilih kondisi" title="kondisi" name="kondisi" >
                                                                                                <option value="{{ '' }}" disabled selected>Pilih Kondisi Servis</option>
                                                                                                    <option value="1">Sudah Jadi</option>
                                                                                                    <option value="2">Tidak Bisa</option>
                                                                                                    <option value="3">Dibatalkan</option>
                                                                                            </select>
                                                                                        </div>

                                                                                        <div class="repeater mb-2" enctype="multipart/form-data">
                                                                                            <div data-repeater-list="group-a">
                                                                                                <div data-repeater-item class="row">
                                                                                                    <div  class="mb-2 col-lg-5">
                                                                                                        <label for="tindakan">Tindakan</label>
                                                                                                        <input type="text" id="tindakan" name="tindakan[]" class="form-control" placeholder="Tindakan yang dilakukan" required/>
                                                                                                    </div>
                                                        
                                                                                                    <div  class="mb-2 col-lg-5">
                                                                                                        <label for="modal">Modal</label>
                                                                                                        <div class="input-group">
                                                                                                            <div class="input-group-text">RP.</div>
                                                                                                            <input type="text" id="modal" class="form-control input-mask text-start" name="modal[]" placeholder="Modal dari sparepart" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': 0" required>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    
                                                                                                    <div class="col-lg-2 align-self-center">
                                                                                                        <div class="d-grid">
                                                                                                            <input data-repeater-delete type="button" class="btn btn-primary" value="Hapus"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                
                                                                                            </div>
                                                                                            <input data-repeater-create type="button" class="btn btn-success mt-lg-0" value="Tambah"/>
                                                                                        </div>

                                                                                        <div class="mb-4">
                                                                                            <label for="biaya" class="form-label">Biaya</label>
                                                                                            <div class="input-group">
                                                                                                <div class="input-group-text">RP.</div>
                                                                                                <input type="text" class="form-control input-mask text-start" name="biaya" id="biaya" placeholder="Biaya Servis" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': 0" required>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="form-check">
                                                                                            <label class="form-check-label" for="send_notification2">
                                                                                                <input class="form-check-input" type="checkbox" id="send_notification2" name="send_notification" value="1">
                                                                                                Kirim Notifikasi
                                                                                            </label>
                                                                                            <p class="text-muted">Centang untuk mengirimkan notifikasi ke pelanggan</p>
                                                                                        </div>

                                                                                        <!-- Form Check -->
                                                                                        <div class="form-check justify-content-end gap-2 mt-4">
                                                                                            <input class="form-check-input" type="checkbox" value="" id="bisaDiambilCheckbox{{ $service_item->id }}" required>
                                                                                            <label class="form-check-label" for="bisaDiambilCheckbox{{ $service_item->id }}">Dengan ini saya, <span class="text-danger">{{ Auth::user()->name }}</span> setuju mengubah Status menjadi Bisa Diambil</label>
                                                                                        </div>
                                                                                        <!-- End Form Check -->
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                                        <button type="submit" class="btn btn-primary">Bisa Diambil</button>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </li>
                                                            {{-- End Button Bisa Diambil --}}
                                                            @endcan
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
    
    <!-- Modal -->

</div>

@endsection

@push('after-script')
    <script>
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal Tersimpan',
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
        $('#addServiceModal').on('shown.bs.modal', function () {
            $("#customer_id").select2({
                dropdownParent: $("#addServiceModal")
            });
        })
    </script>

    <script>
            $(document).ready(function () {
                $('body').on('shown.bs.modal', '.modal', function () {
                    var modal = $(this);
                    modal.find(".select2").select2({
                        dropdownParent: modal
                    });
                });
            });
    </script>

    {{-- <script>
        $(document).ready(function () {
            $('body').on('shown.bs.modal', '.modal', function () {
                var modal = $(this);
                modal.find(".select2-search-disable").select2({
                    dropdownParent: modal
                });
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            // Panggil DataTables pada tabel
            $('#serviceTable').DataTable({
                "order": [[ 1, "asc" ]], // Urutkan data berdasarkan tanggal (kolom 2) secara descending
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
    <script>
        $(document).ready(function () {
            // Inisialisasi Input Mask
            $('.input-mask').inputmask({
                'alias': 'numeric',
                'groupSeparator': ',',
                'autoGroup': true,
                'digits': 0,
                'digitsOptional': 0
            });
    
            // Fungsi untuk mengupdate label tindakan dan modal
            function updateLabels(repeaterGroup) {
                repeaterGroup.find('[data-repeater-item]').each(function(index) {
                    var tindakanLabel = $(this).find('label[for="tindakan"]');
                    var modalLabel = $(this).find('label[for="modal"]');
                    var konfirmasiTitle = $(this).find('h6'); // Menambahkan ini
    
                    if (tindakanLabel) {
                        tindakanLabel.text('Tindakan ' + (index + 1));
                    }
                    
                    if (modalLabel) {
                        modalLabel.text('Modal ' + (index + 1));
                    }
    
                    // Update judul konfirmasi
                    if (konfirmasiTitle) {
                        konfirmasiTitle.text('Konfirmasi ' + (index + 1));
                    }
                });
            }
    
            // Menangani aksi tambah (Tambah) dalam repeater
            $(document).on('click', '[data-repeater-create]', function () {
                var repeaterGroup = $(this).closest('.repeater');
                var clonedItem = repeaterGroup.find('[data-repeater-item]:first').clone();
    
                clonedItem.find('input').val('').end()
                    .find('.input-mask').inputmask('remove')
                        .inputmask({
                            'alias': 'numeric',
                            'groupSeparator': ',',
                            'autoGroup': true,
                            'digits': 0,
                            'digitsOptional': 0
                        });
    
                repeaterGroup.find('[data-repeater-list]').append(clonedItem);
                clonedItem.find('[data-repeater-delete]').show().val('Hapus');
                clonedItem.hide().slideDown();
    
                // Update ulang judul konfirmasi pada semua elemen repeater
                updateLabels(repeaterGroup);
            });
    
            // Menangani aksi hapus (Hapus) dalam repeater
            $(document).on('click', '[data-repeater-delete]', function () {
                var repeaterItem = $(this).closest('[data-repeater-item]');
                var repeaterGroup = repeaterItem.closest('.repeater');
    
                if (repeaterGroup.find('[data-repeater-item]').length > 1) {
                    repeaterItem.slideUp(function () {
                        $(this).remove();
                        // Update ulang judul konfirmasi setelah item dihapus
                        updateLabels(repeaterGroup);
                    });
                }
            });
        });
    </script>
@endpush