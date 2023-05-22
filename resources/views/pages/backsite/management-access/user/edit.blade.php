@extends('layouts.app')

@section('title', ' Edit - User')

@section('content')

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit User</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Edit User</h4>
                            <form class="form form-horizontal" action="{{ route("backsite.user.update", [$user->id]) }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                
                                <div class="form-body">

                                    <div class="row mb-4">
                                        <label for="name" class="col-form-label col-lg-2">Nama</label>
                                        <div class="col-lg-10">
                                            <input id="name" name="name" type="text" class="form-control" placeholder="example admin or users" value="{{ old('name', isset($user) ? $user->name : '') }}" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="email" class="col-form-label col-lg-2">Email</label>
                                        <div class="col-lg-10">
                                            <input id="email" name="email" type="text" class="form-control" placeholder="example People@mail.com or Human@mail.com" value="{{ old('email', isset($user) ? $user->email : '') }}" autocomplete="off" data-inputmask="'alias': 'email'" required>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label for="title" class="col-form-label col-lg-2">Role</label>
                                        <div class="col-lg-10">
                                            <label for="role">
                                                <span class="btn btn-warning btn-sm select-all">{{ 'Select All' }}</span>
                                                <span class="btn btn-warning btn-sm deselect-all">{{ 'Deselect All' }}</span>
                                            </label>

                                            <select name="role[]"
                                                    id="role"
                                                    class="select2 form-control select2-multiple"
                                                    multiple="multiple" required>
                                                    @foreach($role as $id => $role)
                                                        <option value="{{ $id }}" {{ (in_array($id, old('role', [])) || isset($user) && $user->role->contains($id)) ? 'selected' : '' }}>{{ $role }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label for="type_user_id" class="control-label col-lg-2">Tipe User</label>
                                        <div class="col-lg-10">
                                            <select name="type_user_id"
                                                    id="type_user_id"
                                                    class="form-control select2-search-disable" required>
                                                    <option value="{{ '' }}" disabled selected> Choose </option>
                                                @foreach($type_user as $key => $type_user_item)
                                                    <option value="{{ $type_user_item->id }}" {{ $type_user_item->id == $user->detail_user->type_user_id ? 'selected' : '' }}>{{ $type_user_item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row justify-content-end">
                                        <div class="col-lg-10">
                                            <button type="submit" class="btn btn-primary">Ubah User</button>
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

        $(function() {
            $(":input").inputmask();
        });
    </script>

@endpush