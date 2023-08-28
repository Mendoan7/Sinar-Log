<?php

namespace App\Models\Operational;

use App\Models\Operational\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarrantyHistory extends Model
{
    // use HasFactory;

    use SoftDeletes;

    // declare table name
    public $table = 'warranty_history';

    // this field must type date yyyy-mm-dd hh:mm:ss
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // declare fillable fields
    protected $fillable = [
        'service_detail_id',
        'keterangan',
        'kondisi',
        'tindakan',
        'catatan',
        'pengambil',
        'penyerah',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // relasi database
    public function service_detail()
    {
        return $this->belongsTo('App\Models\Operational\ServiceDetail', 'service_detail_id', 'id');
    }
}
