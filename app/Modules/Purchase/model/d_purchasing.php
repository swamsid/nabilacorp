<?php

namespace App\Modules\Purchase\model;

use Illuminate\Database\Eloquent\Model;

use App\Lib\format;

use App\m_item;

use DB;

use Auth;

use Datatables;

use Carbon\Carbon;

use Response;



class d_purchasing extends Model {

    protected $table = 'd_purchasing';
    protected $primaryKey = 'd_pcsh_id';
    const CREATED_AT = 'd_pcsh_created';
    const UPDATED_AT = 'd_pcsh_updated';

}
