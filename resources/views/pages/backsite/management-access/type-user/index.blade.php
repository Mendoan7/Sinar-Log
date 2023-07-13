@extends('layouts.app')

@section('title', 'Type User')

@section('content')

<div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
          <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
              <h4 class="mb-sm-0 font-size-18">List Tipe User</h4>
            </div>
          </div>
        </div>
        <!-- end page title -->
        <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('type_user_table')
                            {{-- Table Type User --}}
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Tipe User</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($type_user as $key => $type_user_item)
                                            <tr data-entry-id="{{ $type_user_item->id }}">
                                                <td>{{ $type_user_item->name ?? '' }}</td>
                                            </tr>
                                        @empty
                                            {{-- not found --}}
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{-- End Table Type User --}}
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
