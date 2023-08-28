@extends('layouts.default')

@section('title', 'Konfirmasi Servis')

@section('content')

<section class="bg-gradient-to-b from-gray-100 to-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="pt-32 pb-12 md:pt-40 md:pb-20">

            @if ($status === 'approve')
            {{-- Start View Approve --}}
            <div class="max-w-3xl mx-auto text-center pb-8 md:pb-12">
                <h3 class="mb-4 text-3xl md:text-4xl leading-tight font-bold tracking-tighter">Konfirmasi Servis Berhasil</h3>
                <p class="text-lg md:text-xl text-gray-600">Terima kasih telah melakukan konfirmasi. Kami akan segera melakukan perbaikan, harap menunggu informasi kembali.</p>
                <div class="mt-8">
                    <a class="btn text-white bg-blue-600 hover:bg-blue-700" href="/">Kembali Ke Halaman Utama</a>
                </div>
            </div>
            {{-- End View Approve --}}
            @elseif ($status === 'reject')
            {{-- Start View Reject --}}
            <div class="max-w-3xl mx-auto text-center pb-8 md:pb-12">
                <h3 class="mb-4 text-3xl md:text-4xl leading-tight font-bold tracking-tighter">Konfirmasi Servis Berhasil</h3>
                <p class="text-lg md:text-xl text-gray-600">Servis dibatalkan. Terima kasih telah melakukan konfirmasi.</p>
                <div class="mt-8">
                    <a class="btn text-white bg-blue-600 hover:bg-blue-700" href="/">Kembali Ke Halaman Utama</a>
                </div>
            </div>
            {{-- End View Reject --}}
            @elseif ($status === 'expired')
            {{-- Start View Expired --}}
            <div class="max-w-3xl mx-auto text-center">
                <!-- 404 content -->
                <h3 class="mb-4 text-3xl md:text-4xl leading-tight font-bold tracking-tighter">Maaf, waktu untuk konfirmasi telah berakhir.</h3>
                <div class="mt-8">
                    <a class="btn text-white bg-blue-600 hover:bg-blue-700" href="/">Kembali Ke Halaman Utama</a>
                </div>
            </div>
            {{-- End View Reject --}}
            @elseif ($status === 'invalid_token')
            {{-- Start View Invalid-Token --}}
            <div class="max-w-3xl mx-auto text-center">
                <!-- 404 content -->
                <h3 class="mb-4 text-3xl md:text-4xl leading-tight font-bold tracking-tighter">Maaf, Token konfirmasi tidak valid.</h3>
                <div class="mt-8">
                    <a class="btn text-white bg-blue-600 hover:bg-blue-700" href="/">Kembali Ke Halaman Utama</a>
                </div>
            </div>
            {{-- End View Invalid-Token --}}
            @elseif ($status === 'already_confirm')
            {{-- Start View Already-Confirm --}}
            <div class="max-w-3xl mx-auto text-center">
                <!-- 404 content -->
                <h3 class="mb-4 text-3xl md:text-4xl leading-tight font-bold tracking-tighter">Anda telah melakukan konfirmasi.</h3>
                <div class="mt-8">
                    <a class="btn text-white bg-blue-600 hover:bg-blue-700" href="/">Kembali Ke Halaman Utama</a>
                </div>
            </div>
            {{-- End View Already-Confirm --}}
            @else
                <!-- Page header -->
                <div class="max-w-3xl mx-auto text-center pb-8 md:pb-12">
                    <h3 class="mb-4 text-3xl md:text-4xl leading-tight font-bold tracking-tighter">Konfirmasi Servis</h3>
                    <p class="text-lg md:text-xl text-gray-600">Terima kasih telah memilih layanan servis kami. Sebelum kami melanjutkan dengan perbaikan, kami membutuhkan konfirmasi Anda mengenai tindakan dan biaya servis yang akan dilakukan.</p>
                </div>
                <!-- Form -->
                <div class="max-w-sm mx-auto">
                    <div class="flex flex-wrap -mx-3 mb-4">
                        <table class="w-full text-sm text-left text-gray-500">
                            <tbody>
                                <tr class="bg-white border-b">
                                    <td colspan="2" class="px-6 py-4 text-center">
                                        <strong>Informasi Servis</strong>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        No. Servis
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ isset($serviceItem->kode_servis) ? $serviceItem->kode_servis : 'N/A' }}
                                    </td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Pemilik
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ isset($serviceItem->customer->name) ? $serviceItem->customer->name : 'N/A' }}
                                    </td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Barang Servis
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ isset($serviceItem->jenis) ? $serviceItem->jenis : 'N/A' }} {{ isset($serviceItem->tipe) ? $serviceItem->tipe : 'N/A' }}
                                    </td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Kerusakan
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ isset($serviceItem->service_detail->kerusakan) ? $serviceItem->service_detail->kerusakan : 'N/A' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-4">
                        <table class="w-full text-sm text-left text-gray-500">
                            <tbody>
                                @if(isset($estimasiTindakan) && isset($estimasiBiaya))
                                <tr class="bg-white border-b">
                                    <td colspan="2" class="px-6 py-4 text-center">
                                        <strong>Konfirmasi Tindakan dan Biaya</strong>
                                    </td>
                                </tr>
                                    @foreach($estimasiTindakan as $index => $tindakan)
                                        <tr class="bg-white border-b">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                @if(count($estimasiTindakan) > 1)
                                                    Konfirmasi {{ $index + 1 }}
                                                @else
                                                    Konfirmasi
                                                @endif
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $tindakan }} (Rp. {{ number_format($estimasiBiaya[$index]) }})
                                            </td>
                                        </tr>
                                    @endforeach
                                        <tr class="bg-white border-b">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">Total Biaya</th>
                                            <td class="px-6 py-4"><strong>Rp. {{ number_format(array_sum($estimasiBiaya)) }}</strong></td>
                                        </tr>
                                @else
                                    <tr class="bg-white border-b">
                                        <td colspan="2" class="px-6 py-4 text-center">
                                            Tidak ada data estimasi tindakan dan estimasi biaya untuk dikonfirmasi.
                                        </td>
                                    </tr>
                                @endif                                
                            </tbody>
                        </table>
                    </div>
                    <div class="text-sm text-gray-600 mt-4 mb-6">Mohon periksa informasi di atas dengan teliti. 
                        Jika Anda setuju dengan tindakan dan biaya servis yang kami tawarkan, silakan klik tombol <a class="font-bold">"Setuju"</a> di bawah ini. 
                        Namun, jika anda ingin membatalkan servis, silakan pilih tombol <a class="font-bold">"Batalkan Servis"</a>
                    </div>
                    <form action="{{ route('confirmation.service', ['token' => $serviceItem->confirmation_token]) }}" method="POST">
                        @csrf
                        <div class="flex flex-wrap -mx-3 mb-3">
                            <div class="w-full px-3">
                                <button type="submit" name="action" value="approve" class="btn text-white bg-blue-600 hover:bg-blue-700 w-full">Setuju</button>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full px-3">
                                <button type="submit" name="action" value="reject" class="btn text-white bg-gray-600 hover:bg-gray-700 w-full">Batalkan Servis</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Page footer -->
                <div class="max-w-3xl mx-auto text-center pt-8 md:pt-12">
                    <p class="text-lg md:text-xl text-gray-600">Kami menghargai kepercayaan Anda kepada kami dan siap untuk memberikan layanan terbaik. 
                        Jika Anda memiliki pertanyaan lebih lanjut atau membutuhkan bantuan, jangan ragu untuk menghubungi kami. Terima kasih atas kerja samanya.
                    </p>
                </div>
            @endif

        </div>
    </div>
</section>

@endsection