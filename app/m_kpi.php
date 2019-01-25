<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_kpi extends Model
{
    protected $table = 'm_kpi';
    protected $primaryKey = 'kpi_id';
    const CREATED_AT = 'kpi_created';
    const UPDATED_AT = 'kpi_updated';
    
    protected $fillable = [
        'kpi_id', 
        'kpi_name',
        'kpi_p_id',
        'kpi_div_id',
        'kpi_jabatan_id',
        'kpi_created',
        'kpi_updated'
    ];
}
