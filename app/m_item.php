<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

use Response;

class m_item extends Model
{
	protected $table = 'm_item';
    protected $primaryKey = 'i_id';
    protected $fillable = ['i_id', 'i_code', 'i_type', 'i_group', 'i_name', 'i_unit','i_price'];

    public $incrementing = false;
    public $remember_token = false;
    //public $timestamps = false;
    const CREATED_AT = 'i_insert';
    const UPDATED_AT = 'i_update';

     public static function seachItem($item) {      


        $search = $item->term;

        if($search){
            $item="AND (i_name like '%".$search."%' 
                   OR i_code like '%".$search."%') ";
        }

        $sql="select 
              i_id,
              i_code,
              s_comp,
              group_concat(DISTINCT  s_position separator ',') as s_position,
              g_name,
              i_name,
              s_name,
              group_concat(DISTINCT i_price separator ',') as i_price,
              i_price AS real_price,
              sum(s_qty) as s_qty
              from m_item
              left join m_satuan on i_satuan=s_id
              left join m_group on g_id=i_group
              left join d_stock on s_item=i_id 
              where FIND_IN_SET (s_comp,(select ag_gudang from m_acces_gudangitem where ag_fitur='Penjualan'))
              AND FIND_IN_SET (s_position,(select ag_gudang from m_acces_gudangitem where ag_fitur='Penjualan'))
              ".$item."
              group by i_id,i_code,s_comp,g_name,i_name,s_name
              order by i_id";
        $exec= DB::select($sql);



        $results = array();
                        
        if ($exec==null) {
          $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
        } else {
          foreach ($exec as $data)
          {
            $results[] = ['label' => $data->i_name.'  (Rp. ' .number_format($data->i_price,0,',','.').')', 'i_id' => $data->i_id,'satuan' =>$data->s_name,'stok' =>$data->s_qty,'i_code' =>$data->i_code,'i_price' =>number_format($data->i_price,0,',','.'),'item' => $data->i_name];
          }
        } 
        return Response::json($results);


    }



      public static function searchItemCode($item) {      


        $search = $item->code;

       

        $sql="select 
              i_id,
              i_code,
              s_comp,
              group_concat(DISTINCT  s_position separator ',') as s_position,
              g_name,
              i_name,
              s_name,
              group_concat(DISTINCT i_price separator ',') as i_price,sum(s_qty) as s_qty
              from m_item
              join m_satuan on i_satuan=s_id
              join m_group on g_id=i_group
              join d_stock on s_item=i_id 
              where FIND_IN_SET (s_comp,(select ag_gudang from m_acces_gudangitem where ag_fitur='Penjualan'))
              AND FIND_IN_SET (s_position,(select ag_gudang from m_acces_gudangitem where ag_fitur='Penjualan'))
              AND i_code='".$search."'
              group by i_id,i_code,s_comp,g_name,i_name,s_name
              order by i_id";

        $exec= DB::select($sql);


         $results = array();
                        
        if ($exec==null) {
          $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
        } else {
          foreach ($exec as $data)
          {
            $results[] = ['label' => $data->i_name.'  (Rp. ' .number_format($data->i_price,0,',','.').')', 'i_id' => $data->i_id,'satuan' =>$data->s_name,'stok' =>$data->s_qty,'i_code' =>$data->i_code,'i_price' =>number_format($data->i_price,0,',','.'),'item' => $data->i_name];
          }
        } 

        return json_encode($results);
    }
    

     public static function seachItemPurchase($item) {

        $search = $item->term;
        $id_supplier =$item->id_supplier;
        $sql=DB::table('m_item')->join('d_item_supplier','is_item','=','i_id')
             ->join('m_supplier','s_id','=','is_supplier')
             ->join('d_stock','s_item','=','i_id');

        if($search!='' && $id_supplier!=''){          
            $sql->where(function ($query) use ($search,$id_supplier) {
                  $query->where('i_name','like','%'.$search.'%');                  
                  $query->where('is_supplier',$id_supplier); 
                  $query->orWhere('i_code','like','%'.$search.'%');
                  $query->where('is_supplier',$id_supplier); 
                  });
                  }                                  
               
        $sql=$sql->get();



        $results = array();
                        
        if (count($sql)==0) {
          $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
        } else {
          foreach ($sql as $data)
          {
            $results[] = ['label' => $data->i_name.'  (Rp. ' .number_format($data->is_price,0,',','.').')', 'i_id' => $data->i_id,'satuan' =>$data->s_name,'stok' =>$data->s_qty,'i_code' =>$data->i_code,'i_price' =>number_format($data->i_price,0,',','.'),'item' => $data->i_name];
          }
        } 
        return Response::json($results);

    }
}
	