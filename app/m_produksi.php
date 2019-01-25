<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

use Response;

class m_produksi extends Model
{
	  protected $table = 'm_produksi';
    protected $primaryKey = 'mp_id';
    protected $fillable = ['mp_id', 'mp_code', 'mp_type', 'mp_group', 'mp_name', 'mp_unit','mp_price'];

    public $incrementing = false;
    public $remember_token = false;
    //public $timestamps = false;
    const CREATED_AT = 'mp_insert';
    const UPDATED_AT = 'mp_update';

}
	