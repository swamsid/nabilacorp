<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_barang_rusakdt extends Model
{
    protected $table = 'd_barang_rusakdt';
    protected $primaryKey = 'd_brdt_id';
    const CREATED_AT = 'd_brdt_created';
    const UPDATED_AT = 'd_brdt_updated';
    
    protected $fillable = [
        'd_brdt_id', 
        'd_brdt_brid', 
        'd_brdt_item',
        'd_brdt_sat',
        'd_brdt_qty',
        'd_brdt_price',
        'd_brdt_pricetotal',
        'd_brdt_keterangan',
        'd_brdt_isubah',
        'd_brdt_created',
        'd_brdt_updated'
    ];
}
