<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_pelamar extends Model
{
    protected $table = 'd_pelamar';
    protected $primaryKey = 'p_id';
    const CREATED_AT = 'p_created';
    const UPDATED_AT = 'p_updated';
    
    protected $fillable = [
        'p_id', 
        'p_date', 
        'p_vacancyid',
        'p_nip',
        'p_name',
        'p_address',
        'p_address_now',
        'p_birth_place',
        'p_birthday',
        'p_education',
        'p_email',
        'p_tlp',
        'p_religion',
        'p_status',
        'p_promo',
        'p_apply_status',
        'p_apply_statusdt',
        'p_wife_name',
        'p_child',
        'p_isset_employee',
        'p_created',
        'p_updated'
    ];
}
