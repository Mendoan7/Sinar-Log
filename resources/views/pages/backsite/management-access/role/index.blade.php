@extends('layouts.app')

@section('title', 'Role')

@section('content')

<div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
          <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
              <h4 class="mb-sm-0 font-size-18">Role</h4>
            </div>
          </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body border-bottom">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0 card-title flex-grow-1">List Role</h4>
                            @can('role_create')
                            {{-- Button Role Create --}}
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#roleModal">
                                    Tambah Role Baru
                                </button>
                                <div class="modal fade bs-example-modal-center" id="roleModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Role Baru</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form class="form form-horizontal" action="{{ route('backsite.role.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-2">
                                                        <label for="title" class="col-form-label">Role</label>
                                                        <input type="text" id="title" name="title" class="form-control" placeholder="Contoh seperti Admin / User" value="{{old('title')}}" autocomplete="off" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary" onclick="return confirm('Yakin untuk menyimpan data?')">Tambah Role</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End Button Role Create --}}
                            @endcan
                        </div>
                    </div>
                    
                    @can('role_table')
                    {{-- Role Table --}}
                    <div class="card-body">
                        <div class="table-rep-plugin">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Role</th>
                                            <th>Permission</th>
                                            <th style="text-align:center; width:150px;">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($role as $key => $role_item)
                                        <tr data-entry-id="{{ $role_item->id }}">
                                            <td>{{ isset($role_item->created_at) ? date("d/m/Y H:i:s",strtotime($role_item->created_at)) : '' }}</td>
                                            <td>{{ $role_item->title ?? '' }}</td>
                                            <td>{{ count($role_item->permission).' Permissions' }}</td>
                                            <td class="text-center">

                                                <div class="btn-group mr-1 mb-1">
                                                    <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @can('role_show')
                                                        {{-- Start Button Show --}}
                                                        <a data-bs-toggle="modal" 
                                                            data-bs-target="#show{{ $role_item->id }}"
                                                            class="dropdown-item">
                                                            Show
                                                        </a>
                                                        {{-- End Button Show --}}
                                                        @endcan
                                                        
                                                        @can('role_edit')
                                                        {{-- Start Button Edit --}}
                                                        <a class="dropdown-item"
                                                            href="{{ route('backsite.role.edit', $role_item->id) }}">
                                                            Edit
                                                        </a>
                                                        {{-- End Button Edit --}}
                                                        @endcan
                                                    
                                                        @can('role_delete')
                                                        {{-- Start Button Delete --}}
                                                        @if($role_item->id > 3)
                                                            <form onsubmit="return confirm('Yakin untuk menghapus data role ?');"
                                                                action="{{ route('backsite.role.destroy', $role_item->id) }}" method="POST">
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <input type="submit" class="dropdown-item" value="Delete">
                                                            </form>
                                                        @endif
                                                        {{-- End Button Delete --}}
                                                        @endcan
                                                    </div>                  
                                                </div>

                                                {{-- Start Modal Show --}}
                                                <div class="modal fade bs-example-modal-lg" id="show{{ $role_item->id }}" tabindex="-1" aria-hidden="true" aria-labelledby="showRoleModalLabel" aria-expanded="false">
                                                    <div class="modal-dialog modal-dialog-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="showRoleModalLabel">Detail Role</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table table-bordered">
                                                                    <thead class="table-light">
                                                                    <tr>
                                                                        <th>Role</th>
                                                                        <td>{{ isset($role_item->title) ? $role_item->title : 'N/A' }}</td>
                                                                    </tr>
                                                                    </thead>
                                                                    <tr>
                                                                        <th>Permission</th>
                                                                        <td>
                                                                            @foreach($role_item->permission as $id => $permission)
                                                                                <span class="badge bg-warning mr-1 mb-1">{{ isset($permission->title) ? $permission->title : 'N/A' }}</span>
                                                                            @endforeach
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
                    {{-- End Role Table --}}
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
