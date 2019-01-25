<?php

namespace App\Modules\POS\model;

use Illuminate\Database\Eloquent\Model;

use DB;

class m_paymentmethod extends Model
{  
    protected $table = 'm_paymentmethod';
    protected $primaryKey = 'pm_id';
    const CREATED_AT = 'pm_insert';
    const UPDATED_AT = 'pm_update';
    
      protected $fillable = ['pm_id','pm_name','pm_active'];

      static function pm(){
      	 $sql="select 
              pm_id,
              pm_name,
              pm_coa_code
              from m_paymentmethod
              where pm_active='Y' and pm_year='2018'
              ";
        $exec= DB::select($sql);
        return $exec;

      }
      static function paymentmethodEdit($id='',$flag=''){
            $data['sales_pm']=DB::table('d_sales_payment')->where('sp_sales','=',$id)                           
                  ->get();    
            $data['pm']=DB::table('m_paymentmethod')
                  ->get();    
                  
            return $data;       
      }
}
	
	