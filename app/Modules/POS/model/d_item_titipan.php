<?php

namespace App\Modules\POS\model;

use Illuminate\Database\Eloquent\Model;

use DB;

use Datatables;

use App\Lib\format;

use App\Lib\mutasi;

use Session;

class d_item_titipan extends Model
{  



    protected $table = 'd_item_titipan';
    protected $primaryKey = 'it_id';
    const CREATED_AT = 'it_created';
    const UPDATED_AT = 'it_updated';

    protected $fillable = ['it_id','it_comp','it_code','it_supplier','it_date','it_toko','it_note','it_total','it_keterangan','it_status','it_bayar','it_disc'];

    static function itemTitipan($request){
      $from=date('Y-m-d',strtotime($request->tanggal1));
      $to=date('Y-m-d',strtotime($request->tanggal2));
      

             $itemTitipan=d_item_titipan::join('m_supplier','s_id','=','it_supplier')->whereBetween('it_date', [$from, $to])->where('it_comp',Session::get('user_comp'))->get();
             return Datatables::of($itemTitipan)                                                
                        ->editColumn('it_date', function ($itemTitipan) {                            
                                return date('d-m-Y',strtotime($itemTitipan->it_date));                            
                        })    
                        ->editColumn('it_total', function ($itemTitipan) {                            
                                return number_format($itemTitipan->it_total,'0',',','.');                            
                        })                                       
                        ->addColumn('action', function ($itemTitipan) {  
                          $disable='';
                          if($itemTitipan->it_status=='lunas'){
                            $disable='disabled';
                          }
                          $html='';  
                          $html.='<div class="text-center">
                          <button type="button" class="btn btn-sm btn-primary" title="Serah Terima" onclick="serahterima(
                                               '.$itemTitipan->it_id.',          
                                                \''.date('d-m-Y',strtotime($itemTitipan->it_date)).'\',   
                                                \''.$itemTitipan->it_code.'\',
                                                \''.$itemTitipan->it_keterangan.'\'  
                          )"  '.$disable.' ><i class="fa fa-folder-open-o"></i>
                          </button>
                          <button type="button" class="btn btn-sm btn-success" title="Detail" onclick="detail(
                                                '.$itemTitipan->it_id.',          
                                                \''.date('d-m-Y',strtotime($itemTitipan->it_date)).'\',   
                                                \''.$itemTitipan->it_code.'\',
                                                \''.$itemTitipan->it_keterangan.'\'                                                
                          )"><i class="fa fa-eye"></i> 
                          </button>
                       
                      
                          </div>';
                            return $html;
                        })
                        ->rawColumns(['action'])
                      ->make(true);    



   /*<button  type="button" class="btn btn-sm btn-warning" title="Edit" onclick="edit(
                                               '.$itemTitipan->it_id.',          
                                                \''.date('d-m-Y',strtotime($itemTitipan->it_date)).'\',   
                                                \''.$itemTitipan->it_code.'\',
                                                \''.$itemTitipan->s_company.'\',
                                                \''.$itemTitipan->s_id.'\',
                                                \''.$itemTitipan->it_keterangan.'\',
                                                \''.number_format($itemTitipan->it_total,0,',','.').'\'
                          )" '.$disable.'><i class="fa fa-edit"></i>
                          </button>*/


                          /*<button type="button" class="btn btn-sm btn-danger" title="Hapus" onclick="delete(
                                               '.$itemTitipan->it_id.',          
                                                \''.date('d-m-Y',strtotime($itemTitipan->it_date)).'\',   
                                                \''.$itemTitipan->it_code.'\',
                                                \''.$itemTitipan->it_keterangan.'\'  
                          )" '.$disable.' ><i class="fa fa-times"></i>
                          </button>*/                              
    }
    static function dataTitipan($id){      
             $itemTitipan=d_item_titipan::join('m_supplier','s_id','=','it_supplier')->where('it_comp',Session::get('user_comp'))->where('it_id',$id)->first();                          
             return $itemTitipan;

    }
     static function store($request){
         return DB::transaction(function () use ($request) {  

          
    // dilarang menyimpan ketika belum lunas
    $chekTitipanBayar=d_item_titipan::where('it_supplier',$request->id_supplier);

    //sehari hanya boleh sakali input
    
    if($chekTitipanBayar->where('it_date','=',date('Y-m-d',strtotime($request->it_date)))->count()!=0){
          $data=['status'=>'gagal','data'=>"Maa'af, data dengan supplier yang sama hanya boleh sekali dalam sehari (silahkan melakukan update data)."];
          return json_encode($data);
    }
    
    $chekTitipanBayar=d_item_titipan::where('it_supplier',$request->id_supplier);
    if($chekTitipanBayar->count()!=0){

      if($chekTitipanBayar->where('it_status','!=','lunas')->count()!=0){
          $data=['status'=>'gagal','data'=>"Maa'af, anda belum serah terima untuk data kemarin, harap selesaikan terlebih dulu"];
          return json_encode($data);
      }
    }
          
    
    $it_id=d_item_titipan::max('it_id')+1;



     $query = DB::select(DB::raw("SELECT MAX(RIGHT(it_code,4)) as kode_max from d_item_titipan WHERE DATE_FORMAT(it_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
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
      

      $it_code = "IT-".date('ym')."-".$kd;
      $it_total= format::format($request->it_total);        
        
      d_item_titipan::create([
            'it_id'=>$it_id,
            'it_supplier'=>$request->id_supplier,
            'it_comp'=>Session::get('user_comp'),
            'it_code'=>$it_code,
            'it_date'=>date('Y-m-d',strtotime($request->it_date)),
            'it_keterangan'=>$request->it_keterangan,
            'it_total' =>$it_total,
        ]);


      $jumlah=count($request->idt_item);      
    for ($i=0; $i <$jumlah ; $i++) { 
        $comp=$request->comp[$i];
        $position=$request->position[$i];
        $idt_return=format::format($request->idt_return_qty[$i]); 
        $idt_qty= format::format($request->idt_qty[$i]); 
        $jumlahQty=$idt_return+$idt_qty;

        $hpp= format::format($request->idt_price[$i]);   
        $simpanMutasi=mutasi::tambahmutasi(
          $request->idt_item[$i],
          $jumlahQty,
          $comp,$position,
          'BARANG TITIPAN',
          13,
          $it_id,
          '',
          '',
          $hpp,
          date('Y-m-d',strtotime($request->it_date))
          );        
        if($simpanMutasi['true']){              
            $idt_detailid=d_itemtitipan_dt::where('idt_itemtitipan',$it_id)
                               ->max('idt_detailid')+1;                                           
            d_itemtitipan_dt::create([
                'idt_itemtitipan'=>$it_id,
                'idt_detailid'=>$idt_detailid,
                'idt_date'    => date('Y-m-d',strtotime($request->it_date)),
                'idt_comp'=>Session::get('user_comp'),
                'idt_item'=>$request->idt_item[$i],
                'idt_qty'=>$idt_qty,
                'idt_return_qty'=>$idt_return,
                'idt_price'=>$hpp,
                'idt_comp'=>$comp,
                'idt_position'=>$position,
                'idt_status'=>'Y',
            ]);

            $updateDt=d_itemtitipan_dt::where('idt_item',$request->idt_item[$i]);
            $updateDt->update([
                'idt_status' =>'Y'
              ]);
      }else{
        DB::rollBack();
        $data=['status'=>'gagal','data'=>'gagal'];
          return json_encode($data);
      }

    }  

          $data=['status'=>'sukses','data'=>'sukses'];
          return json_encode($data);
      });
    }

static function chekQtyReturn($item,$comp,$position){
  $chekQtyReturn=d_itemtitipan_dt::where('idt_action',DB::raw("'Ditukar Harga'"))
                    ->select(DB::raw('sum(idt_return_titip) as idt_return'))
                    ->where('idt_item',$item)
                    ->where('idt_status','N')                    
                    ->first();    
 if(count($chekQtyReturn)){
    $data=$chekQtyReturn->idt_return;
 }else{
    $data=0;
 }
  
  return json_encode($data);
}
static function serahTerimaStore($request){  
  return DB::transaction(function () use ($request) {  
    
     $lanjut=false;
     $chekTitipanBayar=d_item_titipan::where('it_supplier',$request->id_supplier);
    if($chekTitipanBayar->where('it_status','=','lunas')->count()==0){
       $lanjut=true;
    }
    else if($chekTitipanBayar->where('it_status','!=','lunas')->count()!=0 && $lanjut==false){
          $data=['status'=>'gagal','data'=>'gagal'];
          return json_encode($data);
      }
    
    

    $updateTitipan=d_item_titipan::where('it_id',$request->it_id);
    $updateTitipan->update([
                      'it_status'=>'lunas'
                    ]);
    // stock mutasi hanya untuk barang kembali.
    for ($i=0; $i <count($request->idt_item) ; $i++) { 

      $updateTitipanDt=d_itemtitipan_dt::where('idt_itemtitipan',$request->idt_itemtitipan[$i])->where('idt_detailid',$request->idt_detailid[$i])->where('idt_item',$request->idt_item[$i]);
      $comp=$request->comp[$i];
      $position=$request->position[$i];
      $idt_terjual= format::format($request->idt_terjual[$i]);  
      $sisa= format::format($request->idt_sisa[$i]);        
      $idt_return_titip= format::format($request->idt_return_titip[$i]);  
      $idt_return_lama = format::format($request->idt_return_lama[$i]);  

      $permintaan=format::format($request->idt_return_titip[$i])-format::format($request->idt_return_lama[$i]);


      if($request->idt_action[$i]!='-'){  
        if($idt_return_lama!=$idt_return_titip){          
          $simpanMutasi=mutasi::updateMutasi($request->idt_item[$i],$permintaan,$comp,$position,$flag='BARANG TITIPAN',$request->it_id,$request->idt_action[$i],date('Y-m-d'),15);
          
          if($simpanMutasi['true']){          

          }else{
              DB::rollBack();              
              $data=['status'=>'gagal'];
              return json_encode($data);
          }


        } 
      }else{
              DB::rollBack();              
              $data=['status'=>'gagal','data'=>"Ma'af, aksi pada detail belum lengkap"];
              return json_encode($data);
      }
      
      $updateTitipanDt->update([
            'idt_terjual'=>$idt_terjual,
            'idt_sisa'=>$sisa,
            'idt_return_titip'=>$idt_return_titip,
            'idt_action'=>$request->idt_action[$i],    
            'idt_status' =>'N',        
        ]);
    }
           $data=['status'=>'sukses','data'=>'sukses'];
          return json_encode($data);
    });  
  }

  static function updateTitipan($request){
    
    $it_total= format::format($request->it_total); 
    $itemTitipanUpdate=d_item_titipan::where('it_id',$request->it_id);
    $itemTitipanUpdate->update([
        'it_total'=>$it_total
      ]);
    for ($i=0; $i <count($request->idt_item) ; $i++) { 
  $qty= format::format($request->idt_qty[$i]); 
  



  $permintaan=format::format($request->idt_qty[$i])-format::format($request->jumlahLama[$i]);
  
  $simpanMutasi=mutasi::perbaruimutasi($request->idt_item[$i],$permintaan,$request->comp,$request->position,'','',$request->it_id,'','','');
  if($simpanMutasi['true']){              
        $updateDt=d_itemtitipan_dt::where('idt_itemtitipan',$request->it_id)
              ->where('idt_detailid',$request->idt_detailid[$i])
               ->where('idt_item',$request->idt_item[$i]);
             
        $updateDt->update([
                    'idt_qty'=>$qty
                  ]);     

}
    }
    
$data=['status'=>'sukses','data'=>'sukses'];
          return json_encode($data);
      
  }
   
}
	