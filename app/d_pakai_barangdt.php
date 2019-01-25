<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_pakai_barangdt extends Model
{
    protected $table = 'd_pakai_barangdt';
    protected $primaryKey = 'd_pbdt_id';
    const CREATED_AT = 'd_pbdt_created';
    const UPDATED_AT = 'd_pbdt_updated';
    
    protected $fillable = [
        'd_pbdt_id', 
        'd_pbdt_pbid', 
        'd_pbdt_item',
        'd_pbdt_sat',
        'd_pbdt_qty',
        'd_pbdt_price',
        'd_pbdt_pricetotal',
        'd_pbdt_keterangan',
        'd_pbdt_created',
        'd_pbdt_updated'
    ];
}
