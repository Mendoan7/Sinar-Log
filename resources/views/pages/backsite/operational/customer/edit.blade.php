@extends('layouts.app')

@section('title', ' Edit - Pelanggan')

@section('content')

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit Data Pelanggan</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Edit Pelanggan</h4>
                            <form class="form form-horizontal" action="{{ route("backsite.customer.update", [$customer->id]) }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                
                                <div class="form-body">

                                    <div class="row mb-4">
                                        <label for="name" class="col-form-label col-lg-2">Nama</label>
                                        <div class="col-lg-10">
                                            <input id="name" name="name" type="text" class="form-control" placeholder="example admin or users" value="{{ old('name', isset($customer) ? $customer->name : '') }}" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="contact" class="col-form-label col-lg-2">Nomer Telepon</label>
                                        <div class="col-lg-10">
                                            <input id="contact" name="contact" type="text" class="form-control" placeholder="example admin or users" value="{{ old('contact', isset($customer) ? $customer->contact : '') }}" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="email" class="col-form-label col-lg-2">Email</label>
                                        <div class="col-lg-10">
                                            <input id="email" name="email" type="text" class="form-control" placeholder="example admin or users" value="{{ old('email', isset($customer) ? $customer->email : '') }}" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="address" class="col-form-label col-lg-2">Alamat</label>
                                        <div class="col-lg-10">
                                            <input id="address" name="address" type="text" class="form-control" placeholder="example admin or users" value="{{ old('address', isset($customer) ? $customer->address : '') }}" autocomplete="off">
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