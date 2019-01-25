<?php
   namespace App\Modules\POS\model;
   
   use Illuminate\Database\Eloquent\Model;   
   
   use DB;
   
   use Auth;
   
   use Datatables;
   
   use Session;
   
   class d_salesplan_dt extends Model
   {  
       protected $table = 'd_salesplan_dt';
       protected $primaryKey = 'spdt_detailid';
       const CREATED_AT = 'spdt_created';
       const UPDATED_AT = 'spdt_updated';
       
       protected $fillable = ['spdt_salesplan', 'spdt_detailid', 'spdt_item', 'spdt_qty'];
   
       public function m_item() {
        $res = $this->belongsTo('App\m_itemm', 'spdt_item', 'i_id');

        return $res;
      }
   }
    
   ?>