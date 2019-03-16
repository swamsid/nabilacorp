<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_barang_rusak extends Model
{
    protected $table = 'd_barang_rusak';
    protected $primaryKey = 'd_br_id';
    const CREATED_AT = 'd_br_created';
    const UPDATED_AT = 'd_br_updated';
    
    protected $fillable = [
        'd_br_id', 
        'd_br_code', 
        'd_br_date',
        'd_br_pemberi',
        'd_br_staff',
        'd_br_gdg',
        'd_br_status',
        'd_br_created',
        'd_br_updated'
    ];
}
