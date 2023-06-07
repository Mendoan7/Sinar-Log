<?php

namespace App\Models\Operational;

use App\Models\Operational\WarrantyHistory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    // use HasFactory;
    use SoftDeletes;

    // declare table name
    public $table = 'transaction';

    // this field must type date yyyy-mm-dd hh:mm:ss
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // declare fillable fields
    protected $fillable = [
        'service_detail_id',
        'pembayaran',
        'garansi',
        'pengambil',
        'penyerah',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function service_detail()
    {
        return $this->belongsTo('App\Models\Operational\ServiceDetail', 'service_detail_id', 'id');
    }

    // one to one
    public function warranty_history()
    {
        return $this->hasOne('App\Models\Operational\WarrantyHistory', 'transaction_id');
    }
}
