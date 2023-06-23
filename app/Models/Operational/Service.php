<?php

namespace App\Models\Operational;

use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    // use HasFactory;
    use SoftDeletes;

    // declare table name
    public $table = 'service';

    // this field must type date yyyy-mm-dd hh:mm:ss
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // declare fillable fields
    protected $fillable = [
        'user_id',
        'customer_id',
        'kode_servis',
        'jenis',
        'tipe',
        'kelengkapan',
        'kerusakan',
        'penerima',
        'teknisi',
        'status',
        'estimasi_tindakan',
        'estimasi_biaya',
        'confirmation_token',
        'expired_time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // one to one
    public function service_detail()
    {
        return $this->hasOne('App\Models\Operational\ServiceDetail', 'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function teknisi_detail()
    {
        return $this->belongsTo(User::class, 'teknisi', 'id');
    }
}
