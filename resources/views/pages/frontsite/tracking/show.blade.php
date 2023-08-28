@extends('layouts.default')

@section('title', 'Home')

@section('content')

    <section class="relative pt-32 pb-24 bg-white overflow-hidden">
        <div class="relative z-10 container px-4 mx-auto">
            <div class="max-w-2xl mx-auto">

                <form action="{{ route('tracking.track') }}" method="post" class="inline-block">
                    @csrf
                    <input type="hidden" name="contact" value="{{ $service->customer->contact }}">
                    <button type="submit" class="text-blue-600 hover:text-blue-700 font-medium"><span class="tracking-normal">&lt;-</span>Kembali</button>
                </form>

                <div class="max-w-4xl mx-auto mb-8 text-center">
                    <span class="inline-block py-px px-2 mb-4 text-xs leading-5 text-blue-500 bg-blue-100 font-medium uppercase rounded-full shadow-sm">Pantau Servis</span>
                    <h3 class="mb-4 text-3xl md:text-4xl leading-tight font-bold tracking-tighter">Detail Perbaikan</h3>
                    <p class="text-lg md:text-xl text-coolGray-500 font-medium">Berikut perbaikan untuk kode servis {{ $service->kode_servis }}</p>
                </div>
            
                <div class="mb-8 relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        @if ($service_detail?->warranty_history?->status == 1 || $service_detail?->warranty_history?->status == 2 || $service_detail?->warranty_history?->status == 3 )
                        <tbody>
                            <tr class="bg-gray-100 border-b">
                                <th colspan="2" class="px-6 py-4 text-lg text-center font-bold text-gray-900 whitespace-nowrap">Informasi Klaim Servis</th>
                            </tr>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    No. Servis
                                </th>
                                <td class="px-6 py-4 font-bold">
                                    {{ isset($service->kode_servis) ? $service->kode_servis : 'N/A' }}
                                </td>
                            </tr>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    Tgl. Klaim
                                </th>
                                <td class="px-6 py-4">
                                    {{ $service_detail->warranty_history['created_at']->isoFormat('dddd, D MMMM Y HH:mm') ?? 'N/A' }} WIB
                                </td>
                            </tr>
                            <tr class="bg-white border-b font-bold">
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
                                    Kerusakan Awal
                                </th>
                                <td class="px-6 py-4">
                                    {{ isset($service_detail->kerusakan) ? $service_detail->kerusakan : 'N/A' }}
                                </td>
                            </tr>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    Tindakan Sebelumnya
                                </th>
                                <td class="px-6 py-4">
                                    @if(isset($service_detail->tindakan))
                                        {{ implode(', ', json_decode($service_detail->tindakan)) }}
                                    @endif
                                </td>
                            </tr>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    Keterangan Klaim
                                </th>
                                <td class="px-6 py-4">
                                    {{ isset($service_detail->warranty_history->keterangan) ? $service_detail->warranty_history->keterangan : 'N/A' }}
                                </td>
                            </tr>

                            @if ($service_detail?->warranty_history?->status == 2 || $service_detail?->warranty_history?->status == 3)
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Kondisi
                                    </th>
                                    <td class="px-6 py-4">
                                        @if($service_detail->warranty_history->kondisi == 1)
                                            <span class="text-xs inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-1">{{ 'Sudah Jadi' }}</span>
                                        @elseif($service_detail->warranty_history->kondisi == 2)
                                            <span class="text-xs inline-flex font-medium bg-rose-100 text-rose-600 rounded-full text-center px-2.5 py-1">{{ 'Tidak Bisa' }}</span>
                                        @elseif($service_detail->warranty_history->kondisi == 3)
                                            <span class="text-xs inline-flex font-medium bg-slate-100 text-slate-600 rounded-full text-center px-2.5 py-1">{{ 'Dibatalkan' }}</span>       
                                        @endif
                                    </td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Tindakan
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ isset($service_detail->warranty_history->tindakan) ? $service_detail->warranty_history->tindakan : 'N/A' }}
                                    </td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Catatan
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ isset($service_detail->warranty_history->catatan) ? $service_detail->warranty_history->catatan : 'N/A' }}
                                    </td>
                                </tr>
                            @endif

                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    Status
                                </th>
                                <td class="px-6 py-4">
                                    @if($service_detail->warranty_history->status == 1)
                                        <span class="text-xs inline-flex font-medium text-white bg-yellow-500 rounded-full text-center px-2.5 py-1">{{ 'Proses Garansi' }}</span>
                                    @elseif($service_detail->warranty_history->status == 2)
                                        <span class="text-xs inline-flex font-medium text-white bg-blue-600 rounded-full text-center px-2.5 py-1">{{ 'Garansi Bisa Diambil' }}</span>
                                    @elseif($service_detail->warranty_history->status == 3)
                                        <span class="text-xs inline-flex font-medium text-white bg-green-600 rounded-full text-center px-2.5 py-1">{{ 'Sudah Diambil' }}</span>         
                                    @endif
                                </td>
                            </tr>  

                            @if($service_detail?->warranty_history?->status == 3)
                                <tr class="bg-gray-100 border-b">
                                    <th colspan="2" class="px-6 py-4 text-lg text-center font-bold text-gray-900 whitespace-nowrap">Detail Garansi</th>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Tgl. Ambil
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $service_detail->warranty_history['created_at']->isoFormat('dddd, D MMMM Y HH:mm') }} WIB
                                    </td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Pengambil
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ isset($service_detail->warranty_history->pengambil) ? $service_detail->warranty_history->pengambil : 'N/A' }}
                                    </td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Garansi
                                    </th>
                                    @if ($service_detail->garansi == 0)
                                        <td class="px-6 py-4">Tidak Ada</td>
                                    @else
                                        <td class="px-6 py-4">{{ $service_detail->garansi }} Hari</td>
                                    @endif
                                </tr>
                                @if ($service_detail->garansi > 0)
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Garansi Berakhir
                                    </th>
                                    <td class="px-6 py-4">{{ $warrantyInfo[$service->id]['end_warranty']->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Status Garansi
                                    </th>
                                    @if ($warrantyInfo[$service->id]['end_warranty'] < now())
                                        <td class="px-6 py-4">Hangus</td>
                                    @else
                                        <td class="px-6 py-4">Tersisa {{ $warrantyInfo[$service->id]['sisa_warranty'] }}</td>
                                    @endif
                                </tr>
                                @endif
                            @endif
                        </tbody>
                        @else
                        <tbody>
                            <tr class="bg-gray-100 border-b">
                                <th colspan="2" class="px-6 py-4 text-lg text-center font-bold text-gray-900 whitespace-nowrap">Informasi Servis</th>
                            </tr>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    No. Servis
                                </th>
                                <td class="px-6 py-4 font-bold">
                                    {{ isset($service->kode_servis) ? $service->kode_servis : 'N/A' }}
                                </td>
                            </tr>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    Tgl. Masuk
                                </th>
                                <td class="px-6 py-4">
                                    {{ $service->created_at->isoFormat('dddd, D MMMM Y HH:mm') ?? 'N/A' }} WIB
                                </td>
                            </tr>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    Pemilik
                                </th>
                                <td class="px-6 py-4 font-bold">
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
                                    {{ isset($service_detail->kerusakan) ? $service_detail->kerusakan : 'N/A' }}
                                </td>
                            </tr>

                            @if ($service->status === '8' || $service->status === '9')
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
                                        - {{ \Carbon\Carbon::parse($service->date_done)->isoFormat('dddd, D MMMM Y HH:mm') ?? 'N/A' }} WIB
                                    </td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Tindakan
                                    </th>
                                    <td class="px-6 py-4">
                                        @if(isset($service_detail->tindakan))
                                            {{ implode(', ', json_decode($service_detail->tindakan)) }}
                                        @endif
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

                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    Status
                                </th>
                                <td class="px-6 py-4">
                                    @if($service->status == 1)
                                        <span class="text-xs inline-flex font-medium text-white bg-gray-500 rounded-full text-center px-2.5 py-1">{{ 'Belum Cek' }}</span>
                                    @elseif($service->status == 2)
                                        <span class="text-xs inline-flex font-medium text-white bg-yellow-500 rounded-full text-center px-2.5 py-1">{{ 'Akan Dikerjakan' }}</span>
                                    @elseif($service->status == 3)
                                        <span class="text-xs inline-flex font-medium text-white bg-blue-500 rounded-full text-center px-2.5 py-1">{{ 'Sedang Cek' }}</span>
                                    @elseif($service->status == 4)
                                        <span class="text-xs inline-flex font-medium text-white bg-green-500 rounded-full text-center px-2.5 py-1">{{ 'Sedang Dikerjakan' }}</span>
                                    @elseif($service->status == 5)
                                        <span class="text-xs inline-flex font-medium text-white bg-gray-500 rounded-full text-center px-2.5 py-1">{{ 'Sedang Tes' }}</span>
                                    @elseif($service->status == 6)
                                        <span class="text-xs inline-flex font-medium text-white bg-red-500 rounded-full text-center px-2.5 py-1">{{ 'Menunggu Konfirmasi' }}</span>        
                                    @elseif($service->status == 7)
                                        <span class="text-xs inline-flex font-medium text-white bg-indigo-500 rounded-full text-center px-2.5 py-1">{{ 'Menunggu Sparepart' }}</span>
                                    @elseif($service->status == 8)
                                        <span class="text-xs inline-flex font-medium text-white bg-blue-500 rounded-full text-center px-2.5 py-1">{{ 'Bisa Diambil' }}</span>
                                    @elseif($service->status == 9)
                                        <span class="text-xs inline-flex font-medium text-white bg-green-500 rounded-full text-center px-2.5 py-1">{{ 'Sudah Diambil' }}</span>
                                    @elseif($service->status == 10)
                                        <span class="text-xs inline-flex font-medium text-green-500 bg-green-100 rounded-full text-center px-2.5 py-1">{{ 'Terkonfirmasi Setuju' }}</span>
                                    @elseif($service->status == 11)
                                        <span class="text-xs inline-flex font-medium text-red-500 bg-red-100 rounded-full text-center px-2.5 py-1">{{ 'Terkonfirmasi Menolak' }}</span>            
                                    @endif
                                </td>
                            </tr>

                            @if($service->status === '9')
                                <tr class="bg-gray-100 border-b">
                                    <th colspan="2" class="px-6 py-4 text-lg text-center font-bold text-gray-900 whitespace-nowrap">Detail Garansi</th>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Tgl. Ambil
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($service->date_out)->isoFormat('dddd, D MMMM Y HH:mm') ?? 'N/A' }} WIB
                                    </td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Pengambil
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ isset($service->pengambil) ? $service->pengambil : 'N/A' }}
                                    </td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Garansi
                                    </th>
                                    @if ($service_detail->garansi == 0)
                                        <td class="px-6 py-4">Tidak Ada</td>
                                    @else
                                        <td class="px-6 py-4">{{ $service_detail->garansi }} Hari</td>
                                    @endif
                                </tr>
                                @if ($service_detail->garansi > 0)
                                    <tr class="bg-white border-b">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            Garansi Berakhir
                                        </th>
                                        <td class="px-6 py-4">{{ $warrantyInfo[$service->id]['end_warranty']->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            Status Garansi
                                        </th>
                                        @if ($warrantyInfo[$service->id]['end_warranty'] < now())
                                            <td class="px-6 py-4">Hangus</td>
                                        @else
                                            <td class="px-6 py-4">Tersisa {{ $warrantyInfo[$service->id]['sisa_warranty'] }}</td>
                                        @endif
                                    </tr>
                                @endif
                            @endif

                        </tbody>
                        @endif
                    </table>
                </div>

                @if ($buttonSisa)
                    <form action="{{ route('tracking.track') }}" method="post">
                        @csrf
                        <input type="hidden" name="contact" value="{{ $service->customer->contact }}">
                        <button type="submit" class="inline-block py-3 px-7 w-full text-base text-white font-medium text-center leading-6 bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm">{{ $buttonSisa }}</button>
                    </form>
                @endif

            </div>
        </div>
    </section>

@endsection