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



class d_purchasingharian extends Model {

    protected $table = 'd_purchasingharian';
    protected $primaryKey = 'd_pcsh_id';
    const CREATED_AT = 'd_pcsh_created';
    const UPDATED_AT = 'd_pcsh_updated';
    
    protected $fillable = [
        'd_pcsh_id', 
        'd_pcsh_code', 
        'd_pcsh_date',
        'd_pcsh_peminta',
        'd_pcsh_keperluan',
        'd_pcsh_totalprice',
        'd_pcsh_staff',
        'd_pcsh_status',
        'd_pcsh_dateconfirm',
        'd_pcsh_created',
        'd_pcsh_updated'
    ];

}
