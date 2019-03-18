<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_terima_return_sup extends Model
{
    protected $table = 'd_terima_return_sup';
    protected $primaryKey = 'd_trs_id';
    const CREATED_AT = 'd_trs_created';
    const UPDATED_AT = 'd_trs_updated';
    
    protected $fillable = [
        'd_trs_id', 
        'd_trs_prid', 
        'd_trs_sup',
        'd_trs_code',
        'd_trs_staff',
        'd_trs_noreff',
        'd_trs_totalnett',
        'd_trs_totalbyr',
        'd_trs_date',
        'd_trs_datepaid',
        'd_trs_created',
        'd_trs_updated'
    ];
}
