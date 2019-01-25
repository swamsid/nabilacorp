<?php

namespace App\Modules\Master\model;

use Illuminate\Database\Eloquent\Model;

class d_formula extends Model
{
    protected $table = 'd_formula';  
      protected $fillable = [	'f_id',
								'f_detailid',
								'f_bb',
								'f_value', 
								'f_scale' ];
}
