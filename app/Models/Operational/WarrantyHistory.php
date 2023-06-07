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
        'transaction_id',
        'keterangan',
        'kondisi',
        'tindakan',
        'catatan',
        'pengambil',
        'penyerah',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // relasi database
    public function transaction()
    {
        return $this->belongsTo('App\Models\Operational\Transaction', 'transaction_id', 'id');
    }
}
