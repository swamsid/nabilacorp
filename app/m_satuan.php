<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Response;

class m_satuan extends Model
{  
    protected $table = 'm_satuan';
    protected $primaryKey = 's_id';

    const CREATED_AT = 's_create';
    const UPDATED_AT = 's_update';
    

}