<?php

namespace App\Models\Operational;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceDetail extends Model
{
    // use HasFactory;
    use SoftDeletes;

    // declare table name
    public $table = 'service_detail';

    // this field must type date yyyy-mm-dd hh:mm:ss
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // declare fillable fields
    protected $fillable = [
        'service_id',
        'kondisi',
        'tindakan',
        'modal',
        'biaya',
        'teknisi',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function service()
    {
        return $this->belongsTo('App\Models\Operational\Service', 'service_id', 'id');
    }

    // one to one
    public function transaction()
    {
        return $this->hasOne('App\Models\Operational\Transaction', 'service_detail_id');
    }
}
