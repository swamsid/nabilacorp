<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class d_cv_pelamar extends Model
{
    protected $table = 'd_cv_pelamar';
    protected $primaryKey = 'd_cv_id';
    const CREATED_AT = 'd_cv_created';
    const UPDATED_AT = 'd_cv_updated';
    
    protected $fillable = [
        'd_cv_id', 
        'd_cv_pid',
        'd_cv_company',
        'd_cv_thnmasuk',
        'd_cv_thnkeluar',
        'd_cv_jobdesc',
        'd_cv_created',
        'd_cv_updated'
    ];
}
