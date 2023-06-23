@extends('layouts.app')

@section('title', ' Edit - Role')

@section('content')

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Create New</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Edit Role</h4>
                            <form class="form form-horizontal" action="{{ route("backsite.role.update", [$role->id]) }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                
                                <div class="form-body">

                                    <div class="row mb-4">
                                        <label for="title" class="col-form-label col-lg-2">Role</label>
                                        <div class="col-lg-10">
                                            <input id="title" name="title" type="text" class="form-control" placeholder="Contoh seperti Admin / User" value="{{ old('title', isset($role) ? $role->title : '') }}" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="title" class="col-form-label col-lg-2">Permission</label>
                                        <div class="col-lg-10">
                                            <label for="permission">
                                                <span class="btn btn-warning btn-sm select-all">{{ 'Select All' }}</span>
                                                <span class="btn btn-warning btn-sm deselect-all">{{ 'Deselect All' }}</span>
                                            </label>
                                            <select name="permission[]"
                                                    id="permission"
                                                    class="select2 form-control select2-multiple"
                                                    multiple="multiple">
                                                    @foreach($permission as $id => $permission_item)
                                                        <option value="{{ $permission_item->id }}" {{ (in_array($permission_item->id, old('permission', [])) || isset($role) && $role->permission->contains($permission_item->id)) ? 'selected' : '' }}>{{ $permission_item->title }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row justify-content-end">
                                        <div class="col-lg-10">
                                            <button type="submit" class="btn btn-primary">Ubah Role</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>

@endsection

@push('after-script')

    <script>
        jQuery(document).ready(function($){
            $('.select-all').click(function () {
                let $select2 = $(this).parent().siblings('.select2-multiple')
                $select2.find('option').prop('selected', 'selected')
                $select2.trigger('change')
            })

            $('.deselect-all').click(function () {
                let $select2 = $(this).parent().siblings('.select2-multiple')
                $select2.find('option').prop('selected', '')
                $select2.trigger('change')
            })
        });
    </script>

@endpush