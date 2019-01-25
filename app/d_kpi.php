<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_kpi extends Model
{
    protected $table = 'd_kpi';
    protected $primaryKey = 'd_kpi_id';
    const CREATED_AT = 'd_kpi_created';
    const UPDATED_AT = 'd_kpi_updated';
    
    protected $fillable = [
        'd_kpi_id', 
        'd_kpi_code',
        'd_kpi_pid', 
        'd_kpi_date',
        'd_kpi_dateconfirm',
        'd_kpi_isconfirm',
        'd_kpi_created',
        'd_kpi_updated'
    ];
}
