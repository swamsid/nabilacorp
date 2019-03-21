<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_terima_return_supdt extends Model
{
    protected $table = 'd_terima_return_supdt';
    protected $primaryKey = 'd_trsdt_id';
    const CREATED_AT = 'd_trsdt_created';
    const UPDATED_AT = 'd_trsdt_updated';
    
    protected $fillable = [
        'd_trsdt_id', 
        'd_trsdt_idrs', 
        'd_trsdt_smdetail',
        'd_trsdt_item',
        'd_trsdt_sat',
        'd_trsdt_idrtdet',
        'd_trsdt_qty',
        'd_trsdt_price',
        'd_trsdt_pricetotal',
        'd_trsdt_date_received',
        'd_trsdt_created',
        'd_trsdt_updated'
    ];
}
