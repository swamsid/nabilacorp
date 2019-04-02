<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_comp extends Model
{
    protected $table = 'm_comp';
    protected $primaryKey = 'c_id';
    protected $fillable = ['c_code', 
    						'c_name', 
    						'c_owner', 
    						'c_name', 
    						'c_address',
    						'c_type',
    						'c_control',
    						'c_isactive'];

    public $incrementing = false;
    public $remember_token = false;
    //public $timestamps = false;
    const CREATED_AT = 'c_insert';
    const UPDATED_AT = 'c_update';
}
