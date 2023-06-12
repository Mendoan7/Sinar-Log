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
                    <h3 class="mb-4 text-3xl md:text-4xl leading-tight font-bold tracking-tighter">Detail Perbaikan</h3>
                    <p class="text-lg md:text-xl text-coolGray-500 font-medium">Berikut perbaikan untuk kode servis {{ $service->kode_servis }}</p>
                </div>
            
                <div class="mb-8 relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <tbody>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    No. Servis
                                </th>
                                <td class="px-6 py-4">
                                    {{ isset($service->kode_servis) ? $service->kode_servis : 'N/A' }}
                                </td>
                            </tr>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    Tgl. Masuk
                                </th>
                                <td class="px-6 py-4">
                                    {{ isset($service->created_at) ? date("d/m/Y H:i:s",strtotime($service->created_at)) : '' }}
                                    [<span>{{ isset($service->penerima) ? $service->penerima : 'N/A' }}</span>]
                                </td>
                            </tr>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    Pemilik
                                </th>
                                <td class="px-6 py-4">
                                    {{ isset($service->customer->name) ? $service->customer->name : 'N/A' }}
                                </td>
                            </tr>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    Barang Servis
                                </th>
                                <td class="px-6 py-4">
                                    {{ isset($service->jenis) ? $service->jenis : 'N/A' }} {{ isset($service->tipe) ? $service->tipe : 'N/A' }}
                                </td>
                            </tr>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    Kelengkapan
                                </th>
                                <td class="px-6 py-4">
                                    {{ isset($service->kelengkapan) ? $service->kelengkapan : 'N/A' }}
                                </td>
                            </tr>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    Kerusakan
                                </th>
                                <td class="px-6 py-4">
                                    {{ isset($service->kerusakan) ? $service->kerusakan : 'N/A' }}
                                </td>
                            </tr>

                            @if ($service->status === '7' || $service->status === '8')
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Kondisi
                                    </th>
                                    <td class="px-6 py-4">
                                        @if($service_detail->kondisi == 1)
                                            <span class="text-xs inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-1">{{ 'Sudah Jadi' }}</span>
                                        @elseif($service_detail->kondisi == 2)
                                            <span class="text-xs inline-flex font-medium bg-rose-100 text-rose-600 rounded-full text-center px-2.5 py-1">{{ 'Tidak Bisa' }}</span>
                                        @elseif($service_detail->kondisi == 3)
                                            <span class="text-xs inline-flex font-medium bg-slate-100 text-slate-600 rounded-full text-center px-2.5 py-1">{{ 'Dibatalkan' }}</span>       
                                        @endif
                                        - {{ isset($service_detail->updated_at) ? date("d/m/Y H:i:s",strtotime($service_detail->updated_at)) : '' }}
                                    </td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Tindakan
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ isset($service_detail->tindakan) ? $service_detail->tindakan : 'N/A' }}
                                    </td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Biaya
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ isset($service_detail->biaya) ? 'Rp. '.number_format($service_detail->biaya) : 'N/A' }}
                                    </td>
                                </tr>
                            @endif

                            @if ($service->status <= 6)
                            <tr class="bg-gray-50 border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    Status
                                </th>
                                <td class="px-6 py-4">
                                    @if($service->status == 1)
                                        <span class="text-xs inline-flex font-medium text-white bg-slate-600 rounded-full text-center px-2.5 py-1">{{ 'Belum Cek' }}</span>
                                    @elseif($service->status == 2)
                                        <span class="text-xs inline-flex font-medium text-white bg-sky-600 rounded-full text-center px-2.5 py-1">{{ 'Sedang Cek' }}</span>
                                    @elseif($service->status == 3)
                                        <span class="text-xs inline-flex font-medium text-white bg-emerald-600 rounded-full text-center px-2.5 py-1">{{ 'Sedang Dikerjakan' }}</span>
                                    @elseif($service->status == 4)
                                        <span class="text-xs inline-flex font-medium text-white bg-amber-600 rounded-full text-center px-2.5 py-1">{{ 'Sedang Tes' }}</span>
                                    @elseif($service->status == 5)
                                        <span class="text-xs inline-flex font-medium text-white bg-rose-600 rounded-full text-center px-2.5 py-1">{{ 'Menunggu Konfirmasi' }}</span>
                                    @elseif($service->status == 6)
                                        <span class="text-xs inline-flex font-medium text-white bg-indigo-600 rounded-full text-center px-2.5 py-1">{{ 'Menunggu Sparepart' }}</span>        
                                    @endif
                                </td>
                            </tr>
                            @endif

                            @if($service->status == 7)
                                <tr class="bg-sky-50 border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Status
                                    </th>
                                    <td class="px-6 py-4">
                                        <span class="text-xs inline-flex font-medium text-white bg-blue-600 rounded-full text-center px-2.5 py-1">{{ 'Bisa Diambil' }}</span>      
                                    </td>
                                </tr>
                            @endif

                            @if($service->status == 8)
                                <tr class="bg-emerald-50 border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Status
                                    </th>
                                    <td class="px-6 py-4">
                                        <span class="text-xs inline-flex font-medium text-white bg-emerald-600 rounded-full text-center px-2.5 py-1">{{ 'Sudah Diambil' }}</span>       
                                    </td>
                                </tr>
                            @endif

                            @if($service->status === '8')
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Tgl. Ambil
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ isset($transaction->updated_at) ? date("d/m/Y H:i:s",strtotime($transaction->updated_at)) : '' }}
                                        [{{ isset($transaction->penyerah) ? $transaction->penyerah : 'N/A' }}]
                                    </td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Pengambil
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ isset($transaction->pengambil) ? $transaction->pengambil : 'N/A' }}
                                    </td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Pembayaran
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ isset($transaction->pembayaran) ? $transaction->pemabayaran : 'N/A' }}
                                    </td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Garansi
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ isset($transaction->garansi) ? $transaction->garansi : 'N/A' }}
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>

                <a class="inline-block py-3 px-7 w-full text-base text-white font-medium text-center leading-6 bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm" href="#">Tracking</a>

            </div>
        </div>
    </section>

@endsection