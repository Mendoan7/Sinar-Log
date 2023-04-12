<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// use model here
use App\Models\User;
use App\Models\Operational\Customer;
use App\Models\Operational\Service;
use App\Models\Operational\ServiceDetail;
use App\Models\Operational\Transaction;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // filter data berdasarkan parameter di URL
        $status = $request->query('status');

        $all_count = Transaction::with(['service_detail.service' => function($query) {
            $query->whereIn('status', [8]);
        }])->count();
        
        $done_count = Transaction::with(['service_detail.service' => function($query) {
            $query->whereIn('status', [8]);
        }])
            ->whereHas('service_detail', function($query) {
                $query->where('kondisi', 1);
            })->count();
        
        $notdone_count = Transaction::with(['service_detail.service' => function($query) {
            $query->whereIn('status', [8]);
        }])
            ->whereHas('service_detail', function($query) {
                $query->where('kondisi', 2);
            })->count();
        
        $cancel_count = Transaction::with(['service_detail.service' => function($query) {
            $query->whereIn('status', [8]);
        }])
            ->whereHas('service_detail', function($query) {
                $query->where('kondisi', 3);
            })->count();

        $transactions = Transaction::with('service_detail.service')
            ->whereHas('service_detail.service', function($query) {
                $query->whereIn('status', [8]);
            });

        if ($status == 'done') {
            $transactions->whereHas('service_detail', function($query) {
                $query->where('kondisi', 1);
            });
        } elseif ($status == 'notdone') {
            $transactions->whereHas('service_detail', function($query) {
                $query->where('kondisi', 2);
            });
        } elseif ($status == 'cancel') {
            $transactions->whereHas('service_detail', function($query) {
                $query->where('kondisi', 3);
            });
        }

        $transactions = $transactions->latest('created_at')->get();

        return view('pages.backsite.operational.transaction.index', compact('transactions', 'all_count', 'done_count', 'notdone_count', 'cancel_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $service_detail = ServiceDetail::where('id', $data['service_detail_id'])->first();
        
        // save to database
        $transaction = new Transaction;
        $transaction->service_detail_id = $service_detail['id'];
        $transaction->pembayaran = $data['pembayaran'];
        $transaction->garansi = $data['garansi'];
        $transaction->pengambil = $data['pengambil'];
        $transaction->penyerah = Auth::user()->name;
        $transaction->save();
        $service = $service_detail->service;

        if ($service) {
            $service->status = 8;
            $service->save();
        }

        alert()->success('Success Message', 'Barang telah selesai diambil');
        return redirect()->route('backsite.transaction.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->service_detail->service->forceDelete();

        alert()->success('Success Message', 'Berhasil menghapus data transaksi');
        return back();
    }

    // Custom
    public function sendNotification(Request $request) {

        $transaction_item = Transaction::with('service_detail.service.customer')
                                ->find($request->transaction_id);

        $contacts = $transaction_item->service_detail->service->customer->contact;
        $kode = $transaction_item->service_detail->service->kode_servis;
        $jenis = $transaction_item->service_detail->service->jenis;
        $tipe = $transaction_item->service_detail->service->tipe;
        $status = $transaction_item->service_detail->service->status;
        $kondisi = $transaction_item->service_detail->kondisi;
        $tanggal = $transaction_item->updated_at;
        $pengambil = $transaction_item->pengambil;
        $pembayaran = $transaction_item->pembayaran;
        $garansi = $transaction_item->garansi;
        
        //Merubah Format Biaya
        $biaya = number_format($transaction_item->service_detail->biaya, 0, ',', '.');
        $biaya = "Rp. " . $biaya;
        
        // Menentukan ucapan selamat
        $time = date("H");
        $selamat = "";
        
        if ($time >= 5 && $time <= 11) {
            $selamat = "Selamat Pagi";
        } elseif ($time >= 12 && $time <= 14) {
            $selamat = "Selamat Siang";
        } elseif ($time >= 15 && $time <= 17) {
            $selamat = "Selamat Sore";
        } else {
            $selamat = "Selamat Malam";
        }

        // Status
        $statusnya = "";

        if ($status == 7) {
            $statusnya = "Bisa Diambil";
        } elseif ($status == 8) {
            $statusnya = "Sudah Diambil";
        }
        
        // Kondisi
        $kondisinya = "";

        if ($kondisi == 1) {
            $kondisinya = "Sudah Jadi";
        } elseif ($kondisi == 2) {
            $kondisinya = "Tidak Bisa";
        } elseif ($kondisi == 3) {
            $kondisinya = "Dibatalkan";
        }
    
        // Teks pesan yang akan dikirim
        $message = "*Notifikasi | SINAR CELL*\n\nBarang servis $jenis $tipe dengan No. Servis $kode Sudah Diambil dalam kondisi *$kondisinya* pada tanggal $tanggal oleh *$pengambil* dengan pembayaran *$pembayaran*. Garansi *$garansi*. Terima Kasih atas kepercayaan Anda telah melakukan Servis di *SINAR CELL*";
    
        // Link whatsapp
        $waLink = "https://wa.me/$contacts?text=".urlencode($message);
    
        // Redirect ke halaman whatsapp
        return redirect($waLink);
    }
}
