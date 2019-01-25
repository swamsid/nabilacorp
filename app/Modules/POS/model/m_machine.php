<?php

namespace App\Modules\POS\model;

use Illuminate\Database\Eloquent\Model;

use DB;

use Session;

class m_machine extends Model
{  

    protected $table = 'm_machine';
    protected $primaryKey = 'm_id';
    const CREATED_AT = 'm_insert';
    const UPDATED_AT = 'm_update';
    
      protected $fillable = ['m_id','m_name','m_active','m_type'];

      static function showMachine(){
      	$sql=m_machine::select('m_id','m_name','m_active','m_type')
            /*->where('m_type',$type)*/
            ->get();        
        return $sql;
      }
      static function showMachineActive(){

        $sql=m_machine::select('m_id','m_name','m_active','m_type')
            ->where('m_id',Session::get('kasir'))
            ->first();        
            
        return $sql;
      }
      
      static function editMachine($id='',$flag=''){
            $data['sales_pm']=DB::table('d_sales_payment')->where('sp_sales','=',$id)                           
                  ->get();    
            $data['pm']=DB::table('m_paymentmethod')
                  ->get();    
                  
            return $data;       
      }
}
	
	