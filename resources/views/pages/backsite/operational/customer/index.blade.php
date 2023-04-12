@extends('layouts.app')

@section('title', 'Pelanggan')

@section('content')

<div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
          <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
              <h4 class="mb-sm-0 font-size-18">Pelanggan</h4>
            </div>
          </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                        <div class="card-body border-bottom">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 card-title flex-grow-1">List Pelanggan</h5>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#customerModal">
                                        Tambah Pelanggan
                                    </button>
                                </div>

                                <div class="modal fade bs-example-modal-center" id="customerModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tambah Data Pelanggan Baru</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form class="form form-horizontal" action="{{ route('backsite.customer.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-2">
                                                        <label for="name" class="col-form-label">Nama Lengkap</label>
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap" value="{{old('name')}}" required/>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="contact" class="col-form-label">Nomer Telepon</label>
                                                        <input type="text" class="form-control" id="contact" name="contact" placeholder="Nomer telepon pelanggan" value="{{old('contact')}}" required/>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="address" class="col-form-label">Alamat</label>
                                                        <textarea class="form-control" id="address" name="address" placeholder="Alamat pelanggan" value="{{old('address')}}" required></textarea>
                                                    </div>
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
                        
                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-hover mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Nama</th>
                                                <th>Nomer Telepon</th>
                                                <th>Alamat</th>
                                                <th>Proses Servis</th>
                                                <th>Bisa Diambil</th>
                                                <th>Servis Selesai</th>
                                                <th>Total Servis</th>
                                                <th style="text-align:center; width:150px;">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @forelse($customer as $key => $customer_item)
                                            <tr data-entry-id="{{ $customer_item->id }}">
                                                <td>{{ $customer_item->name ?? '' }}</td>
                                                <td>{{ $customer_item->contact ?? '' }}</td>
                                                <td>{{ $customer_item->address ?? '' }}</td>
                                                <td>{{ $customer_item->service->where('status', '<=', 6)->count() }}</td>
                                                <td>{{ $customer_item->service->where('status', 7)->count() }}</td>
                                                <td>{{ $customer_item->service->where('status', 8)->count() }}</td>
                                                <td>{{ $customer_item->service->count() }}</td>
                                                <td class="text-center">

                                                    <div class="btn-group mr-1 mb-1">
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item" href="{{ route('backsite.customer.edit', $customer_item->id) }}">
                                                                    Edit
                                                                </a>
                                                            
                                                                <form onsubmit="return confirm('Are you sure want to delete this data ?');"
                                                                    action="{{ route('backsite.customer.destroy', $customer_item->id) }}" method="POST">
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                    <input type="submit" class="dropdown-item" value="Delete">
                                                                </form>
                                                            
                                                            </div>
                                                        </div>
                                                    </div>

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
                </div>
            </div>
        </div>
      </div>
    </div>
</div>

@endsection

@push('after-script')

<script>
    $('.contact').mask('+62 000-0000-00000');
</script>

@endpush