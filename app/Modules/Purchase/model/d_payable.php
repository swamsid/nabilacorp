<?php

namespace App\Modules\Purchase\model;

use Illuminate\Database\Eloquent\Model;

use DB;

use Auth;

use Datatables;

use Carbon\Carbon;

use Response;



class d_payable extends Model {

    protected $table = 'd_payable';
    protected $primaryKey = 'p_id';
    const CREATED_AT = 'p_created';
    const UPDATED_AT = 'p_updated';

}
