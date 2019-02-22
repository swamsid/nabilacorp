<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_group extends Model
{
    protected $table = 'm_group';
    protected $primaryKey = 'g_id';
    protected $fillable = [ 'g_id',
                            'g_code',
                            'g_name',
                            'g_akun_persediaan'
                          ];

    //public $timestamps = false;
    const CREATED_AT = 'g_create';
    const UPDATED_AT = 'g_update';
}
