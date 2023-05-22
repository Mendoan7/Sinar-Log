<?php

namespace App\Models\Operational;

use Database\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    // declare table name
    public $table = 'customer';

    // this field must type date yyyy-mm-dd hh:mm:ss
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // declare fillable fields
    protected $fillable = [
        'name',
        'address',
        'contact',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function newFactory()
    {
        return CustomerFactory::new();
    }  

    // one to many
    public function service()
    {
        return $this->hasMany(Service::class);
    }
}
