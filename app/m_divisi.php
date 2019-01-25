<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

use Response;

class m_divisi extends Model
{



  



	protected $table = 'm_divisi';
    protected $primaryKey = 'd_id';

    public $incrementing = false;
    public $remember_token = false;
    //public $timestamps = false;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

}
	