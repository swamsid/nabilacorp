<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Response;

class m_customer extends Model
{  
    protected $table = 'm_customer';
    protected $primaryKey = 'c_id';
    const CREATED_AT = 'c_insert';
    const UPDATED_AT = 'c_update';
    
    protected $fillable = ['c_id','c_name','c_birthday', 'c_email', 'c_hp','c_address','c_class','c_type'];

    public static function customer($request){
       $search = $request->term;
       $exec   = m_customer::select('c_id','c_name','c_birthday', 'c_email', 'c_hp','c_address')->where('c_name','like','%'.$search.'%')->orWhere('c_email','like','%'.$search.'%')->orWhere('c_hp','like','%'.$search.'%')
           ->orWhere('c_address','like','%'.$search.'%')
           ->get();

        $results = array();
                        
        if (count($exec)==0) {            
          /*$results[] = [ 'id' => null, 'label' =>''];*/
        } else {
          foreach ($exec as $data)
          {
            $results[] = ['label' => $data->c_name.' ('.$data->c_address.')', 'c_id' => $data->c_id];
            

          }
        } 
        return Response::json($results);
    }

}