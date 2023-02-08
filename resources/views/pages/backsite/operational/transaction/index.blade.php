@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')

{{-- <main>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-5">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Sudah Diambil</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Create invoice button -->
                <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Servis Baru</span>
                </button>

            </div>

        </div>

        <!-- More actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-5">
        
            <!-- Left side -->
            <div class="mb-4 sm:mb-0">
                <ul class="flex flex-wrap -m-1">
                    <li class="m-1">
                        <button class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-transparent shadow-sm bg-indigo-500 text-white duration-150 ease-in-out">Semua <span class="ml-1 text-indigo-200">67</span></button>
                    </li>
                    <li class="m-1">
                        <button class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">Sudah Jadi <span class="ml-1 text-slate-400">14</span></button>
                    </li>
                    <li class="m-1">
                        <button class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">Tidak Bisa <span class="ml-1 text-slate-400">34</span></button>
                    </li>
                    <li class="m-1">
                        <button class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">Dibatalkan <span class="ml-1 text-slate-400">19</span></button>
                    </li>
                </ul>
            </div>
        
            <!-- Right side -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Delete button -->
                <div class="table-items-action hidden">
                    <div class="flex items-center">
                        <div class="hidden xl:block text-sm italic mr-2 whitespace-nowrap"><span class="table-items-count"></span> dipilih</div>
                        <button class="btn bg-white border-slate-200 hover:border-slate-300 text-rose-500 hover:text-rose-600">Hapus</button>
                    </div>
                </div>

                <!-- Search form -->
                <form class="relative">
                    <label for="action-search" class="sr-only">Cari</label>
                    <input id="action-search" class="form-input pl-9 focus:border-slate-300" type="search" placeholder="Cari Data Servis" />
                    <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                        <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                            <path d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                        </svg>
                    </button>
                </form>
       
            </div>
        
        </div>

        <!-- Table -->
        <div class="bg-white shadow-lg rounded-sm border border-slate-200 mb-8">
            <header class="px-5 py-4">
                <h2 class="font-semibold text-slate-800">Servis <span class="text-slate-400 font-medium">67</span></h2>
            </header>
            <div x-data="handleSelect">

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <!-- Table header -->
                        <thead class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                            <tr>
                                <th class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="flex items-center">
                                        <label class="inline-flex">
                                            <span class="sr-only">Select all</span>
                                            <input id="parent-checkbox" class="form-checkbox" type="checkbox" @click="toggleAll" />
                                        </label>
                                    </div>
                                </th>
                                <th class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">No. Servis</div>
                                </th>
                                <th class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Pemilik</div>
                                </th>
                                <th class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Barang</div>
                                </th>
                                <th class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Kerusakan</div>
                                </th>
                                <th class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Kondisi</div>
                                </th>
                                <th class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Tindakan</div>
                                </th>
                                <th class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Biaya</div>
                                </th>
                                <th class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Teknisi</div>
                                </th>
                                <th class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Tgl Ambil</div>
                                </th>
                                <th class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Status</div>
                                </th>
                                <th class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Garansi</div>
                                </th>
                                <th class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Aksi</div>
                                </th>
                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody class="text-sm divide-y divide-slate-200">
                            <!-- Row -->
                            <tr>
                                <td class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="flex items-center">
                                        <label class="inline-flex">
                                            <span class="sr-only">Select</span>
                                            <input class="table-item form-checkbox" type="checkbox" @click="uncheckParent" />
                                        </label>
                                    </div>
                                </td>
                                <td class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-sky-500">#143567</div>
                                </td>
                                <td class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800">Edwin</div>
                                </td>
                                <td class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div>Poco X3</div>
                                </td>
                                <td class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div>Stuck Logo</div>
                                </td>
                                <td class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="inline-flex font-medium bg-blue-100 text-blue-500 rounded-full text-center px-2.5 py-0.5">Sudah Jadi</div>
                                </td>
                                <td class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div>Flash</div>
                                </td>
                                <td class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div>Rp.200000</div>
                                </td>
                                <td class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div>Muja</div>
                                </td>
                                <td class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div>22/07/2021</div>
                                </td>
                                <td class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="inline-flex font-medium bg-blue-100 text-blue-500 rounded-full text-center px-2.5 py-0.5">Sudah Diambil</div>
                                </td>
                                <td class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div>2 Minggu</div>
                                </td>
                                <td class="px-3 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="space-x-1">
                                        <button class="text-slate-400 hover:text-slate-500 rounded-full">
                                            <span class="sr-only">Edit</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                                <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                                            </svg>  
                                        </button>
                                        <button class="text-slate-400 hover:text-slate-500 rounded-full">
                                            <span class="sr-only">Info</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <button class="text-slate-400 hover:text-slate-500 rounded-full">
                                            <span class="sr-only">Chat</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                                            </svg>                                              
                                        </button>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <script>
            // A basic demo function to handle "select all" functionality
            document.addEventListener('alpine:init', () => {
                Alpine.data('handleSelect', () => ({
                    selectall: false,
                    selectAction() {
                        countEl = document.querySelector('.table-items-action');
                        if (!countEl) return;
                        checkboxes = document.querySelectorAll('input.table-item:checked');
                        document.querySelector('.table-items-count').innerHTML = checkboxes.length;
                        if (checkboxes.length > 0) {
                            countEl.classList.remove('hidden');
                        } else {
                            countEl.classList.add('hidden');
                        }
                    },
                    toggleAll() {
                        this.selectall = !this.selectall;
                        checkboxes = document.querySelectorAll('input.table-item');
                        [...checkboxes].map((el) => {
                            el.checked = this.selectall;
                        });
                        this.selectAction();
                    },
                    uncheckParent() {
                        this.selectall = false;
                        document.getElementById('parent-checkbox').checked = false;
                        this.selectAction();
                    }
                }))
            })
        </script>
        
        <!-- Pagination -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <nav class="mb-4 sm:mb-0 sm:order-1" role="navigation" aria-label="Navigation">
                <ul class="flex justify-center">
                    <li class="ml-3 first:ml-0">
                        <a class="btn bg-white border-slate-200 text-slate-300 cursor-not-allowed" href="#0" disabled>&lt;- Previous</a>
                    </li>
                    <li class="ml-3 first:ml-0">
                        <a class="btn bg-white border-slate-200 hover:border-slate-300 text-indigo-500" href="#0">Next -&gt;</a>
                    </li>
                </ul>
            </nav>
            <div class="text-sm text-slate-500 text-center sm:text-left">
                Showing <span class="font-medium text-slate-600">1</span> to <span class="font-medium text-slate-600">10</span> of <span class="font-medium text-slate-600">467</span> results
            </div>
        </div>

    </div>
</main> --}}

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Jobs List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Jobs</a></li>
                                <li class="breadcrumb-item active">Jobs List</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body border-bottom">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 card-title flex-grow-1">Sudah Diambil</h5>
                                <div class="flex-shrink-0">
                                    <a href="#!" class="btn btn-primary">Add New Job</a>
                                    <div class="dropdown d-inline-block">

                                        <button type="menu" class="btn btn-success" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="datatable" class="table table-striped mb-0 table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No. Servis</th>
                                        <th scope="col">Tgl. Penerima</th>
                                        <th scope="col">Pemilik</th>
                                        <th scope="col">Barang</th>
                                        <th scope="col">Kerusakan</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Ubah Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">#2901999</th>
                                        <td>04 Agu 2022</td>
                                        <td>Mendoan</td>
                                        <td>Hp Redmi Note 5</td>
                                        <td>Stuck Logo</td>
                                        <td><span class="badge bg-success">Belum Cek</span></td>
                                        <td>
                                            <ul class="list-unstyled hstack gap-1 mb-0">
                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                    <a href="job-details.html" class="btn btn-sm btn-soft-primary"><i class="mdi mdi-eye-outline"></i></a>
                                                </li>
                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                    <a href="#" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>
                                                </li>
                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                    <a href="#jobDelete" data-bs-toggle="modal" class="btn btn-sm btn-soft-danger"><i class="mdi mdi-delete-outline"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
    <div class="modal fade" id="jobDelete" tabindex="-1" aria-labelledby="jobDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body px-4 py-5 text-center">
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="avatar-sm mb-4 mx-auto">
                        <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                            <i class="mdi mdi-trash-can-outline"></i>
                        </div>
                    </div>
                    <p class="text-muted font-size-16 mb-4">Are you sure you want to permanently erase the job.</p>
                    
                    <div class="hstack gap-2 justify-content-center mb-0">
                        <button type="button" class="btn btn-danger">Delete Now</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection