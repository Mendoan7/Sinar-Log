@extends('layouts.app')

@section('title', 'Pelanggan')

@section('content')

<div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                        <div class="card-body border-bottom">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 card-title flex-grow-1">List Pelanggan</h5>
                                @can('customer_create')
                                {{-- Start Button Add Customer --}}
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#customerModal">
                                        Tambah Pelanggan
                                    </button>
                                </div>
                                {{-- End Button Add Customer --}}
                                @endcan

                                {{-- Add Customer Modal --}}
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
                                                        <label for="email" class="col-form-label">Email</label>
                                                        <input type="text" class="form-control" id="email" name="email" placeholder="Email Pelanggan" value="{{old('email')}}"/>
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
                                {{-- Add Customer Modal --}}
                            </div>
                        </div>

                        @can('customer_table')
                        {{-- Start Table Customer --}}
                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-responsive">
                                    <table id="customerTable" class="table table-hover mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Nomer Telepon</th>
                                                <th scope="col">Alamat</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Total Servis</th>
                                                <th scope="col" style="text-align:center; width:150px;">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @forelse($customer as $key => $customer_item)
                                            <tr data-entry-id="{{ $customer_item->id }}">
                                                <td>{{ $customer_item->name ?? '' }}</td>
                                                @if ($user_type === 3)
                                                    <td>{{ substr_replace($customer_item->contact, str_repeat('*', strlen($customer_item->contact) - (5 * 2)), 5, -5) }}</td>
                                                @else
                                                    <td>{{ $customer_item->contact ?? '' }}</td>
                                                @endif
                                                <td>{{ $customer_item->address ?? '' }}</td>
                                                <td>
                                                    @if ($customer_item->proses_servis >= 1)
                                                        <span class="badge bg-success">{{ 'Ada Servis' }}</span>
                                                    @elseif ($customer_item->bisa_diambil >= 1)
                                                        <span class="badge bg-success">{{ 'Ada Servis' }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ 'Tidak Ada Servis' }}</span>    
                                                    @endif
                                                </td>
                                                <td>{{ $customer_item->total_service ?? 0 }}</td>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        @if ($user_type === 3)
                                                            <button class="btn btn-sm btn-soft-primary waves-effect"
                                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Pilihan ini hanya berlaku akun Admin">
                                                                Tidak Ada Pilihan
                                                            </button>
                                                        @else
                                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                            </a>
                                                        @endif
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#show{{ $customer_item->id }}">
                                                                    Show
                                                                </a> 
                                                            </li>
                                                            
                                                            @can('customer_edit')
                                                            {{-- Start Button Edit --}}
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('backsite.customer.edit', $customer_item->id) }}">
                                                                    Edit
                                                                </a>
                                                            </li>
                                                            {{-- End Button Edit --}}
                                                            @endcan

                                                            @can('customer_delete')
                                                            {{-- Start Button Delete --}}
                                                            <li>
                                                                <form onsubmit="return confirm('Apakah kamu yakin ingin menghapus data pelanggan ?');"
                                                                    action="{{ route('backsite.customer.destroy', $customer_item->id) }}" method="POST">
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                    <input type="submit" class="dropdown-item" value="Delete">
                                                                </form>
                                                            </li>
                                                            {{-- End Button Delete --}}
                                                            @endcan
                                                        </ul>
                                                        <div class="modal fade bs-example-modal-center" id="show{{ $customer_item->id}}" tabindex="-1" aria-hidden="true" aria-labelledby="showCustomerModalLabel" aria-expanded="false">
                                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="showCustomerModalLabel">Detail Pelanggan</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <table class="table table-striped mb-0">
                                                                            <tbody>
                                                                                <tr class="table-info">
                                                                                    <th colspan="2" class="text-center fw-bold">Data Pelanggan</th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Nama</th>
                                                                                    <td>{{ isset($customer_item->name) ? $customer_item->name : 'N/A' }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">No. Telepon</th>
                                                                                    <td>{{ isset($customer_item->contact) ? $customer_item->contact : 'N/A' }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Email</th>
                                                                                    <td>{{ isset($customer_item->email) ? $customer_item->email : 'N/A' }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Alamat</th>
                                                                                    <td>{{ isset($customer_item->address) ? $customer_item->address : 'N/A' }}</td>
                                                                                </tr>
                                                                                <tr class="table-info">
                                                                                    <th colspan="2" class="text-center fw-bold">Detail Servis</th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Proses Servis</th>
                                                                                    <td>{{ $customer_item->proses_servis ?? 0 }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Bisa Diambil</th>
                                                                                    <td>{{ $customer_item->bisa_diambil ?? 0 }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Servis Keluar</th>
                                                                                    <td>{{ $customer_item->servis_selesai ?? 0 }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Proses Garansi</th>
                                                                                    <td>{{ $customer_item->proses_garansi ?? 0 }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Total Servis</th>
                                                                                    <td>{{ $customer_item->total_service ?? 0 }}</td>
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
                        {{-- End Table Customer --}}
                        @endcan
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>

@endsection

@push('after-script')

{{-- <script>
    $('.contact').mask('+62 000-0000-00000');
</script> --}}

<script>
    $(document).ready(function() {
        // Panggil DataTables pada tabel
        $('#customerTable').DataTable({
            "language": {
                "sEmptyTable": "Tidak ada data yang tersedia pada tabel",
                "sInfo": "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                "sInfoEmpty": "Menampilkan 0 hingga 0 dari 0 data",
                "sInfoFiltered": "(disaring dari _MAX_ data keseluruhan)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "Tampilkan _MENU_ data",
                "sLoadingRecords": "Memuat...",
                "sProcessing": "Sedang diproses...",
                "sSearch": "Cari :",
                "sZeroRecords": "Tidak ada data yang cocok ditemukan",
                "oPaginate": {
                    "sFirst": "Pertama",
                    "sLast": "Terakhir",
                    "sNext": "Berikutnya",
                    "sPrevious": "Sebelumnya"
                },
            },
        });
    });
</script>

@endpush