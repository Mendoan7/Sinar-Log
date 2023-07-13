@extends('layouts.default')

@section('title', 'Home')

@section('content')

<section class="relative pt-32 pb-24 bg-white overflow-hidden">
    <div class="relative z-10 container px-4 mx-auto">
      <div class="max-w-2xl mx-auto">

        <div class="mb-4">
            <a class="text-blue-600 hover:text-blue-700 font-medium" href="/tracking"><span class="tracking-normal">&lt;-</span>Kembali</a>
        </div>

        <div class="max-w-4xl mx-auto mb-8 text-center">
            <span class="inline-block py-px px-2 mb-4 text-xs leading-5 text-blue-500 bg-blue-100 font-medium uppercase rounded-full shadow-sm">Pantau Servis</span>
            <h3 class="mb-4 text-3xl md:text-4xl leading-tight font-bold tracking-tighter">Ketahui Status Perbaikan</h3>
            <p class="text-lg md:text-xl text-coolGray-500 font-medium">Berikut ini semua data perbaikan kamu di Sinar Cell</p>
        </div>
        
            <div class="pb-8 md:pb-16">
                <!-- List container -->
                <div class="flex flex-col">
                    
                    <!-- Item -->
                    @foreach ($track->service as $track_item)
                    <div class="[&:nth-child(-n+12)]:-order-1 border-b border-gray-200 group">
                        <div class="px-4 py-6">
                            <div class="sm:flex items-center space-y-3 sm:space-y-0 sm:space-x-5">
                                
                                <div class="grow lg:flex items-center justify-between space-y-5 lg:space-x-2 lg:space-y-0">
                                    <div>
                                        <div class="flex items-start">
                                            <div class="text-sm text-gray-800 font-semibold mb-1">#{{ $track_item->kode_servis }}</div>
                                        </div>
                                        <div class="flex items-start mb-2">
                                            <div class="text-lg text-gray-800 font-bold">{{ $track_item->jenis }} {{ $track_item->tipe }}</div>
                                        </div>
                                        <div class="flex flex-row">
                                            @if($track_item->status == 1)
                                                <li class="flex items-center space-x-2">
                                                    <span>Status :</span>
                                                    <span class="text-xs inline-flex font-medium text-white bg-gray-500 rounded-full text-center px-2.5 py-1">{{ 'Belum Cek' }}</span>
                                                </li>
                                                @elseif($track_item->status == 2)
                                                <li class="flex items-center space-x-2">
                                                    <span>Status :</span>
                                                    <span class="text-xs inline-flex font-medium text-white bg-yellow-500 rounded-full text-center px-2.5 py-1">{{ 'Akan Dikerjakan' }}</span>
                                                </li>
                                                @elseif($track_item->status == 3)
                                                <li class="flex items-center space-x-2">
                                                    <span>Status :</span>
                                                    <span class="text-xs inline-flex font-medium text-white bg-blue-500 rounded-full text-center px-2.5 py-1">{{ 'Sedang Cek' }}</span>
                                                </li>
                                                @elseif($track_item->status == 4)
                                                <li class="flex items-center space-x-2">
                                                    <span>Status :</span>
                                                   <span class="text-xs inline-flex font-medium text-white bg-green-500 rounded-full text-center px-2.5 py-1">{{ 'Sedang Dikerjakan' }}</span>
                                                </li>
                                                @elseif($track_item->status == 5)
                                                <li class="flex items-center space-x-2">
                                                    <span>Status :</span>
                                                    <span class="text-xs inline-flex font-medium text-white bg-gray-500 rounded-full text-center px-2.5 py-1">{{ 'Sedang Tes' }}</span>
                                                </li>
                                                @elseif($track_item->status == 6)
                                                <li class="flex items-center space-x-2">
                                                    <span>Status :</span>
                                                    <span class="text-xs inline-flex font-medium text-white bg-red-500 rounded-full text-center px-2.5 py-1">{{ 'Menunggu Konfirmasi' }}</span>
                                                </li>
                                                @elseif($track_item->status == 7)
                                                <li class="flex items-center space-x-2">
                                                    <span>Status :</span>
                                                    <span class="text-xs inline-flex font-medium text-white bg-indigo-500 rounded-full text-center px-2.5 py-1">{{ 'Menunggu Sparepart' }}</span> 
                                                </li>
                                                @elseif($track_item->status == 8)
                                                <li class="flex items-center space-x-2">
                                                    <span>Status :</span>
                                                    <span class="text-xs inline-flex font-medium text-white bg-blue-500 rounded-full text-center px-2.5 py-1">{{ 'Bisa Diambil' }}</span>
                                                </li>
                                                @elseif($track_item->status == 9)
                                                <li class="flex items-center space-x-2">
                                                    <span>Status :</span>
                                                    <span class="text-xs inline-flex font-medium text-white bg-green-500 rounded-full text-center px-2.5 py-1">{{ 'Sudah Diambil' }}</span>
                                                </li>
                                                @elseif($track_item->status == 10)
                                                <li class="flex items-center space-x-2">
                                                    <span>Status :</span>
                                                    <span class="text-xs inline-flex font-medium text-green-500 bg-green-100 rounded-full text-center px-2.5 py-1">{{ 'Terkonfirmasi Setuju' }}</span>
                                                </li>
                                                @elseif($track_item->status == 11)
                                                <li class="flex items-center space-x-2">
                                                    <span>Status :</span>
                                                    <span class="text-xs inline-flex font-medium text-red-500 bg-red-100 rounded-full text-center px-2.5 py-1">{{ 'Terkonfirmasi Menolak' }}</span>
                                                </li>
                                                @elseif($track_item->service_detail->transaction->warranty_history->status == 1)
                                                <li class="flex items-center space-x-2">
                                                    <span>Status :</span>
                                                    <span class="text-xs inline-flex font-medium text-white bg-yellow-500 rounded-full text-center px-2.5 py-1">{{ 'Proses Garansi' }}</span>
                                                </li>
                                                @elseif($track_item->service_detail->transaction->warranty_history->status == 2)
                                                <li class="flex items-center space-x-2">
                                                    <span>Status :</span>
                                                    <span class="text-xs inline-flex font-medium text-white bg-blue-500 rounded-full text-center px-2.5 py-1">{{ 'Garansi Bisa Diambil' }}</span>
                                                </li>
                                                @elseif($track_item->service_detail->transaction->warranty_history->status == 3)
                                                <li class="flex items-center space-x-2">
                                                    <span>Status :</span>
                                                    <span class="text-xs inline-flex font-medium text-white bg-green-500 rounded-full text-center px-2.5 py-1">{{ 'Garansi Sudah Diambil' }}</span>
                                                </li>
                                                @else
                                                    <a>{{ 'N/A' }}</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="min-w-[120px] flex items-center lg:justify-end space-x-3 lg:space-x-0">
                                        <div class="lg:hidden group-hover:lg:block">
                                            <a class="btn-sm py-1.5 px-3 text-white bg-blue-600 hover:bg-blue-700 group shadow-sm" href="{{ route('tracking.show', $track_item->id) }}">
                                                View <span class="tracking-normal text-white group-hover:translate-x-0.5 transition-transform duration-150 ease-in-out ml-1">-&gt;</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>

      </div>
    </div>
</section>


  {{-- <div class="w-full max-w-xs">
    <h2>{{ $customers->name }} ({{ $customers->contact }})</h2>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Kode Servis</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($customers->service as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_servis }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p class="text-center text-gray-500 text-xs">
      &copy;2020 Acme Corp. All rights reserved.
    </p>
  </div> --}}

@endsection