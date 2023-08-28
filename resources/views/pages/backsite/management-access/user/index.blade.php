@extends('layouts.app')

@section('title', 'User')

@section('content')

<div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
          <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                @if(auth()->user()->detail_user->type_user_id == 2)
                <h4 class="mb-sm-0 font-size-18">Pegawai</h4>
                @else
                <h4 class="mb-sm-0 font-size-18">User</h4>
                @endif
            </div>
          </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    @can('user_table')
                    {{-- Table User --}}
                    <div class="card-body">
                        <div class="table-rep-plugin">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped-columns table-bordered mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Tipe User</th>
                                            <th>Status</th>
                                            <th style="text-align:center; width:150px;">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($user as $key => $user_item)
                                        <tr data-entry-id="{{ $user_item->id }}">
                                            <td>{{ date("d/m/Y H:i:s",strtotime($user_item->created_at)) ?? '' }}</td>
                                            <td>{{ $user_item->name ?? '' }}</td>
                                            <td>{{ $user_item->email ?? '' }}</td>
                                            <td style="width:200px;">
                                                @foreach($user_item->role as $key => $item)
                                                    <span class="badge bg-warning mr-1 mb-1">{{ $item->title }}</span>
                                                @endforeach
                                            </td>
                                            <td style="width:200px;">
                                                <span class="badge bg-success mr-1 mb-1">{{ $user_item->detail_user->type_user->name ?? '' }}</span>
                                            </td>
                                            <td>
                                                @if ($user_item->status)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Tidak Aktif</span>
                                                @endif
                                            </td>

                                            <td class="text-center">

                                                <div class="btn-group mr-1 mb-1">
                                                    <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @can('user_show')
                                                        {{-- Start Button Show --}}
                                                        <a data-bs-toggle="modal" 
                                                            data-bs-target="#show{{ $user_item->id }}"
                                                            class="dropdown-item">
                                                            Show
                                                        </a>
                                                        {{-- End Button Show --}}
                                                        @endcan
                                                        
                                                        @can('user_edit')
                                                        {{-- Start Button Edit --}}
                                                        <a class="dropdown-item"
                                                            href="{{ route('backsite.user.edit', $user_item->id) }}">
                                                            Edit
                                                        </a>
                                                        {{-- End Button Edit --}}
                                                        @endcan
                                                    
                                                        @can('user_delete')
                                                        {{-- Start Button Delete --}}
                                                        <form onsubmit="return confirm('Are you sure want to delete this data ?');"
                                                            action="{{ route('backsite.user.destroy', $user_item->id) }}" method="POST">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="submit" class="dropdown-item" value="Delete">
                                                        </form>
                                                        {{-- End Button Delete --}}
                                                        @endcan

                                                        @can('user_status')
                                                        {{-- Start Button Activate/Deactivate --}}
                                                        <form action="{{ route('backsite.user.status', ['user' => $user_item->id, 'status' => $user_item->status ? 'deactivate' : 'activate']) }}"  method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="dropdown-item">
                                                                @if ($user_item->status)
                                                                    Nonaktifkan
                                                                @else
                                                                    Aktifkan
                                                                @endif
                                                            </button>
                                                        </form>
                                                        {{-- End Button Activate/Deactivate --}}
                                                        @endcan
                                                    </div>                  
                                                </div>

                                                {{-- Start Modal Show --}}
                                                <div class="modal fade bs-example-modal-lg" id="show{{ $user_item->id }}" tabindex="-1" aria-hidden="true" aria-labelledby="showUserModalLabel" aria-expanded="false">
                                                    <div class="modal-dialog modal-dialog-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="showUserModalLabel">Detail User</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <td>{{ isset($user_item->name) ? $user_item->name : 'N/A' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Email</th>
                                                                        <td>{{ isset($user_item->email) ? $user_item->email : 'N/A' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Role</th>
                                                                        <td>
                                                                            @foreach($user_item->role as $id => $role)
                                                                                <span class="badge bg-warning mr-1 mb-1">{{ isset($role->title) ? $role->title : 'N/A' }}</span>
                                                                            @endforeach
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Type User</th>
                                                                        <td>
                                                                            <span class="badge bg-success mr-1 mb-1">{{ isset($user_item->detail_user->type_user->name) ? $user_item->detail_user->type_user->name : 'N/A' }}</span>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>        
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- End Modal Show --}}

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
                    {{-- End Table User --}}
                    @endcan
                </div>
            </div>
        </div>

        </div>
    </div>
</div>

@endsection
