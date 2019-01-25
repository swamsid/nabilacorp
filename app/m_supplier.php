<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

use Response;

class m_supplier extends Model
{



  



	protected $table = 'm_supplier';
    protected $primaryKey = 's_id';
    protected $fillable = ['s_id', 's_company', 's_name', 's_address', 's_phone','s_phone1','s_phone2', 's_fax','s_note','s_active'];

    public $incrementing = false;
    public $remember_token = false;
    //public $timestamps = false;
    const CREATED_AT = 's_created';
    const UPDATED_AT = 's_updated';


     public static function seachSupplier($item) {

        $supplier = $item->term;

        $sql=m_supplier::where(function ($query) use ($supplier) {
                  $query->where('s_company','like','%'.$supplier.'%');                  
                  $query->orWhere('s_name','like','%'.$supplier.'%');                  
                  $query->orWhere('s_address','like','%'.$supplier.'%');                  
                  $query->orWhere('s_phone','like','%'.$supplier.'%');               
                  // $query->orWhere('s_phone2','like','%'.$supplier.'%');               
                  $query->orWhere('s_fax','like','%'.$supplier.'%');               
                  })->get();        
        
        $results = array();
                        
        if (count($sql)==0) {
          $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
        } else {
          foreach ($sql as $data)
          {
            $results[] = ['label' => $data->s_company, 's_id' => $data->s_id];
          }
        } 
        return Response::json($results);

    }
}
	