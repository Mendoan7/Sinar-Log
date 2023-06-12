@extends('layouts.default')

@section('title', 'Konfirmasi Servis')

@section('content')

<section class="bg-gradient-to-b from-gray-100 to-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="pt-32 pb-12 md:pt-40 md:pb-20">

            <!-- Page header -->
            <div class="max-w-3xl mx-auto text-center pb-8 md:pb-12">
                <h3 class="mb-4 text-3xl md:text-4xl leading-tight font-bold tracking-tighter">Konfirmasi Servis</h3>
                <p class="text-lg md:text-xl text-gray-600">Terima kasih telah memilih layanan servis kami. Sebelum kami melanjutkan dengan perbaikan, kami membutuhkan konfirmasi Anda mengenai tindakan dan biaya servis yang akan dilakukan.</p>
            </div>

            <!-- Form -->
            <div class="max-w-sm mx-auto">
                <form>
                    <div class="flex flex-wrap -mx-3 mb-4">
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
                                        Kerusakan
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ isset($service->kerusakan) ? $service->kerusakan : 'N/A' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-4">
                        <table class="w-full text-sm text-left text-gray-500">
                            <tbody>
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
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-sm text-gray-600 mt-4 mb-6">Mohon periksa informasi di atas dengan teliti. 
                        Jika Anda setuju dengan tindakan dan biaya servis yang kami tawarkan, silakan klik tombol <a class="font-bold">"Setuju"</a> di bawah ini. 
                        Namun, jika anda ingin membatalkan servis, silakan pilih tombol <a class="font-bold">"Batalkan Servis"</a>
                    </div>
                    
                    <div class="flex flex-wrap -mx-3 mb-3">
                        <div class="w-full px-3">
                            <button class="btn text-white bg-blue-600 hover:bg-blue-700 w-full">Setuju</button>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3">
                        <div class="w-full px-3">
                            <button class="btn text-white bg-gray-600 hover:bg-gray-700 w-full">Batalkan Servis</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="max-w-3xl mx-auto text-center pt-8 md:pt-12">
                <p class="text-lg md:text-xl text-gray-600">Kami menghargai kepercayaan Anda kepada kami dan siap untuk memberikan layanan terbaik. 
                    Jika Anda memiliki pertanyaan lebih lanjut atau membutuhkan bantuan, jangan ragu untuk menghubungi kami. Terima kasih atas kerja samanya.
                </p>
            </div>

        </div>
    </div>
</section>

@endsection