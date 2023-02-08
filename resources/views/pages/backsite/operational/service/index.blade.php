@extends('layouts.app')

@section('title', 'Servis')

@section('content')

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Servis</h4>

                    </div>
                </div>
            </div>
            <!-- end page title -->
 
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body border-bottom">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 card-title flex-grow-1">Proses Servis</h5>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#serviceModal"
                                        data-bs-whatever="@getbootstrap">Servis Baru</button>
                                </div>
                                
                                {{-- Add Service Modal --}}
                                <div class="modal fade bs-example-modal-center" id="serviceModal" tabindex="-1" aria-hidden="true" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tambah Data Pelanggan Baru</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form class="form form-horizontal" action="{{ route('backsite.service.store') }}" method="POST">
                                                @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-2">
                                                            <label for="customer_id" class="form-label">Pemilik Barang</label>
                                                            <select class="form-select" data-control="select2" data-placeholder="Select an option" title="customer_id" name="customer_id" id="select2insidemodal" required>
                                                                <option value="{{ '' }}" disabled selected>Choose</option>
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
                                                            <input type="text" class="form-control" name="jenis" id="jenis" placeholder="Jenis Barang" required>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="tipe" class="form-label">Tipe/Merek</label>
                                                            <input type="text" class="form-control" name="tipe" id="tipe" placeholder="Tipe barang yang di servis" required>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="kelengkapan" class="form-label">Kelengkapan</label>
                                                            <input type="text" class="form-control" name="kelengkapan" id="kelengkapan" placeholder="Kelengkapan" required>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="kerusakan" class="form-label">Kerusakan</label>
                                                            <input type="text" class="form-control" name="kerusakan" id="kerusakan" placeholder="Kerusakan" required>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="penerima" class="form-label">Penerima</label>
                                                            <input type="text" class="form-control" name="penerima" id="penerima" placeholder="Penerima Servis" value="{{ Auth::user()->name }}" required>
                                                        </div>

                                                        <!-- Form Check -->
                                                        <div class="form-check d-flex justify-content-end gap-2 mt-4">
                                                        <input class="form-check-input" type="checkbox" value="" id="marketingEmailsCheckbox" required>
                                                        <label class="form-check-label" for="marketingEmailsCheckbox">Dengan ini saya, {{ Auth::user()->name }} setuju menerima servis</label>
                                                        </div>
                                                        <!-- End Form Check -->
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Tabel Service --}}
                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">No. Servis</th>
                                                <th scope="col">Tgl. Penerima</th>
                                                <th scope="col">Pemilik</th>
                                                <th scope="col">Barang</th>
                                                <th scope="col">Kerusakan</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Aksi</th>
                                                <th scope="col">Ubah Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($service as $key => $service_item)
                                                <tr data-entry-id="{{ $service_item->id }}">
                                                    <th scope="row">{{ $service_item->kode_servis ?? '' }}</th>
                                                    <td>{{ isset($service_item->created_at) ? date("d/m/Y H:i:s",strtotime($service_item->created_at)) : '' }}</td>
                                                    <td>{{ $service_item->customer->name ?? '' }}</td>
                                                    <td>{{ $service_item->jenis ?? '' }} {{ $service_item->tipe ?? '' }}</td>
                                                    <td>{{ $service_item->kerusakan ?? '' }}</td>

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
                                                            <span class="badge bg-warning">{{ 'Menunggu Sparepart' }}</span>    
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">               
                                                                <button class="btn btn-sm btn-soft-primary" 
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#showServiceModal" 
                                                                        data-bs-remote="{{ route('backsite.service.show', $service_item->id) }}">
                                                                        <i class="mdi mdi-eye-outline"></i>
                                                                </button>
                                                            </li>
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                                <button class="btn btn-sm btn-soft-info" 
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#editServiceModal" 
                                                                        data-bs-remote="{{ route('backsite.service.edit', $service_item->id) }}">
                                                                        <i class="mdi mdi-pencil-outline"></i>
                                                                </button>    
                                                            </li>
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                                <a href="#serviceDelete" 
                                                                    data-bs-toggle="modal" 
                                                                    class="btn btn-sm btn-soft-danger">
                                                                    <i class="mdi mdi-delete-outline"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>

                                                    <td>
                                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Status">
                                                                <a href="job-details.html" class="btn btn-sm btn-soft-primary">Bisa Diambil</a>
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

    <div class="modal fade bs-example-modal-center" id="showServiceModal" tabindex="-1" aria-hidden="true" aria-labelledby="showServiceModalLabel" aria-expanded="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showServiceModalLabel">Detail Servis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="col">No. Servis</th>
                                <td scope="col">{{ isset($service_item->kode_servis) ? $service_item->kode_servis : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tgl. Masuk</th>
                                <td>{{ isset($service_item->created_at) ? date("d/m/Y H:i:s",strtotime($service_item->created_at)) : '' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Pemilik</th>
                                <td>{{ isset($service_item->name) ? $service_item->name : 'N/A' }}</td>
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
                                    <span class="badge bg-warning">{{ 'Menunggu Sparepart' }}</span>    
                                @endif</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>        
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-center" id="editServiceModal" tabindex="-1" aria-hidden="true" aria-labelledby="editServiceModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editServiceModalLabel">Perbarui Detail Servis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form class="form form-horizontal" action="{{ route('backsite.service.update', $service_item->id) }}" method="POST">
                    @csrf
                    @method('put')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="status">Edit Status</label>
                                <div>
                                    <input class="form-check-input" type="radio" name="status" id="status1" value="1" {{ $service_item->status == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status1">
                                        <span class="badge bg-secondary"> Belum Cek</span>
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="radio" name="status" id="status2" value="2" {{ $service_item->status == '2' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status2">
                                        <span class="badge bg-info"> Sedang Cek</span>
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="radio" name="status" id="status3" value="3" {{ $service_item->status == '3' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status3">
                                        <span class="badge bg-success"> Sedang Dikerjakan</span>
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="radio" name="status" id="status4" value="4" {{ $service_item->status == '4' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status4">
                                        <span class="badge bg-warning"> Sedang Tes</span>
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="radio" name="status" id="status5" value="5" {{ $service_item->status == '5' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status5">
                                        <span class="badge bg-danger"> Menunggu Konfirmasi</span>
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="radio" name="status" id="status6" value="6" {{ $service_item->status == '6' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status6">
                                        <span class="badge bg-primary"> Menunggu Sparepart</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Perbarui Status</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="serviceDelete" tabindex="-1" aria-labelledby="serviceDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body px-4 py-5 text-center">
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="avatar-sm mb-4 mx-auto">
                        <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                            <i class="mdi mdi-trash-can-outline"></i>
                        </div>
                    </div>
                    <p class="text-muted font-size-16 mb-4">Anda yakin ingin menghapus data pelanggan?</p>
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

</div>

@endsection

@push('after-script')
    <script>

        $(document).ready(function() {
        $("#select2insidemodal").select2({
            dropdownParent: $("#serviceModal")
        });
        });
        
    </script>
@endpush



