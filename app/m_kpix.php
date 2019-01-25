<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_kpix extends Model
{
    protected $table = 'm_kpix';
    protected $primaryKey = 'kpix_id';
    const CREATED_AT = 'kpix_created';
    const UPDATED_AT = 'kpix_updated';
    
    protected $fillable = [
        'kpix_id', 
        'kpix_name',
        'kpix_bobot',
        'kpix_deadline',
        'kpix_target',
        'kpix_p_id',
        'kpix_div_id',
        'kpix_jabatan_id'
    ];
}
