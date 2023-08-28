@extends('layouts.app')

@section('title', 'Laporan Teknisi')

@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">

                            <div class="card-header bg-opacity-25 bg-primary">
                                <h5 class="fw-bold text-dark m-0">Detail Transaksi Teknisi</h5>
                            </div>

                            <div class="card-body border-bottom">
                                <div class="row">
                                    <div class="col">
                                        <p class="mb-2">Berikut servis yang selesai ditangani oleh <span
                                                class="text-body fw-bold">{{ $teknisi->name }}</span></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xxl-6 col-lg-8">
                                        <p class="mb-2">Tanggal Transaksi : <span
                                                class="fw-bold">{{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM Y') }}</span>
                                        </p>
                                    </div>
                                    <div class="col-xxl-3 col-lg-4 offset-xxl-3">
                                        <p class="mb-0">Total :
                                            {{ 'RP. ' . number_format($totalBiaya) }}
                                        </p>
                                        <p class="mb-0 fw-bolder">Profit :
                                            {{ 'RP. ' . number_format($totalBiaya - $totalModal) }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-rep-plugin">
                                    <div class="table-responsive mb-0">
                                        <table class="table table-striped">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Pemilik</th>
                                                    <th>Barang</th>
                                                    <th>Kerusakan</th>
                                                    <th>Kondisi</th>
                                                    <th>Tindakan</th>
                                                    <th>Modal</th>
                                                    <th>Biaya</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dataService as $service)
                                                    <tr onmouseover="this.style.cursor='pointer';" onmouseout="this.style.cursor='default';"  onclick="openModal('showDetail{{$service->id}}');">
                                                        <td>{{ $service->date_out ? date('d/m/Y H:i', strtotime($service->date_out)) : '' }}</td>
                                                        <td class="fw-bold">{{ $service->customer->name }}</td>
                                                        <td>{{ $service->jenis ?? '' }} {{ $service->tipe ?? '' }}</td>
                                                        <td>{{ $service->service_detail->kerusakan }}</td>
                                                        <td>
                                                            @if ($service->service_detail->kondisi == 1)
                                                                <span class="badge bg-success">{{ 'Sudah Jadi' }}</span>
                                                            @elseif($service->service_detail->kondisi == 2)
                                                                <span class="badge bg-danger">{{ 'Tidak Bisa' }}</span>
                                                            @elseif($service->service_detail->kondisi == 3)
                                                                <span class="badge bg-secondary">{{ 'Dibatalkan' }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($service->service_detail->tindakan))
                                                                {{ implode(', ', json_decode($service->service_detail->tindakan)) }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($service->service_detail->modal))
                                                                @php
                                                                    $totalModal = 0; // Inisialisasi total modal
                                                                    $modalArray = json_decode($service->service_detail->modal, true);
                                                                    if (is_array($modalArray)) {
                                                                        $totalModal = array_sum($modalArray); // Hitung total modal
                                                                    }
                                                                @endphp
                                                                {{ 'RP. ' . number_format($totalModal) }}
                                                            @endif
                                                        </td>
                                                        <td>{{ 'RP. ' . number_format($service->service_detail->biaya) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        
                                        @foreach ($dataService as $service)
                                        <div class="modal fade bs-example-modal-center" id="showDetail{{ $service->id }}" tabindex="-1" aria-hidden="true" aria-labelledby="showDetailLabel" aria-expanded="false">
                                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="showDetailLabel">Detail Servis</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="col">No. Servis</th>
                                                                    <td scope="col"><span class="fw-bold">{{ isset($service->kode_servis) ? $service->kode_servis : 'N/A' }}</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Tgl. Masuk</th>
                                                                    <td>{{ $service->created_at->isoFormat('dddd, D MMMM Y HH:mm')}} WIB
                                                                        [{{ isset($service->penerima) ? $service->penerima : 'N/A' }}]</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Pemilik</th>
                                                                    <td>{{ isset($service->customer->name) ? $service->customer->name : 'N/A' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Barang Servis</th>
                                                                    <td>
                                                                        {{ isset($service->jenis) ? $service->jenis : 'N/A' }}
                                                                        {{ isset($service->tipe) ? $service->tipe : 'N/A' }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Kelengkapan</th>
                                                                    <td>{{ isset($service->kelengkapan) ? $service->kelengkapan : 'N/A' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Kerusakan</th>
                                                                    <td>{{ isset($service->service_detail->kerusakan) ? $service->service_detail->kerusakan : 'N/A' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Kondisi</th>
                                                                    <td>@if($service->service_detail->kondisi == 1)
                                                                        <span class="badge bg-success">{{ 'Sudah Jadi' }}</span>
                                                                    @elseif($service->service_detail->kondisi == 2)
                                                                        <span class="badge bg-danger">{{ 'Tidak Bisa' }}</span>
                                                                    @elseif($service->service_detail->kondisi == 3)
                                                                        <span class="badge bg-secondary">{{ 'Dibatalkan' }}</span>   
                                                                    @endif
                                                                        - {{ \Carbon\Carbon::parse($service->date_done)->isoFormat('dddd, D MMMM Y HH:mm') }} WIB
                                                                    </td>
                                                                </tr>

                                                                {{-- Tindakan dan Modal --}}
                                                                @if(isset($service->service_detail->tindakan) && isset($service->service_detail->modal))
                                                                    @php
                                                                        $tindakan = json_decode($service->service_detail->tindakan, true);
                                                                        $modal = json_decode($service->service_detail->modal);
                                                                        $totalModal = array_sum($modal);
                                                                    @endphp

                                                                    @if(count($tindakan) === 1)
                                                                        <tr>
                                                                            <th scope="row">Tindakan</th>
                                                                            <td>{{ $tindakan[0] }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Modal</th>
                                                                            <td>RP. {{ number_format($modal[0]) }}</td>
                                                                        </tr>
                                                                    @else
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                <div class="accordion accordion-flush" id="accordionFlushShow">
                                                                                    <div class="accordion-item">
                                                                                        <h2 class="accordion-header" id="flush-headingOne">
                                                                                            <a class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                                                                                                Tindakan dan Modal
                                                                                            </a>
                                                                                        </h2>
                                                                                        <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushShow">
                                                                                            <div class="accordion-body">
                                                                                                <table class="table table-striped mb-0">
                                                                                                    <thead class="table-dark">
                                                                                                        <tr>
                                                                                                            <th scope="col">#</th>
                                                                                                            <th scope="col">Tindakan</th>
                                                                                                            <th scope="col">Modal</th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        @foreach($tindakan as $index => $item)
                                                                                                            <tr>
                                                                                                                <th scope="row">{{ $index + 1 }}</th>
                                                                                                                <td>{{ $item }}</td>
                                                                                                                <td>RP. {{ number_format($modal[$index]) }}</td>
                                                                                                            </tr>
                                                                                                        @endforeach
                                                                                                    </tbody>
                                                                                                    <tfoot class="table-secondary">
                                                                                                        <tr>
                                                                                                            <th colspan="2" scope="row" class="fw-bold">Total Modal</th>
                                                                                                            <td>RP. {{ number_format($totalModal) }}</td>
                                                                                                        </tr>
                                                                                                    </tfoot>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @else
                                                                    <tr>
                                                                        <td colspan="2">N/A</td>
                                                                    </tr>
                                                                @endif
                                                                {{-- End Tindakan dan Modal --}}

                                                                <tr>
                                                                    <th scope="row">Biaya</th>
                                                                    <td><span class="fw-bold">{{ isset($service->service_detail->biaya) ? 'RP. '.number_format($service->service_detail->biaya) : 'N/A' }}</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Teknisi</th>
                                                                    <td>{{ isset($service->teknisi_detail->name) ? $service->teknisi_detail->name : 'N/A' }}</td>
                                                                </tr>
                                                                <tr class="table-success">
                                                                    <th scope="row">Status</th>
                                                                    <td>
                                                                        @if($service->status == 8)
                                                                            <span class="badge bg-primary">{{ 'Bisa Diambil' }}</span>
                                                                        @elseif($service->status == 9)
                                                                            <span class="badge bg-success">{{ 'Sudah Diambil' }}</span>
                                                                        @else
                                                                            <span>{{ 'N/A' }}</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Tgl. Ambil</th>
                                                                    <td>
                                                                        {{ \Carbon\Carbon::parse($service->date_out)->isoFormat('dddd, D MMMM Y HH:mm') }} WIB
                                                                        [{{ isset($service->penyerah) ? $service->penyerah : 'N/A' }}]
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Pengambil</th>
                                                                    <td>{{ isset($service->pengambil) ? $service->pengambil : 'N/A' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Pembayaran</th>
                                                                    <td>{{ isset($service->service_detail->pembayaran) ? $service->service_detail->pembayaran : 'N/A' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Garansi</th>
                                                                    @if ($service->service_detail->garansi == 0)
                                                                        <td class="fw-bold">Tidak Ada</td>
                                                                    @else
                                                                        <td class="fw-bold">{{ $service->service_detail->garansi }} Hari</td>
                                                                    @endif
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    </div>        
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-6">
                                        <a href="{{ route('backsite.report-employees.show', ['teknisiId' => $teknisi->id, 'start_date' => $start_date->format('Y-m-d'), 'end_date' => $end_date->format('Y-m-d')]) }}"
                                            class="btn btn-secondary">
                                            <i class="mdi mdi-arrow-left me-1"></i> Lihat Transaksi Lainnya
                                        </a>
                                    </div> <!-- end col -->
                                </div> <!-- end row-->
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
    </div>

@endsection

@push('after-script')
    <script>
        function openModal(modalId) {
            $('#' + modalId).modal('show');
        }
    </script>

    {{-- <script>
        $(document).ready(function() {
            $('#detailTable-buttons').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf', 'colvis'
                    // 'copy' // Komentari atau hilangkan baris ini untuk menyembunyikan tombol "Copy"
                ]
            });
        });
    </script> --}}
@endpush
