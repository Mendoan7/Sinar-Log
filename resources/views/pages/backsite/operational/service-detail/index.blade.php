@extends('layouts.app')

@section('title', 'Detail Servis')

@section('content')

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Jobs List</h4>

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

                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">No. Servis</th>
                                                <th scope="col">Tgl. Ditangani</th>
                                                <th scope="col">Pemilik</th>
                                                <th scope="col">Barang</th>
                                                <th scope="col">Kerusakan</th>
                                                <th scope="col">Kondisi</th>
                                                <th scope="col">Tindakan</th>
                                                <th scope="col">Teknisi</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Aksi</th>
                                                <th scope="col">Ubah Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @forelse($service as $key => $service_item) --}}
                                                <tr>
                                                    <th scope="row">F1WFBYMV-20230206</th>
                                                    <td>06/02/2023 13:29:26</td>
                                                    <td>Anwar</td>
                                                    <td>Xiaomi Note 5</td>
                                                    <td>Kamera depan blank hitam</td>
                                                    <td>
                                                        <span class="badge bg-secondary">{{ 'Sudah Jadi' }}</span>
                                                    </td>
                                                    <td>kamera diganti</td>
                                                    <td>mendoan</td>
                                                    <td>
                                                        <span class="badge bg-secondary">{{ 'Bisa Diambil' }}</span>
                                                    </td>
                                                    <td>
                                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                                <a href="job-details.html" class="btn btn-sm btn-soft-primary"><i class="mdi mdi-eye-outline"></i></a>
                                                            </li>
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                                <a href="#"class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>
                                                            </li>
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                                <a href="#serviceDelete" data-bs-toggle="modal" class="btn btn-sm btn-soft-danger"><i class="mdi mdi-delete-outline"></i></a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Status">
                                                                <a href="job-details.html" class="btn btn-sm btn-soft-success">Sudah Diambil</a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
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