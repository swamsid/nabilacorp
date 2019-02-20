<?php

namespace App\Modules\Purchase\model;

use Illuminate\Database\Eloquent\Model;




class d_purchasingharian_dt extends Model {

    protected $table = 'd_purchasingharian_dt';
    protected $primaryKey = 'd_pcshdt_id';
    const CREATED_AT = 'd_pcshdt_created';
    const UPDATED_AT = 'd_pcshdt_updated';

    protected $fillable = [
        'd_pcshdt_id',
        'd_pcshdt_pcshid',
        'd_pcshdt_item',
        'd_pcshdt_sat',
        'd_pcshdt_qty',
        'd_pcshdt_qtyconfirm',
        'd_pcshdt_price',
        'd_pcshdt_pricetotal',
        'd_pcshdt_keterangan',
        'd_pcshdt_isconfirm',
        'd_pcshdt_isreceived',
        'd_pcshdt_created',
        'd_pcshdt_updated'
    ];

}
