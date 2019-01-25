<?php
   nameappace App\Modules\POS\model;
   
   use Illuminate\Database\Eloquent\Model;
   
   use App\Modules\POS\model\d_saleapplan_dt;
   
   use App\Lib\mutasi;
   
   use App\Lib\format;
   
   use App\d_sales_payment;
   
   use App\m_itemm;
   
   use DB;
   
   use Auth;
   
   use Datatables;
   
   use Session;
   
   class abs_pegawai_man extends Model {  
      protected $table = 'abs_pegawai_man';
      protected $primaryKey = 'app_id';
      const CREATED_AT = 'app_insert';
      const UPDATED_AT = 'app_update';


   }
    
   