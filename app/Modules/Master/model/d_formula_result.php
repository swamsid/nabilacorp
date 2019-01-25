<?php

namespace App\Modules\Master\model;

use Illuminate\Database\Eloquent\Model;

class d_formula_result extends Model
{
    protected $table = 'd_formula_result';
    const CREATED_AT = 'fr_updated';
    const UPDATED_AT = 'fr_created';  
    protected $fillable = [	'fr_id', 
    						'fr_adonan', 
    						'fr_result', 
    						'fr_scale'];
}
