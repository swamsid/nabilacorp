<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_consigner extends Model
{
    protected $table = 'm_consigner';
    protected $primaryKey = 'c_id';
    protected $fillable = ['c_code', 
    						'c_name', 
    						'c_company', 
    						'c_hp1', 
    						'c_hp2', 
    						'c_fax',
    						'c_address',
    						'c_info',
    						'c_isactive'];

    public $incrementing = false;
    public $remember_token = false;
    //public $timestamps = false;
    const CREATED_AT = 'c_created';
    const UPDATED_AT = 'c_updated';
}
