@extends('layouts.app')

@section('title', 'Permission')

@section('content')

<div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
          <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
              <h4 class="mb-sm-0 font-size-18">Permission</h4>
            </div>
          </div>
        </div>
        <!-- end page title -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body border-bottom">
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0 card-title flex-grow-1">List Permission</h4>
                            </div>
                        </div>
                        @can('permission_table')
                        {{-- Tabel Permission --}}
                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped table-hover mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Permission</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse($permission as $key => $permission_item)
                                                <tr data-entry-id="{{ $permission_item->id }}">
                                                    <td>{{ $permission_item->title ?? '' }}</td>
                                                </tr>
                                            @empty
                                                {{-- not found --}}
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- End Tabel Permission --}}
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
