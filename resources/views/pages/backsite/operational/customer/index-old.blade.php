@extends('layouts.app')

@section('title', 'Pelanggan')

@section('content')

<main>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Pelanggan ✨</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Delete button -->
                <div class="table-items-action hidden">
                    <div class="flex items-center">
                        <div class="hidden xl:block text-sm italic mr-2 whitespace-nowrap"><span class="table-items-count"></span> dipilih</div>
                        <button class="btn bg-white border-slate-200 hover:border-slate-300 text-rose-500 hover:text-rose-600">Hapus</button>
                    </div>
                </div>
                <!-- End delete button -->                

                <!-- Add customer button -->
                <div x-data="{ modalOpen: false }">
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" @click.prevent="modalOpen = true">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Pelanggan Baru</span>
                    </button>

                    <div
                        class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                        x-show="modalOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-out duration-100"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        aria-hidden="true"
                        x-cloak>
                    </div>

                    {{-- Modal Dialog --}}
                    <div
                        id="feedback-modal"
                        class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                        role="dialog"
                        aria-modal="true"
                        x-show="modalOpen"
                        x-transition:enter="transition ease-in-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in-out duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-4"
                        x-cloak>

                        <div class="bg-white rounded shadow-lg overflow-auto max-w-lg w-full max-h-full" @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">    
                            {{-- Modal Header --}}
                            <div class="px-5 py-3 border-b border-slate-200">
                                <div class="flex justify-between items-center">
                                    <div class="font-semibold text-slate-800">Tambah Pelanggan Baru</div>
                                    <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                        <div class="sr-only">Tutup</div>
                                        <svg class="w-4 h-4 fill-current">
                                            <path d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            {{-- End Modal Header --}}

                            <form class="form form-horizontal" action="{{ route('backsite.customer.store') }}" method="POST">
                                @csrf
                                {{-- Modal content --}}
                                <div class="px-5 py-4">
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="name">Nama Pelanggan<span class="text-rose-500">*</span></label>
                                            <input id="name" name="name" class="form-input w-full px-2 py-1" placeholder="Nama Lengkap" value="{{old('name')}}" required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="contact">Nomer Telepon<span class="text-rose-500">*</span></label>
                                            <input id="contact" name="contact" class="form-input w-full px-2 py-1" placeholder="Nomer Telepon" value="{{old('contact')}}" required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="address">Alamat<span class="text-rose-500">*</span></label>
                                            <input id="address" name="address" class="form-input w-full px-2 py-1" placeholder="Alamat" value="{{old('address')}}" required/>
                                        </div>
                                        </div>
                                </div>
                                {{-- End Modal Content --}}                            

                                {{-- Start Modal footer --}}
                                <div class="px-5 py-4 border-t border-slate-200">
                                    <div class="flex flex-wrap justify-end space-x-2">
                                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600" @click="modalOpen = false">Batal</button>
                                        <button type="submit" class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Buat Data Pelanggan</button>
                                    </div>
                                </div>
                                {{-- End Modal Footer --}}
                            </form>

                        </div>
                    </div>
                    {{-- End Modal Dialog --}}
                </div>
                <!-- End add customer button -->

            </div>
            <!-- End Right: Actions -->
        </div>


        <!-- Table -->
        <div class="bg-white shadow-lg rounded-sm border border-slate-200">
            <header class="px-5 py-4">
                <h2 class="font-semibold text-slate-800">Semua <span class="text-slate-400 font-medium">248</span></h2>
            </header>
            <div x-data="handleSelect">

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <!-- Table header -->
                        <thead class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                            <tr>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="flex items-center">
                                        <label class="inline-flex">
                                            <span class="sr-only">Select all</span>
                                            <input id="parent-checkbox" class="form-checkbox" type="checkbox" @click="toggleAll" />
                                        </label>
                                    </div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Nama</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Alamat</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Nomer Telepon</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Proses Servis</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Selesai Servis</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Total Servis</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Aksi</div>
                                </th>
                            </tr>
                        </thead>

                        <!-- Table body -->
                        <tbody class="text-sm divide-y divide-slate-200">
                            @foreach($customer as $customer_item)
                            <!-- Row -->
                            <tr>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="flex items-center">
                                        <label class="inline-flex">
                                            <span class="sr-only">Select</span>
                                            <input class="table-item form-checkbox" type="checkbox" @click="uncheckParent" />
                                        </label>
                                    </div>
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="font-medium text-slate-800">{{$customer_item->name}}</div>
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left">{{$customer_item->address}}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left">{{$customer_item->contact}}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-center">0<div></div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-center text-sky-500">0</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-center text-emerald-500">0</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    {{-- <form onsubmit="return confirm('Apakah anda yakin untuk menghapus data?');" action="{{ route('backsite.customer.destroy', $customer_item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                            <div class="space-x-1">
                                                <a href="{{ route('backsite.customer.edit', $customer_item->id) }}">
                                                    <svg class="w-8 h-8 fill-current text-slate-400 hover:text-slate-500" viewBox="0 0 32 32">
                                                        <path d="M19.7 8.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM12.6 22H10v-2.6l6-6 2.6 2.6-6 6zm7.4-7.4L17.4 12l1.6-1.6 2.6 2.6-1.6 1.6z" />
                                                    </svg>
                                                </a>
                                                <button type="submit" class="text-rose-500 hover:text-rose-600">
                                                    <span class="sr-only">Delete</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                        <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375z" />
                                                        <path fill-rule="evenodd" d="M3.087 9l.54 9.176A3 3 0 006.62 21h10.757a3 3 0 002.995-2.824L20.913 9H3.087zm6.133 2.845a.75.75 0 011.06 0l1.72 1.72 1.72-1.72a.75.75 0 111.06 1.06l-1.72 1.72 1.72 1.72a.75.75 0 11-1.06 1.06L12 15.685l-1.72 1.72a.75.75 0 11-1.06-1.06l1.72-1.72-1.72-1.72a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                    </form> --}}

                                    <div>
                                        <div x-data="{ open: false }">
                                            <button
                                                class="text-slate-400 hover:text-slate-500 rounded-full"
                                                :class="{ 'bg-slate-100 text-slate-500': open }"
                                                aria-haspopup="true"
                                                @click.prevent="open = !open"
                                                :aria-expanded="open">
                                                <span class="sr-only">Menu</span>
                                                <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                    <circle cx="16" cy="16" r="2" />
                                                    <circle cx="10" cy="16" r="2" />
                                                    <circle cx="22" cy="16" r="2" />
                                                </svg>
                                            </button>

                                            <div
                                            class="origin-top-right z-10 absolute top-full left-0 min-w-36 bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1"                
                                            @click.outside="open = false"
                                            @keydown.escape.window="open = false"
                                            x-show="open"
                                            x-transition:enter="transition ease-out duration-200 transform"
                                            x-transition:enter-start="opacity-0 -translate-y-2"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-out duration-200"
                                            x-transition:leave-start="opacity-100"
                                            x-transition:leave-end="opacity-0"
                                            x-cloak>
                                            <ul>
                                                <li>
                                                    <a class="font-medium text-sm text-slate-600 hover:text-slate-800 flex py-1 px-3" href="#0" @click="open = false" @focus="open = true" @focusout="open = false">Option 1</a>
                                                </li>
                                                <li>
                                                    <a class="font-medium text-sm text-slate-600 hover:text-slate-800 flex py-1 px-3" href="#0" @click="open = false" @focus="open = true" @focusout="open = false">Option 2</a>
                                                </li>
                                                <li>
                                                    <a class="font-medium text-sm text-rose-500 hover:text-rose-600 flex py-1 px-3" href="#0" @click="open = false" @focus="open = true" @focusout="open = false">Remove</a>
                                                </li>
                                            </ul>
                                        </div>
                                        </div>
                                        <!-- End -->
                                    </div>
                                </td>
                            </tr>
                            @endforeach
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
        <div class="mt-8">
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

    </div>
</main>

@endsection