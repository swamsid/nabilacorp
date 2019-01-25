<?php

namespace App\Modules\POS\model;

use Illuminate\Database\Eloquent\Model;

use DB;

use Datatables;

use App\Lib\format;

use App\Lib\mutasi;

use Session;

class d_mutasi_item extends Model
{  
    protected $table = 'd_mutasi_item';
    protected $primaryKey = 'mi_id';
    const CREATED_AT = 'mi_created';
    const UPDATED_AT = 'mi_updated';

    protected $fillable = ['mi_id','mi_comp','mi_date','mi_code','mi_keterangan'];

    static function mutasiItem($request){
      $from=date('Y-m-d',strtotime($request->tanggal1));
      $to=date('Y-m-d',strtotime($request->tanggal2));
      

             $mutasiItem=d_mutasi_item::whereBetween('mi_date', [$from, $to])->where('mi_comp',Session::get('user_comp'))->get();
             return Datatables::of($mutasiItem)                                                
                        ->editColumn('mi_date', function ($mutasiItem) {                            
                                return date('d-m-Y',strtotime($mutasiItem->mi_date));                            
                        })                                           
                        ->addColumn('action', function ($mutasiItem) {  
                          $html='';  
                          $html.='<div class="text-center">
                          <button class="btn btn-sm btn-success" title="Detail" onclick="detailMutasi(
                                                '.$mutasiItem->mi_id.',          
                                                \''.date('d-m-Y',strtotime($mutasiItem->mi_date)).'\',   
                                                \''.$mutasiItem->mi_code.'\',
                                                \''.$mutasiItem->mi_keterangan.'\'                                                
                          )"><i class="fa fa-eye"></i> 
                          </button>
                          
                          </div>';
                            return $html;
                        })
                        ->rawColumns(['action'])
                      ->make(true);       



                      /*<button class="btn btn-sm btn-warning" title="Edit" onclick="editMutasi(
                                                '.$mutasiItem->mi_id.',          
                                                \''.date('d-m-Y',strtotime($mutasiItem->mi_date)).'\',   
                                                \''.$mutasiItem->mi_code.'\',
                                                \''.$mutasiItem->mi_keterangan.'\'          
                          )" ><i class="fa fa-edit"></i>
                          </button>
                          <button class="btn btn-sm btn-danger" title="Hapus" onclick="deleteMutasi(
                                                '.$mutasiItem->mi_id.',          
                                                \''.date('d-m-Y',strtotime($mutasiItem->mi_date)).'\',   
                                                \''.$mutasiItem->mi_code.'\',
                                                \''.$mutasiItem->mi_keterangan.'\'    
                          )" ><i class="fa fa-times"></i>
                          </button>*/                           
    }

     static function store($request){
         return DB::transaction(function () use ($request) {                         
    $mi_id=d_mutasi_item::max('mi_id')+1;



     $query = DB::select(DB::raw("SELECT MAX(RIGHT(mi_code,4)) as kode_max from d_mutasi_item WHERE DATE_FORMAT(mi_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
      $kd = "";

      if(count($query)>0)
      {
        foreach($query as $k)
        {
          $tmp = ((int)$k->kode_max)+1;
          $kd = sprintf("%05s", $tmp);
        }
      }
      else
      {
        $kd = "00001";
      }
      

      $mi_code = "MI-".date('ym')."-".$kd;

      $mp_code = "MP-".date('ym')."-".$kd;
      d_mutasi_item::create([
            'mi_id'=>$mi_id,
            'mi_comp'=>Session::get('user_comp'),
            'mi_code'=>$mi_code,
            'mi_date'=>date('Y-m-d',strtotime($request->mi_date)),
            'mi_keterangan'=>$request->mi_keterangan,
        ]);


      $jumlah=count($request->mm_item);      
    for ($i=0; $i <$jumlah ; $i++) { 
        $mm_comp=$request->mm_comp[$i];
        $mm_position=$request->mm_position[$i];

        if(mutasi::mutasiStok($request->mm_item[$i],format::format($request->mm_qty[$i]),$mm_comp,$mm_position,$flag='',$mi_id,$flagTujuan='Mutasi Item',$idMutasiTujuan='')){

            $mm_detailid=d_mutationitem_material::where('mm_mutationitem',$mi_id)
                               ->max('mm_detailid')+1;     
            $mm_qty= format::format($request->mm_qty[$i]);                           
            d_mutationitem_material::create([
                'mm_mutationitem'=>$mi_id,
                'mm_detailid'=>$mm_detailid,
                'mm_comp'=>$mm_comp,
                'mm_position'=>$mm_position,
                'mm_item'=>$request->mm_item[$i],
                'mm_qty'=>$mm_qty              
            ]);
      }
      else{
          
                     
            $data=['status'=>'gagal','data'=>'Stok tidak mencukupi.'];
            DB::rollBack();
            return $data;
      }
    }

    
    $jumlah=count($request->mp_item);
    for ($s=0; $s <$jumlah ; $s++) {     
        $mp_comp=$request->mp_comp[$s];
        $mp_position=$request->mp_position[$s];       
        $mp_hpp= format::format($request->mp_hpp[$s]);       
        $mp_detailid=d_mutationitem_product::where('mp_mutationitem',$mi_id)
                                     ->max('mp_detailid')+1;     
            $mp_qty=format::format($request->mp_qty[$s]);
            d_mutationitem_product::create([
                    'mp_mutationitem'=>$mi_id,
                    'mp_detailid'=>$mp_detailid,
                    'mp_comp'=>$mm_comp,
                    'mp_position'=>$mm_position,
                    'mp_item'=>$request->mp_item[$s],
                    'mp_qty'=>$mp_qty,
                    'mp_hpp'=>$mp_hpp,
              ]);


          $simpanMutasi=mutasi::tambahmutasi($request->mp_item[$s],$mp_qty,$mp_comp,$mp_position,'Mutasi Item',15,$mi_code,'','',$mp_hpp,date('Y-m-d',strtotime($request->mi_date)));


        }

          $data=['status'=>'sukses','data'=>'sukses'];
          return json_encode($data);
      });
    }

    static function perbarui($request,$id){

         return DB::transaction(function () use ($request,$id) {   

         $hapusdtBahan=[];
          if($request->hapusdtBahan!=null){
            $hapusdtBahan = explode(',',$request->hapusdtBahan);
          }


  //Hapus Material          
        for ($h=0; $h <count($hapusdtBahan) ; $h++) { 
                $hapusItem=$hapusdtBahan[$h];
                $hapus_material_dt=d_mutationitem_material::where('mm_mutationitem',$id)                                  
                                  ->where('mm_item',$hapusItem);                  
                if(count($hapus_material_dt->first())!=0){
                  $permintaan=$hapus_material_dt->first()->mm_qty;

                  if($permintaan>0){                         

                         $mm_comp=$request->mm_comp[$i];
                         $mm_position=$request->mm_position[$i];

                        if(mutasi::updateMutasi($hapusItem,-$permintaan,$mm_comp,$mm_position,$flag='',$id)){
                          $hapus_material_dt->delete();
                        }
                    }
                }
          }











     //update Material

 for ($i=0; $i <count($request->mm_item); $i++) {  
   

              if($request->mm_mutationitem[$i]!=='' && $request->mm_detailid[$i]!=='' &&
                $request->mm_mutationitem[$i]!==null && $request->mm_detailid[$i]!==null){  

                  $permintaan=format::format($request->mm_qty[$i])-format::format($request->jumlahAwalBahan[$i]);                  

              if(mutasi::updateMutasi($request->mm_item[$i],$permintaan,$comp=1,$position=1,$flag='',$id)){

                $update_material_dt=d_mutationitem_material::where('mm_mutationitem',$id)
                                  ->where('mm_detailid',$request->mm_detailid[$i])
                                  ->where('mm_item',$request->mm_item[$i]);                                  

                $mm_qty = format::format($request->mm_qty[$i]);

                $update_material_dt->update([
                                  'mm_qty'=>$mm_qty,
                                  ]);

              }else{
                   $data=['status'=>'gagal','data'=>'gagal'];
                   DB::rollBack();
                  return json_encode($data);
                }    
         }else{
          
                $mm_qty=format::format($request->mm_qty[$i]);
              
                
                  if(mutasi::mutasiStok($request->mm_item[$i],$mm_qty,$comp=1,$position=1,$flag='',$id)){
                  $mm_detailid=d_mutationitem_material::where('mm_mutationitem',$id)->max('mm_detailid')+1;      

                      d_mutationitem_material::create([
                            'mm_mutationitem'=>$id,
                            'mm_detailid'=>$mm_detailid,
                            'mm_comp'=>Session::get('user_comp'),
                            'mm_item'=>$request->mm_item[$i],
                            'mm_qty'=>$mm_qty              
                      ]);
                }

            else{
               $data=['status'=>'gagal','data'=>'gagal'];
               DB::rollBack();
              return json_encode($data);
            }          
        



         }
      }



//hapus hasil


            $hapusdtHasil=[];
          if($request->hapusdtHasil!=null){
            $hapusdtHasil = explode(',',$request->hapusdtHasil);
          }


  //Hapus Material          
        for ($h=0; $h <count($hapusdtHasil) ; $h++) { 
                $hapusItem=$hapusdtHasil[$h];
                $hapus_product_dt=d_mutationitem_product::where('mp_mutationitem',$id)                                  
                                  ->where('mp_item',$hapusItem);                                              
                if(count($hapus_product_dt->first())!=0){
                  $permintaan=$hapus_product_dt->first()->mp_qty;

                  if($permintaan>0){                                        
                        if(mutasi::hapusMutasi($hapusItem,$permintaan,$comp=1,$position=1,$flag='Hasil Mutasi Item',$sm_reff=$id)){
                          $hapus_product_dt->delete();
                        }
                    }
                }
          }












//hasil

 for ($i=0; $i <count($request->mp_item); $i++) {  
        

              if($request->mp_mutationitem[$i]!=='' && $request->mp_detailid[$i]!=='' &&
                $request->mp_mutationitem[$i]!==null && $request->mp_detailid[$i]!==null){  

            if(format::format($request->jumlahAwalHasil[$i])!=format::format($request->mp_qty[$i])){

                  $permintaan=format::format($request->mp_qty[$i])-format::format($request->jumlahAwalHasil[$i]);  
                  $mp_hpp= format::format($request->mp_hpp[$i]);                  
                  

              if(mutasi::perbaruimutasi($request->mp_item[$i],$permintaan,$comp=1,$position=1,$flag='Hasil Mutasi Item',$idFlag=1,$request->mi_code,$flagTujuan='',$idMutasiTujuan='',$mp_hpp)){

                $update_product_dt=d_mutationitem_product::where('mp_mutationitem',$id)
                                  ->where('mp_detailid',$request->mp_detailid[$i])
                                  ->where('mp_item',$request->mp_item[$i]);                                  

                $mp_qty = format::format($request->mp_qty[$i]);

                $update_product_dt->update([
                                  'mp_qty'=>$mp_qty,
                                  'mp_hpp'=>$mp_hpp,
                                  ]);

              }else{
                   $data=['status'=>'gagal','data'=>'gagal'];
                   DB::rollBack();
                  return json_encode($data);
                }    

              }
         }else{
          
                $mm_qty=format::format($request->mm_qty[$i]);
                $mp_hpp= format::format($request->mp_hpp[$i]);       
                $mp_detailid=d_mutationitem_product::where('mp_mutationitem',$id)->max('mp_detailid')+1;     
                $mp_qty=format::format($request->mp_qty[$i]);
                d_mutationitem_product::create([
                    'mp_mutationitem'=>$id,
                    'mp_detailid'=>$mp_detailid,
                    'mp_comp'=>Session::get('user_comp'),
                    'mp_item'=>$request->mp_item[$i],
                    'mp_qty'=>$mp_qty,
                    'mp_hpp'=>$mp_hpp,
                ]);
              mutasi::tambahmutasi($request->mp_item[$i],$mp_qty,1,1,'Mutasi Item','',$id,'','',$mp_hpp);

          



         }
      }






$data=['status'=>'sukses','data'=>'sukses'];
return json_encode($data);



       
      });


  }

  static function destroy($id){

         return DB::transaction(function () use ($id) {        
        $material_dt=d_mutationitem_material::where('mm_mutationitem',$id)->get();

  //Hapus Material          
        for ($h=0; $h <count($material_dt) ; $h++) { 
                $hapusItem=$material_dt[$h]->mm_item;
                $hapus_material_dt=d_mutationitem_material::where('mm_mutationitem',$id)                                  
                                  ->where('mm_item',$hapusItem);                                                    
                if(count($hapus_material_dt->first())!=0){
                  $permintaan=$hapus_material_dt->first()->mm_qty;
                  if($permintaan>0){                                        
                        if(mutasi::updateMutasi($hapusItem,-$permintaan,$comp=1,$position=1,$flag='',$id)){
                          $hapus_material_dt->delete();
                        }
                    }
                }
          }


    $product_dt=d_mutationitem_product::where('mp_mutationitem',$id)->get();


  //Hapus Material          
        for ($h=0; $h <count($product_dt) ; $h++) { 
                $hapusItem=$product_dt[$h]->mp_item;
                $hapus_product_dt=d_mutationitem_product::where('mp_mutationitem',$id)                                  
                                  ->where('mp_item',$hapusItem);                                              
                if(count($hapus_product_dt->first())!=0){
                  $permintaan=$hapus_product_dt->first()->mp_qty;

                  if($permintaan>0){                                        
                        if(mutasi::hapusMutasi($hapusItem,$permintaan,$comp=1,$position=1,$flag='Hasil Mutasi Item',$sm_reff=$id)){
                          $hapus_product_dt->delete();
                        }
                    }
                }
          }

          d_mutasi_item::where('mi_id',$id)->delete();
  $data=['status'=>'sukses','data'=>'sukses'];
  return json_encode($data);



});
  }
}
	