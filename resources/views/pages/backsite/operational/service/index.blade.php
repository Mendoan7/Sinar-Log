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
                                {{-- Button Add Service --}}
                                <div class="flex-shrink-0">
                                    <button class="btn btn-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#addServiceModal">
                                            Servis Baru
                                    </button>
                                </div>
                                {{-- End Button Add Service --}}
                                
                                {{-- Add Service Modal --}}
                                <div class="modal fade bs-example-modal-center" id="addServiceModal" tabindex="-1" aria-hidden="true" aria-labelledby="addServiceModalLabel">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addServiceModalLabel">Tambah Data Servis Baru</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form class="form form-horizontal" action="{{ route('backsite.service.store') }}" method="POST">
                                                @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group mb-2">
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
                                                            
                                                            @if($errors->has('customer_id'))
                                                                <p style="font-style: bold; color: red;">{{ $errors->first('customer_id') }}</p>
                                                            @endif
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="jenis" class="form-label">Jenis Barang</label>
                                                            <input type="text" class="form-control" list="jenisOption" name="jenis" id="jenis" placeholder="Jenis barang" required>
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
                                                            <input type="text" class="form-control" name="tipe" id="tipe" placeholder="Tipe barang yang di servis" required>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="kelengkapan" class="form-label">Kelengkapan</label>
                                                            <input type="text" class="form-control" list="kelengkapanOption" name="kelengkapan" id="kelengkapan" placeholder="Isi kelengkapan barang yang diterima" required>
                                                                <datalist id="kelengkapanOption">
                                                                    <option value="Unit Only">
                                                                    <option value="Unit, Simcard, dan MicroSD">
                                                                    <option value="Unit dan Simcard">
                                                                </datalist>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="kerusakan" class="form-label">Kerusakan</label>
                                                            <input type="text" class="form-control" name="kerusakan" id="kerusakan" placeholder="Silahkan isi kerusakan barang" required>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="penerima" class="form-label">Penerima</label>
                                                            <input type="text" class="form-control" name="penerima" id="penerima" placeholder="Penerima Servis" value="{{ Auth::user()->name }}" required disabled>
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
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Add Service Modal --}}
                            </div>
                        </div>

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
                                                <th scope="col">Aksi</th>
                                                <th scope="col">Ubah Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($service as $key => $service_item)
                                                <tr data-entry-id="{{ $service_item->id }}">
                                                    <th scope="row" class="text-body fw-bold">{{ $service_item->kode_servis ?? '' }}</th>
                                                    <td>{{ $service_item->created_at->format('d M Y') }}</td>
                                                    <td class="text-body fw-bold">{{ $service_item->customer->name ?? '' }}</td>
                                                    <td>{{ $service_item->jenis ?? '' }} {{ $service_item->tipe ?? '' }}</td>
                                                    <td>{{ $service_item->kerusakan ?? '' }}</td>
                                                    <td>{{ $service_item->duration ?? '' }}</td>

                                                    <td>
                                                        @if($service_item->status == 1)
                                                            <span class="badge bg-secondary">{{ 'Belum Cek' }}</span>
                                                        @elseif($service_item->status == 2)
                                                            <span class="badge bg-info">{{ 'Sedang Cek' }}</span>
                                                        @elseif($service_item->status == 3)
                                                            <span class="badge bg-success">{{ 'Sedang Dikerjakan' }}</span>
                                                        @elseif($service_item->status == 4)
                                                            <span class="badge bg-warning">{{ 'Sedang Tes' }}</span>
                                                        @elseif($service_item->status == 5)
                                                            <span class="badge bg-danger">{{ 'Menunggu Konfirmasi' }}</span>
                                                        @elseif($service_item->status == 6)
                                                            <span class="badge bg-primary">{{ 'Menunggu Sparepart' }}</span>    
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <ul class="list-unstyled hstack gap-2 mb-0">
                                                            {{-- Button Konfirmasi --}}
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Konfirmasi Biaya Servis">               
                                                                <button class="btn btn-sm btn-soft-warning" 
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#cash{{ $service_item->id }}">
                                                                        <i class="mdi mdi-near-me"></i>
                                                                </button>
                                                                <div class="modal fade bs-example-modal-center" id="cash{{ $service_item->id }}" tabindex="-1" aria-hidden="true" aria-labelledby="cashServiceModalLabel" aria-expanded="false">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="cashServiceModalLabel">Konfirmasi Biaya Servis</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <form class="form form-horizontal" action="service/confirmation" method="POST">
                                                                                @csrf
                                                                                    <div class="modal-body">
                                                                                        <input type="hidden" name="service_id" value="{{ $service_item->id }}">

                                                                                        <div class="mb-2">
                                                                                            <label for="tindakan" class="form-label">Tindakan</label>
                                                                                            <input type="text" class="form-control" name="tindakan" id="tindakan" placeholder="Tindakan Servis" required>
                                                                                        </div>

                                                                                        <div class="mb-2">
                                                                                            <label for="biaya" class="form-label">Biaya</label>
                                                                                            <input type="text" class="form-control input-mask text-start" name="biaya" id="biaya" placeholder="Biaya Servis" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': 0, 'prefix': 'Rp. ', 'placeholder': '0'" required>
                                                                                        </div>

                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                                                                    </div>
                                                                            </form>        
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            {{-- End Button Konfirmasi --}}

                                                            {{-- Button View --}}
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Melihat Detail Servis">               
                                                                <button class="btn btn-sm btn-soft-primary" 
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#show{{ $service_item->id }}">
                                                                        <i class="mdi mdi-eye-outline"></i>
                                                                </button>
                                                                
                                                                <div class="modal fade bs-example-modal-center" id="show{{ $service_item->id }}" tabindex="-1" aria-hidden="true" aria-labelledby="showServiceModalLabel" aria-expanded="false">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="showServiceModalLabel">Detail Servis</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <table class="table table-striped mb-0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <th scope="row">No. Servis</th>
                                                                                            <td>{{ isset($service_item->kode_servis) ? $service_item->kode_servis : 'N/A' }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Tgl. Masuk</th>
                                                                                            <td>{{ \Carbon\Carbon::parse($service_item['created_at'])->isoFormat('dddd, D MMMM Y HH:mm')}} WIB
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
                                                                                            <td>{{ isset($service_item->kerusakan) ? $service_item->kerusakan : 'N/A' }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Status</th>
                                                                                            <td>
                                                                                                @if($service_item->status == 1)
                                                                                                    <span class="badge bg-secondary">{{ 'Belum Cek' }}</span>
                                                                                                @elseif($service_item->status == 2)
                                                                                                    <span class="badge bg-info">{{ 'Sedang Cek' }}</span>
                                                                                                @elseif($service_item->status == 3)
                                                                                                    <span class="badge bg-success">{{ 'Sedang Dikerjakan' }}</span>
                                                                                                @elseif($service_item->status == 4)
                                                                                                    <span class="badge bg-warning">{{ 'Sedang Tes' }}</span>
                                                                                                @elseif($service_item->status == 5)
                                                                                                    <span class="badge bg-danger">{{ 'Menunggu Konfirmasi' }}</span>
                                                                                                @elseif($service_item->status == 6)
                                                                                                    <span class="badge bg-primary">{{ 'Menunggu Sparepart' }}</span>    
                                                                                                @endif
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                            </div>        
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            {{-- End Button View --}}

                                                            {{-- Button Edit --}}
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Status Servis">
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
                                                                                        <div class="form-group">
                                                                                            <div class="mb-2">
                                                                                                <input class="form-check-input" type="radio" name="status" id="status1{{ $service_item->id }}" value="1" {{ $service_item->status == '1' ? 'checked' : '' }}>
                                                                                                <label class="form-check-label" for="status1{{ $service_item->id }}">
                                                                                                    <span class="badge bg-secondary"> Belum Cek</span>
                                                                                                </label>
                                                                                            </div>

                                                                                            <div class="mb-2">
                                                                                                <input class="form-check-input" type="radio" name="status" id="status2{{ $service_item->id }}" value="2" {{ $service_item->status == '2' ? 'checked' : '' }}>
                                                                                                <label class="form-check-label" for="status2{{ $service_item->id }}">
                                                                                                    <span class="badge bg-info"> Sedang Cek</span>
                                                                                                </label>
                                                                                            </div>
                                                                                            <div class="mb-2">
                                                                                                <input class="form-check-input" type="radio" name="status" id="status3{{ $service_item->id }}" value="3" {{ $service_item->status == '3' ? 'checked' : '' }}>
                                                                                                <label class="form-check-label" for="status3{{ $service_item->id }}">
                                                                                                    <span class="badge bg-success"> Sedang Dikerjakan</span>
                                                                                                </label>
                                                                                            </div>
                                                                                            <div class="mb-2">
                                                                                                <input class="form-check-input" type="radio" name="status" id="status4{{ $service_item->id }}" value="4" {{ $service_item->status == '4' ? 'checked' : '' }}>
                                                                                                <label class="form-check-label" for="status4{{ $service_item->id }}">
                                                                                                    <span class="badge bg-warning"> Sedang Tes</span>
                                                                                                </label>
                                                                                            </div>
                                                                                            <div class="mb-2">
                                                                                                <input class="form-check-input" type="radio" name="status" id="status5{{ $service_item->id }}" value="5" {{ $service_item->status == '5' ? 'checked' : '' }}>
                                                                                                <label class="form-check-label" for="status5{{ $service_item->id }}">
                                                                                                    <span class="badge bg-danger"> Menunggu Konfirmasi</span>
                                                                                                </label>
                                                                                            </div>
                                                                                            <div class="mb-2">
                                                                                                <input class="form-check-input" type="radio" name="status" id="status6{{ $service_item->id }}" value="6" {{ $service_item->status == '6' ? 'checked' : '' }}>
                                                                                                <label class="form-check-label" for="status6{{ $service_item->id }}">
                                                                                                    <span class="badge bg-primary"> Menunggu Sparepart</span>
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <p class="mt-4">Informasi : Detail Status Proses Servis ini akan muncul saat Pelanggan melakukan Cek Status (Tracking).</p>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                                        <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure want to save this data ?')">Perbarui Status</button>
                                                                                    </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>    
                                                            </li>
                                                            {{-- End Button Edit --}}
                                                            
                                                            {{-- Button Delete --}}
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data Transaksi">
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
                                                        </ul>
                                                    </td>

                                                    <td>
                                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Status">
                                                                <button class="btn btn-sm btn-soft-primary" 
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#bisaDiambil{{ $service_item->id }}">
                                                                    Bisa Diambil
                                                                </button>
                                                                <div class="modal fade bs-example-modal-center" id="bisaDiambil{{ $service_item->id }}" tabindex="-1" aria-hidden="true" aria-labelledby="bisaDiambilModalLabel">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Ubah data menjadi Bisa Diambil</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>

                                                                            <form class="form form-horizontal" action="{{ route('backsite.service-detail.store') }}" method="POST">
                                                                                @csrf
                                                                                    <div class="modal-body">
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
                                                                                            <input type="text" class="form-control" disabled value="{{ $service_item->kerusakan ?? '' }}">
                                                                                        </div>

                                                                                        <div class="mb-2">
                                                                                            <label for="kondisi" class="form-label">Kondisi</label>
                                                                                            <select class="form-select" data-control="select2" data-placeholder="Pilih kondisi" title="kondisi" name="kondisi" id="select2insidemodal" required>
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

                                                                                        <div class="mb-2">
                                                                                            <label for="modal" class="form-label">Modal</label>
                                                                                            <input type="text" class="form-control input-mask text-start" name="modal" id="modal" placeholder="Modal Sparepart" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': 0, 'prefix': 'RP. ', 'placeholder': '0'" required>
                                                                                        </div>

                                                                                        <div class="mb-2">
                                                                                            <label for="biaya" class="form-label">Biaya</label>
                                                                                            <input type="text" class="form-control input-mask text-start" name="biaya" id="biaya" placeholder="Biaya Servis" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': 0, 'prefix': 'RP. ', 'placeholder': '0'" required>
                                                                                        </div>

                                                                                        <div class="mb-2">
                                                                                            <label for="teknisi" class="form-label">Teknisi</label>
                                                                                            <input type="text" class="form-control" name="teknisi" id="teknisi" placeholder="Teknisi Servis" value="{{ Auth::user()->name }}" required disabled>
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
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
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
        $('#addServiceModal').on('shown.bs.modal', function () {
            $("#customer_id").select2({
                dropdownParent: $("#addServiceModal")
            });
        })
    </script>

    <script>
        $(document).ready(function() {
            // Panggil DataTables pada tabel
            $('#serviceTable').DataTable({
                "order": [[ 2, "asc" ]], // Urutkan data berdasarkan tanggal (kolom 2) secara descending
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



