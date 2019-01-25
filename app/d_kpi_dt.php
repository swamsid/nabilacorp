<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_kpi_dt extends Model
{
    protected $table = 'd_kpi_dt';
    protected $primaryKey = 'd_kpidt_id';
    const CREATED_AT = 'd_kpidt_created';
    const UPDATED_AT = 'd_kpidt_updated';
    
    protected $fillable = [
        'd_kpidt_id', 
        'd_kpidt_dkpi_id',
        'd_kpidt_mkpi_id', 
        'd_kpidt_value',
        'd_kpidt_created',
        'd_kpidt_updated'
    ];
}
