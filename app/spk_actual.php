<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class spk_actual extends Model
{
    protected $table = 'spk_actual';
    protected $primaryKey = 'ac_id';
    protected $fillable = [	'ac_id', 
    						'ac_spk', 
    						'ac_adonan', 
    						'ac_adonan_scale',
                            'ac_kriwilan',
                            'ac_kriwilan_scale',
                            'ac_sampah',
                            'ac_sampah_scale',
                            'ac_insert',
                            'ac_update',
                        ];
    public $incrementing = false;
    public $remember_token = false;
    const CREATED_AT = 'ac_insert';
    const UPDATED_AT = 'ac_update';
}
