<?php

namespace App\Modules\Master\model;

use Illuminate\Database\Eloquent\Model;

use DB;
use Response;
use Datatables;
use Session;

class m_customer extends Model
{
    protected $table = 'm_customer';  
    protected $primaryKey = 'c_id';
    const CREATED_AT = 'c_insert';
    const UPDATED_AT = 'c_update';

}
