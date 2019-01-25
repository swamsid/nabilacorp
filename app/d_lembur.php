<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_lembur extends Model
{
    protected $table = 'd_lembur';
    protected $primaryKey = 'd_lembur_id';
    const CREATED_AT = 'd_lembur_created';
    const UPDATED_AT = 'd_lembur_updated';
    
    protected $fillable = [
        'd_lembur_id', 
        'd_lembur_code',
        'd_lembur_date',
        'd_lembur_jenispeg',
        'd_lembur_pid',
        'd_lembur_nama',
        'd_lembur_stime',
        'd_lembur_etime',
        'd_lembur_keperluan',
        'd_lembur_created',
        'd_lembur_updated'
    ];
}
