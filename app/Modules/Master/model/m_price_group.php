<?php

namespace App\Modules\Master\model;

use Illuminate\Database\Eloquent\Model;

use DB;
use Response;
use Datatables;
use Session;

class m_price_group extends Model
{
    protected $table = 'm_price_group';  
    protected $primaryKey = 'pg_id';

}
