<?php

namespace App\Modules\Master\model;

use Illuminate\Database\Eloquent\Model;

use DB;
use Response;
use Datatables;
use Session;

class m_item_titipan extends Model
{
    protected $table = 'm_item';  
    protected $primaryKey = 'i_id';
    const CREATED_AT = 'i_insert';
    const UPDATED_AT = 'i_update';

    public static function dataBarang(){
        $data = DB::table('m_item')
              ->leftJoin('m_group', 'g_id', '=', 'i_group')
              ->leftJoin('m_satuan', 's_id', '=', 'i_sat1')
              ->leftJoin('d_item_titipan_supplier', 'i_id', '=', 'its_id')
              ->where('i_active', 'Y')
              ->where('i_type', 'BTPN')
              ->select('i_id', 'i_code', 'i_name', 's_name', 'i_hpp', 'its_price1', 'g_name')
              ->get();
         return Datatables::of($data)->editColumn('action', function ($data) {                            
                                return '<div class="">
                                        <a href="#" class="btn btn-warning btn-xs" title="Edit" onclick="edit('.$data->i_id.')"><i class="glyphicon glyphicon-pencil"></i></a>
                                        <a href="#" class="btn btn-danger btn-xs" title="Hapus" onclick="hapus('.$data->i_id.')"><i class="glyphicon glyphicon-trash"></i></a>
                                      </div>';
                        })->make(true);        
    }

    public static function seachItem($item) {      
        //cari barang jual

        $search = $item->term;

        $harga = $item->harga;

        $cabang=Session::get('user_comp');                

        $position=DB::table('d_gudangcabang')
                      ->where('gc_gudang',DB::raw("'GUDANG PENJUALAN'"))
                      ->where('gc_comp',$cabang)
                      ->select('gc_id')->first();   
        $comp=$position->gc_id;
        $position=$position->gc_id;


        $groupName=['BTPN','BJ','BP'];


            

        $sql=DB::table('m_item')
             ->leftjoin('d_stock',function($join) use ($comp,$position) {
                  $join->on('s_item','=','i_id');
                  $join->where('s_comp',$comp); 
                  $join->where('s_position',$position);


             })
             ->join('m_satuan','m_satuan.s_id','=','i_satuan')
             /*->join('m_group','g_id','=','i_group')*/
                  ->join('m_price','m_pitem','=','i_id');
             /*->join('m_group','g_id','=','i_group')*/
             
         if($harga==1){
          $sql->select('i_id','i_name','m_satuan.s_name as s_name','m_psell1 as i_price','s_qty','i_code');
        }
        if($harga==2){
          $sql->select('i_id','i_name','m_satuan.s_name as s_name','m_psell2 as i_price','s_qty','i_code');
        }
        if($harga==3){
          $sql->select('i_id','i_name','m_satuan.s_name as s_name','m_psell3 as i_price','s_qty','i_code');
        }
          
             

        if($search!=''){          
            $sql->where(function ($query) use ($search,$groupName) {
                  $query->where('i_name','like','%'.$search.'%');                                    
                  $query->whereIn('i_type',$groupName);                                     

                  $query->orWhere('i_code','like','%'.$search.'%');                                    
                  $query->whereIn('i_type',$groupName); 
                  });
                  }                                  
        else{
          $results[] = [ 'id' => null, 'label' =>'Data belum lengkap'];
          return Response::json($results);
        }
               
        $sql=$sql->get();
        
        

        $results = array();
                        
        if (count($sql)==0) {
          $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
        } else {
          foreach ($sql as $data)
          {
            $results[] = ['label' => $data->i_name.'  (Rp. ' .number_format($data->i_price,0,',','.').')', 'i_id' => $data->i_id,'satuan' =>$data->s_name,'stok' =>number_format($data->s_qty,0,',','.'),'i_code' =>$data->i_code,'i_price' =>number_format($data->i_price,0,',','.'),'item' => $data->i_name ,'position'=>$position,
              'comp'=>$comp];
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
              AND i_code=:s
              group by i_id,i_code,s_comp,g_name,i_name,s_name
              order by i_id";

        $exec= DB::select(DB::raw($sql),['s'=>$search]);


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
      // return $item;
      // dd($item->all());
        $search = $item->term;
        $id_supplier =$item->id_supplier;

        $groupName=['BB'];
        $cabang = Session::get('user_comp');                
        $position=DB::table('d_gudangcabang')
                      // ->where('gc_gudang',DB::raw("'GUDANG PEMBELIAN'"))
                      ->where('gc_comp',$cabang)
                      ->select('gc_id')
                      ->first();   
        // return json_encode($position);
        $comp=$position->gc_id;
        $position=$position->gc_id;


        $sql=DB::table('m_item')
            ->leftjoin('d_item_supplier',function($join) use ($id_supplier) {
                  $join->on('is_item','=','i_id');
                  $join->where('is_supplier',$id_supplier); 
             })
             ->leftjoin('m_supplier','s_id','=','is_supplier')
             ->leftjoin('d_stock',function($join) use ($comp,$position) {
                  $join->on('s_item','=','i_id');
                  $join->where('s_comp',$comp); 
                  $join->where('s_position',$position);
             })
             ->join('m_satuan as ms_1','ms_1.s_id','=','i_satuan')
             ->join('m_satuan as ms_2','ms_2.s_id','=','i_sat2')
             ->join('m_satuan as ms_3','ms_3.s_id','=','i_sat3')
             ->leftjoin('m_price as prc','prc.m_pitem','=','i_id')
             ->select('i_id','i_name','i_satuan','i_sat2','i_sat3','ms_1.s_name as satuan_1','ms_2.s_name as satuan_2','ms_3.s_name as satuan_3','is_price','s_qty','i_code','m_pbuy1','m_pbuy2','m_pbuy3');
        if($search!='' && $id_supplier!=''){          
            $sql->where(function ($query) use ($search,$groupName) {
                  $query->where('i_name','like','%'.$search.'%');                  
                  $query->whereIn('i_type',$groupName);                          
                  $query->orWhere('i_code','like','%'.$search.'%');
                  $query->whereIn('i_type',$groupName);        
                  
                  });
                  }                                  
        else{
          $results[] = [ 'id' => null, 'label' =>'Data belum lengkap'];
          return Response::json($results);
        }

               
        $sql=$sql->get();

        // return $sql;

        $results = array();
                        
        if (count($sql)==0) {
          $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
        }else{
          foreach ($sql as $data)
          {
            $results[] = [
                    'label'    => $data->i_name, 
                    'i_id'     => $data->i_id,
                    'satuan_1' => $data->satuan_1,
                    'satuan_2' => $data->satuan_2,
                    'satuan_3' => $data->satuan_3,
                    'sat1_id'  => $data->i_satuan,
                    'sat2_id'  => $data->i_sat2,
                    'sat3_id'  => $data->i_sat3,
                    'm_pbuy1'  => number_format($data->m_pbuy1,0,',','.'),
                    'm_pbuy2'  => number_format($data->m_pbuy2,0,',','.'),
                    'm_pbuy3'  => number_format($data->m_pbuy3,0,',','.'),
                    'stok'     => number_format($data->s_qty,0,',','.'),
                    'i_code'   => $data->i_code,
                    'i_price'  => number_format($data->is_price,0,',','.'),
                    'item'     => $data->i_name];
          }
        } 
        return Response::json($results);
    }

    //pencarian barang titipan
    //group harus merujuk barang titipan
    //masuk gudang penjualan
    public static function searchItemTitipan($item) {

        $search = $item->term;
        $id_supplier =$item->id_supplier;
        $cabang=Session::get('user_comp');                

        $position=DB::table('d_gudangcabang')
                      ->where('gc_gudang',DB::raw("'GUDANG PENJUALAN'"))
                      ->where('gc_comp',$cabang)
                      ->select('gc_id')->first();   
        $comp=$position->gc_id;
        $position=$position->gc_id;
        



        if(!$position){
            $results[] = [ 'id' => null, 'label' =>'Data Gudang Titipan Tidak Ada.'];
            return Response::json($results);
        }



        $sql=DB::table('m_item')->LEFTjoin('d_item_supplier','is_item','=','i_id')
             ->leftjoin('m_supplier','s_id','=','is_supplier')
             ->leftjoin('d_stock',function($join) use ($comp,$position) {
                    $join->on('s_item','=','i_id');
                    $join->where('s_comp',$comp); 
                    $join->where('s_position',$position); 
             })
             ->LEFTjoin('m_satuan','m_satuan.s_id','=','i_satuan')
             /*->join('m_group','g_id','=','i_group')*/
             ->select('i_id','i_name','m_satuan.s_name as s_name','is_price','s_qty','i_code');

        if($search!='' && $id_supplier!=''){          

            $sql->where(function ($query) use ($search,$id_supplier) {
                  $query->where('i_name','like','%'.$search.'%');                  
                  /*$query->where('is_supplier',$id_supplier); */
                  $query->where('i_type',DB::raw("'BTPN'"));    

                  $query->orWhere('i_code','like','%'.$search.'%');
                  /*$query->where('is_supplier',$id_supplier); */
                  $query->where('i_type',DB::raw("'BTPN'")); 


                  });
                  }                                  
        else{
          $results[] = [ 'id' => null, 'label' =>'Data belum lengkap'];
          return Response::json($results);
        }
             
        $sql=$sql->get();        

        $results = array();
                        
        if (count($sql)==0) {
          $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
        } else {
          foreach ($sql as $data)
          {
            $results[] = ['label' => $data->i_name.'  (Rp. ' .number_format($data->is_price,0,',','.').')', 'i_id' => $data->i_id,'satuan' =>$data->s_name,'stok' =>number_format($data->s_qty,0,',','.'),'i_code' =>$data->i_code,'i_price' =>number_format($data->is_price,0,',','.'),'item' => $data->i_name, 'position'=>$position,  
              'comp'=>$comp];
          }
        } 
        return Response::json($results);

    }

    //cari barang jual
    public static function seachItemProduksi($item) {      


        $search = $item->term;

        $cabang=Session::get('user_comp');                

        $position=DB::table('d_gudangcabang')
                      /*->where('gc_gudang',DB::raw("'GUDANG PENJUALAN'"))//sementara              */
                      ->where('gc_gudang',DB::raw("'GUDANG PRODUKSI'"))
                      ->where('gc_comp',$cabang)
                      ->select('gc_id')->first();   
        $comp=$position->gc_id;
        $position=$position->gc_id;


        $groupName=['BPD','BJ'];


            

        $sql=DB::table('m_item')
             ->leftjoin('d_stock',function($join) use ($comp,$position) {
                  $join->on('s_item','=','i_id');
                  $join->where('s_comp',$comp); 
                  $join->where('s_position',$position);


             })
             ->join('m_satuan','m_satuan.s_id','=','i_satuan')
             /*->join('m_group','g_id','=','i_group')*/
             ->select('i_id','i_name','m_satuan.s_name as s_name','i_price','s_qty','i_code','i_hpp');
             

        if($search!=''){          
            $sql->where(function ($query) use ($search,$groupName) {
                  $query->where('i_name','like','%'.$search.'%');                                    
                  $query->whereIn('i_type',$groupName);                                     

                  $query->orWhere('i_code','like','%'.$search.'%');                                    
                  $query->whereIn('i_type',$groupName); 
                  });
                  }                                  
        else{
          $results[] = [ 'id' => null, 'label' =>'Data belum lengkap'];
          return Response::json($results);
        }
               
        $sql=$sql->get();
        
        

        $results = array();
                        
        if (count($sql)==0) {
          $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
        } else {
          foreach ($sql as $data)
          {
            $results[] = ['label' => $data->i_name.'  (Rp. ' .number_format($data->i_hpp,0,',','.').')', 'i_id' => $data->i_id,'satuan' =>$data->s_name,'stok' =>number_format($data->s_qty,0,',','.'),'i_code' =>$data->i_code,'i_price' =>number_format($data->i_hpp,0,',','.'),'item' => $data->i_name ,'position'=>$position,
              'comp'=>$comp];
          }
        } 
        return Response::json($results);
    }

    //cari barang mutasi item
    public static function seachItemMutasi($item) {      


        $search = $item->term;
        $cabang=Session::get('user_comp');                

        $position=DB::table('d_gudangcabang')
                      ->where('gc_gudang',DB::raw("'GUDANG PENJUALAN'"))
                      ->where('gc_comp',$cabang)
                      ->select('gc_id')->first();   
        $comp=$position->gc_id;
        $position=$position->gc_id;


        $groupName=['BPD','BJ'];


            

        $sql=DB::table('m_item')
             ->leftjoin('d_stock',function($join) use ($comp,$position) {
                  $join->on('s_item','=','i_id');
                  $join->where('s_comp',$comp); 
                  $join->where('s_position',$position);


             })
             ->join('m_satuan','m_satuan.s_id','=','i_satuan')
             /*->join('m_group','g_id','=','i_group')*/
             ->select('i_id','i_name','m_satuan.s_name as s_name','i_price','s_qty','i_code');
             

        if($search!=''){          
            $sql->where(function ($query) use ($search,$groupName) {
                  $query->where('i_name','like','%'.$search.'%');                                    
                  $query->whereIn('i_type',$groupName);                                     

                  $query->orWhere('i_code','like','%'.$search.'%');                                    
                  $query->whereIn('i_type',$groupName); 
                  });
                  }                                  
        else{
          $results[] = [ 'id' => null, 'label' =>'Data belum lengkap'];
          return Response::json($results);
        }
               
        $sql=$sql->get();
        
        

        $results = array();
                        
        if (count($sql)==0) {
          $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
        } else {
          foreach ($sql as $data)
          {
            $results[] = ['label' => $data->i_name.'  (Rp. ' .number_format($data->i_price,0,',','.').')', 'i_id' => $data->i_id,'satuan' =>$data->s_name,'stok' =>number_format($data->s_qty,0,',','.'),'i_code' =>$data->i_code,'i_price' =>number_format($data->i_price,0,',','.'),'item' => $data->i_name ,'position'=>$position,
              'comp'=>$comp];
          }
        } 
        return Response::json($results);
    }

    // barang spk
    public static function itemSpk($item){
    
    
        $search = $item->term;

        $groupName=['BPD','BP'];


            

        $sql=DB::table('m_item')
             /*->leftjoin('d_stock',function($join) use ($comp,$position) {
                  $join->on('s_item','=','i_id');
                  $join->where('s_comp',$comp); 
                  $join->where('s_position',$position);


             })*/
             ->join('m_satuan','m_satuan.s_id','=','i_satuan')
             /*->join('m_group','g_id','=','i_group')*/
             ->select('i_id','i_name','m_satuan.s_name as s_name','i_price','i_code');
             

        if($search!=''){          
            $sql->where(function ($query) use ($search,$groupName) {
                  $query->where('i_name','like','%'.$search.'%');                                    
                  $query->whereIn('i_type',$groupName);                                     

                  $query->orWhere('i_code','like','%'.$search.'%');                                    
                  $query->whereIn('i_type',$groupName); 
                  });
        }else{
          $results[] = [ 'id' => null, 'label' =>'Data belum lengkap'];
          return Response::json($results);
        }
               
        $sql=$sql->get();
        
        

        $results = array();
                        
        if (count($sql)==0) {
          $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
        } else {
          foreach ($sql as $data)
          {
            $results[] = ['label' => $data->i_name.'  (Rp. ' .number_format($data->i_price,0,',','.').')', 'i_id' => $data->i_id,'satuan' =>$data->s_name,'i_code' =>$data->i_code,'i_price' =>number_format($data->i_price,0,',','.'),'item' => $data->i_name];
          }
        } 
        return Response::json($results);

  }

  function m_satuan() {
    $res = $this->belongsTo('App\m_satuan', 'i_satuan', 's_id');

        return $res;
  }

  function m_group() {
    $res = $this->belongsTo('App\m_group', 'i_group', 'g_id');

        return $res;
  }
}
