<?php

namespace App\Modules\POS\model;

use Illuminate\Database\Eloquent\Model;

use App\Modules\POS\model\d_sales_dt;

use App\Modules\POS\model\d_receivable;

use App\Modules\POS\model\d_item_titipan;

use App\Lib\mutasi;

use App\Lib\format;

use App\d_sales_payment;

use App\m_item;

use DB;

use Auth;

use Datatables;

use Session;

class d_sales extends Model
{  
    protected $table = 'd_sales';
    protected $primaryKey = 's_id';
    const CREATED_AT = 's_insert';
    const UPDATED_AT = 's_update';
    
      protected $fillable = ['s_id','s_comp','s_jenis_bayar','s_channel','s_machine','s_date','s_finishdate','s_duedate','s_note','s_create_by','s_customer','s_gross','s_disc_percent','s_disc_value','s_tax','s_ongkir','s_bulat','s_net','s_status','s_bayar','s_kembalian','s_jurnal','s_nama_cus','s_alamat_cus'];

      static function simpan($request){        
        return DB::transaction(function () use ($request) {      
          


          $s_gross = format::format($request->s_gross);
          $s_ongkir = format::format($request->s_ongkir);          
          $s_disc_value = format::format($request->s_disc_value);
          $s_disc_percent = format::format($request->s_disc_percent);
          $s_net= format::format($request->s_net);
          $kembalian= format::format($request->kembalian);
          $bayar= format::format($request->s_bayar);
          $s_bulat= format::format($request->s_bulat);

          $s_id=d_sales::max('s_id')+1;             
          $note='TOKO-'.$s_id.'/'.date('Y.m.d');
          if($request->s_customer==''){
            $request->s_customer=0;
          }
          $s_date=date('Y-m-d',strtotime($request->s_date));
          d_sales::create([
                    's_id' =>$s_id ,
                    's_comp'=>Session::get('user_comp'),
                    's_channel'=>'Toko',                    
                    's_date'=>$s_date,
                    's_note'=>$note,
                    's_machine'=>Session::get('kasir'),
                    's_create_by'=>Auth::user()->m_id,
                    /*'s_customer'=>$request->s_customer,*/
                    's_nama_cus'=>$request->s_nama_cus,
                    's_alamat_cus'=>$request->s_alamat_cus,
                    's_gross' =>$s_gross,
                    's_disc_percent'=>$s_disc_percent,
                    's_disc_value'=>$s_disc_value,
                    's_tax'=>0,
                    's_ongkir'=>$s_ongkir,
                    's_net'=>$s_net,
                    's_bayar'=>$bayar,
                    's_status'=>$request->status,
                    /*'s_kembalian'=>$kembalian,*/
                    's_bulat'=>$s_bulat,
            ]);

          $jumlahJurnalHpp=0;
          for ($i=0; $i <count($request->sd_item); $i++) {  
              if($request->status=='final'){
                  $sd_qty = format::format($request->sd_qty[$i]); 
                  $comp=$request->comp[$i];
                  $position=$request->position[$i];                  
                  $simpanMutasi=mutasi::mutasiStok($request->sd_item[$i],$sd_qty,$comp,$position,$flag='Penjualan Toko',$note,$ket='',$s_date);   

                  
                  if($simpanMutasi['true']){
                  $sd_detailid=d_sales_dt::
                              where('sd_sales','=',$s_id)->max('sd_detailid')+1;      

                  $sd_price = format::format($request->sd_price[$i]);

                  $sd_total = format::format($request->sd_total[$i]);

                  $sd_disc_value = format::format($request->sd_disc_value[$i]);              

                  $sd_disc_percentvalue = format::format($request->sd_disc_percentvalue[$i]);

                  $comp = $request->comp[$i];

                  $position = $request->position[$i];


                  $item_titipan_qty=d_item_titipan::join('d_itemtitipan_dt','it_id','=','idt_itemtitipan')->where('it_comp',Session::get('user_comp'))->where('it_status','!=','lunas')->where('idt_item',$request->sd_item[$i])->select('idt_terjual','idt_sisa')->first();

                  $item_titipan=d_item_titipan::join('d_itemtitipan_dt','it_id','=','idt_itemtitipan')->where('it_comp',Session::get('user_comp'))->where('it_status','!=','lunas')->where('idt_item',$request->sd_item[$i]);
                  
                  $item_titipan->update([
                                  'idt_terjual'=>$item_titipan_qty->idt_terjual+$sd_qty,
                                  'idt_sisa'=>$item_titipan_qty->idt_sisa-$sd_qty
                                  ]);

                  


                  d_sales_dt::create([
                            'sd_sales' =>$s_id ,
                            'sd_detailid'=>$sd_detailid,
                            'sd_date'    =>date('Y-m-d',strtotime($request->s_date)),                            
                            'sd_comp'=>$comp,                    
                            'sd_position'=>$position,                    
                            'sd_item'=>$request->sd_item[$i],
                            'sd_qty'=>$sd_qty,                    
                            'sd_price' =>$sd_price,
                            'sd_disc_percent'=>$request->sd_disc_percent[$i],
                            'sd_disc_value'=>$sd_disc_value,
                            'sd_disc_percentvalue'=>$sd_disc_percentvalue,
                            'sd_total'=>$sd_total-$sd_disc_value-$sd_disc_percentvalue,
                  ]);


                  
                              $jumlahJurnalHpp+=$simpanMutasi['totalHpp'];
                              

          }else{
              DB::rollBack();
               $data=['status'=>'gagal','data'=>'gagal'];
              return json_encode($data);
            }
          }else if($request->status=='draft'){
               $sd_detailid=d_sales_dt::
                              where('sd_sales','=',$s_id)->max('sd_detailid')+1;      

                  $sd_price = format::format($request->sd_price[$i]);

                  $sd_total = format::format($request->sd_total[$i]);

                  $sd_disc_value = format::format($request->sd_disc_value[$i]);              

                  $sd_disc_percentvalue = format::format($request->sd_disc_percentvalue[$i]);

                  $sd_qty = format::format($request->sd_qty[$i]);


                  $comp = $request->comp[$i];

                  $position = $request->position[$i];

                  d_sales_dt::create([
                            'sd_sales' =>$s_id ,
                            'sd_detailid'=>$sd_detailid,   
                            'sd_date'    =>date('Y-m-d',strtotime($request->s_date)), 
                            'sd_comp'=>$comp,                    
                            'sd_position'=>$position,                                                        
                            'sd_item'=>$request->sd_item[$i],
                            'sd_qty'=>$sd_qty,                    
                            'sd_price' =>$sd_price,
                            'sd_disc_percent'=>$request->sd_disc_percent[$i],
                            'sd_disc_value'=>$sd_disc_value,
                            'sd_disc_percentvalue'=>$sd_disc_percentvalue,
                            'sd_total'=>$sd_total-$sd_disc_value-$sd_disc_percentvalue,
                  ]);

          }
        }

        $jurnalSales=d_sales::where('s_id',$s_id);               
        $jurnalSales->update([
             's_jurnal'=>$jumlahJurnalHpp
        ]);
/*kembalian*/
          $totalBayar=0;
          $bayar=count($request->sp_nominal);
          for ($n=0; $n <$bayar; $n++) {  
            $jmlBayar=$bayar-1;            
            $sp_paymentid=d_sales_payment::
                          where('sp_sales','=',$s_id)->max('sp_paymentid')+1;  
            $sp_nominal = format::format($request->sp_nominal[$n]);    
            $s_kembalian = format::format($request->kembalian);
            if($jmlBayar==$n && $s_kembalian>0){              
              $sp_nominal=$sp_nominal-$s_kembalian;
            }            
            if($request->sp_date[$n]==0){
              $sp_date=date('Y-m-d');
            }else{
              $sp_date=$request->sp_date[$n];
            }
              d_sales_payment::create([
                  'sp_sales'=>$s_id,
                  'sp_paymentid'=>$sp_paymentid,
                  'sp_comp'=>Session::get('user_comp'),                    
                  'sp_method'=>$request->sp_method[$n],
                  'sp_nominal'=>$sp_nominal,
                  'sp_date'=>$sp_date,
                ]);
              $totalBayar+=$sp_nominal;

          }          
          $salesUpdate=d_sales::where('s_id',$s_id);
          $salesUpdate->update([
                  's_bayar'=>$totalBayar
            ]);
          $data=['status'=>'sukses','data'=>'sukses' ,'s_id'=>$s_id,'s_status'=>$request->status];
          return json_encode($data);
      });
    }
    static function perbarui ($request){
      
      return DB::transaction(function () use ($request) {   


        $updateSales=d_sales::where('s_id',$request->s_id);
          $permintaan=0;
          $s_date=date('Y-m-d',strtotime($request->s_date));
          $s_gross = format::format($request->s_gross);
          $s_ongkir = format::format($request->s_ongkir);          
          $s_disc_value = format::format($request->s_disc_value);
          $s_disc_percent = format::format($request->s_disc_percent);
          $s_net= format::format($request->s_net);
          $kembalian= format::format($request->kembalian);
          $bayar= format::format($request->s_bayar);
          $s_bulat= format::format($request->s_bulat);

          if($request->s_customer==''){
            $request->s_customer=0;
          }
          $status=$updateSales->first()->s_status;
          $updateSales->update([
                    /*'s_machine'=>$request->s_machine,*/
                    's_create_by'=>Auth::user()->m_id,
                    /*'s_customer'=>$request->s_customer,*/
                    's_nama_cus'=>$request->s_nama_cus,
                    's_alamat_cus'=>$request->s_alamat_cus,
                    's_gross' =>$s_gross,
                    's_disc_percent'=>$s_disc_percent,
                    's_disc_value'=>$s_disc_value,                    
                    's_ongkir'=>$s_ongkir,
                    's_net'=>$s_net,
                    's_bayar'=>$bayar,
                    /*'s_kembalian'=>$kembalian,*/
                    's_bulat'=>$s_bulat,
                    's_status'=>'final',
                    ]);
          $hapusdt=[];
          if($request->hapusdt!=null){
            $hapusdt = explode(',',$request->hapusdt);
          }

            
        for ($h=0; $h <count($hapusdt) ; $h++) { 
                $hapusItem=$hapusdt[$h];
                $hapus_sales_dt=d_sales_dt::where('sd_sales',$request->s_id)                                  
                                  ->where('sd_item',$hapusItem);  
                if(count($hapus_sales_dt->first())!=0){
                  $permintaan=$hapus_sales_dt->first()->sd_qty;
                  
                  if($permintaan>0){
                      if($status=='final'){
                        $comp = $request->comp[$i];
                        $position = $request->position[$i];
                        $simpanMutasi=mutasi::updateMutasi($hapusItem,-$permintaan,$comp,$position,$flag='',$request->s_id);
                          if($simpanMutasi['true']){
                            $hapus_sales_dt->delete();
                          }
                        }else if($status='draft'){
                          $hapus_sales_dt->delete();
                        }
                      }
                    }
                }

        
        
       for ($i=0; $i <count($request->sd_item); $i++) {  
        //update

              if($request->sd_sales[$i]!=='' && $request->sd_detailid[$i]!=='' &&
                $request->sd_sales[$i]!==null && $request->sd_detailid[$i]!==null){  
                if($status=='final'){
                  
                  $permintaan=format::format($request->sd_qty[$i])-format::format($request->jumlahAwal[$i]);                  
                }else{
                  
                  $permintaan=format::format($request->sd_qty[$i]);
                }
                $comp = $request->comp[$i];
                $position = $request->position[$i];
                $simpanMutasi=mutasi::updateMutasi($request->sd_item[$i],$permintaan,$comp,$position,$flag='',$request->sd_sales[$i]);
                if($simpanMutasi['true']){                

                $upadte_sales_dt=d_sales_dt::where('sd_sales',$request->sd_sales[$i])
                                  ->where('sd_detailid',$request->sd_detailid[$i])
                                  ->where('sd_item',$request->sd_item[$i]);
              $sd_price = format::format($request->sd_price[$i]);

              $sd_total = format::format($request->sd_total[$i]);

              $sd_disc_value = format::format($request->sd_disc_value[$i]);              

              $sd_disc_percentvalue = format::format($request->sd_disc_percentvalue[$i]);

              $sd_qty = format::format($request->sd_qty[$i]);

                $upadte_sales_dt->update([
                                  'sd_qty'=>$sd_qty,
                                  'sd_price' =>$sd_price,
                                  'sd_disc_percent'=>$request->sd_disc_percent[$i],
                                  'sd_disc_value'=>$sd_disc_value,
                                  'sd_disc_percentvalue'=>$sd_disc_percentvalue,
                                  'sd_total'=>$sd_total-$sd_disc_value-$sd_disc_percentvalue,

                                  ]);

              }else{
                   $data=['status'=>'gagal','data'=>'gagal'];
                   DB::rollBack();
                  return json_encode($data);
                }    
         }else{
          
                $sd_qty=format::format($request->sd_qty[$i]);
              
                $s_id=$updateSales->first()->s_id;                
                  $comp = $request->comp[$i];
                  $position = $request->position[$i];
                  $simpanMutasi=mutasi::mutasiStok($request->sd_item[$i],$sd_qty,$comp,$position,$flag='',$s_id,$ket='',$s_date);
                  if($simpanMutasi['true']){                  
                  $sd_detailid=d_sales_dt::
                              where('sd_sales','=',$s_id)->max('sd_detailid')+1;      

                  $comp=$request->comp[$i];

                  $position=$request->position[$i];

                  $sd_price = format::format($request->sd_price[$i]);

                  $sd_total = format::format($request->sd_total[$i]);

                  $sd_disc_value = format::format($request->sd_disc_value[$i]);              

                  $sd_disc_percentvalue = format::format($request->sd_disc_percentvalue[$i]);

                  d_sales_dt::create([
                            'sd_sales' =>$s_id ,
                            'sd_detailid'=>$sd_detailid,     
                            'sd_date'    =>date('Y-m-d',strtotime($request->s_date)),               
                            'sd_comp'=>$comp,                    
                            'sd_position'=>$position,                 
                            'sd_item'=>$request->sd_item[$i],
                            'sd_qty'=>$sd_qty,                    
                            'sd_price' =>$sd_price,
                            'sd_disc_percent'=>$request->sd_disc_percent[$i],
                            'sd_disc_value'=>$sd_disc_value,
                            'sd_disc_percentvalue'=>$sd_disc_percentvalue,
                            'sd_total'=>$sd_total-$sd_disc_value-$sd_disc_percentvalue,
                  ]);
                }

            else{
               $data=['status'=>'gagal','data'=>'gagal'];
               DB::rollBack();
              return json_encode($data);
            }          
        



         }
      }
        
      $deletePayment=d_sales_payment::
                     where('sp_sales','=', $updateSales->first()->s_id)->delete();


      $bayar=count($request->sp_nominal);
      $totalBayar=0;

      for ($n=0; $n <$bayar; $n++) {  
        $jmlBayar=$bayar-1;   
            $sp_paymentid=d_sales_payment::
                          where('sp_sales','=', $updateSales->first()->s_id)->max('sp_paymentid')+1;  
            $sp_nominal = format::format($request->sp_nominal[$n]);    

            $s_kembalian = format::format($request->kembalian);
            if($jmlBayar==$n){              
              $sp_nominal=$sp_nominal-$s_kembalian;              
            }            
            if($request->sp_date[$n]==0){
              $sp_date=date('Y-m-d');
            }else{
              $sp_date=$request->sp_date[$n];
            }
              d_sales_payment::create([
                  'sp_sales'=> $updateSales->first()->s_id,
                  'sp_paymentid'=>$sp_paymentid,
                  'sp_comp'=>Session::get('user_comp'),                    
                  'sp_method'=>$request->sp_method[$n],
                  'sp_nominal'=>$sp_nominal,
                  'sp_date' => $sp_date,
                ]);
              $totalBayar+=$sp_nominal;
      } 

      
          $salesUpdate=d_sales::where('s_id',$request->s_id);
          $salesUpdate->update([
                  's_bayar'=>$totalBayar
            ]);



      $s_id=$updateSales->first()->s_id;
        $data=['status'=>'sukses','data'=>'sukses' ,'s_id'=>$s_id,'s_status'=>$updateSales->first()->s_status];
        return json_encode($data);
    });
    }
    static function listPenjualanData($request){      
      $from=date('Y-m-d',strtotime($request->tanggal1));
      $to=date('Y-m-d',strtotime($request->tanggal2));

             
      $d_sales = DB::table('d_sales')
                ->join('m_machine','m_id','=','s_machine')
                ->where('s_channel',$request->type)
                 ->whereBetween('s_date', [$from, $to])->where('s_comp',Session::get('user_comp'))->get();
      
        
          return Datatables::of($d_sales)
                         ->addColumn('item', function ($d_sales) {
                            return'<button onclick=dataDetailView(
                                                '.$d_sales->s_id.',
                                                \''.$d_sales->s_note.'\',
                                                \''.$d_sales->s_machine.'\',
                                                
                                                \''.date('d-m-Y',strtotime($d_sales->s_date)).'\',
                                                \''.date('d-m-Y',strtotime($d_sales->s_duedate)).'\',
                                                \''.date('d-m-Y',strtotime($d_sales->s_finishdate)).'\',
                                                \''.number_format($d_sales->s_gross,0,',','.').'\',
                                                '.$d_sales->s_disc_percent.',
                                                '.$d_sales->s_disc_value.',
                                                \''.number_format($d_sales->s_gross-$d_sales->s_disc_percent-$d_sales->s_disc_value,0,',','.').'\',
                                                \''.number_format($d_sales->s_ongkir,0,',','.').'\',
                                                \''.number_format($d_sales->s_bulat,0,',','.').'\',
                                                \''.number_format($d_sales->s_net,0,',','.').'\',
                                                \''.number_format($d_sales->s_bayar,0,',','.').'\',
                                                \''.number_format($d_sales->s_kembalian,0,',','.').'\',
                                                \''.$d_sales->s_customer.'\',
                                                \''.$d_sales->s_nama_cus.'\',
                                                \''.$d_sales->s_status.'\',                                                
                                                '.($d_sales->s_net-$d_sales->s_bayar).',
                                                \''.$d_sales->s_jenis_bayar.'\',
                                                
                                                \''.$d_sales->s_alamat_cus.'\',
                            ) class="btn btn-outlined btn-info btn-xs" type="button"        data-target="#detail" data-toggle="modal">Detail</button>';
                        })                         
                      ->editColumn('s_status', function ($d_sales) {
                            if ($d_sales->s_status == 'draft')
                                return '<span class="label label-warning">Draft</span>';
                            if ($d_sales->s_status == 'final')
                                return '<span class="label label-success">Final</span>';
                            if ($d_sales->s_status == 'Terima')
                                return '<span class="label label-default">Terima</span>';
                        })
                      ->editColumn('s_date', function ($d_sales) {                            
                                return date('d-m-Y',strtotime($d_sales->s_date));                            
                        })
                      ->editColumn('s_gross', function ($d_sales) {                            
                                return number_format($d_sales->s_gross,0,',','.');
                        })
                      ->editColumn('s_ongkir', function ($d_sales) {                            
                                return number_format($d_sales->s_ongkir,0,',','.');
                        })
                      ->editColumn('s_net', function ($d_sales) {                            
                                return number_format($d_sales->s_net,0,',','.');
                        })
                      ->editColumn('s_disc_percent', function ($d_sales) {                            
                                return number_format($d_sales->s_disc_percent+$d_sales->s_disc_value,0,',','.');
                        })
                         ->addColumn('action', function ($d_sales) {
                            $disable='';
                            if($d_sales->s_status=='final' && $d_sales->s_channel=='Toko' ){
                              $disable='disabled';
                            }
                            if($d_sales->s_status=='final' && $d_sales->s_channel=='Pesanan' ||
                            $d_sales->s_status=='Terima' && $d_sales->s_channel=='Pesanan' ){
                              $disable='disabled';
                            }

                            $html='';  

                          $html.='<div class="text-center">
                          <button type="button" class="btn btn-xs btn-success" title="Detail" onclick="dataDetailView(
                                                '.$d_sales->s_id.',
                                                \''.$d_sales->s_note.'\',
                                                \''.$d_sales->s_machine.'\',
                                                
                                                \''.date('d-m-Y',strtotime($d_sales->s_date)).'\',
                                                \''.date('d-m-Y',strtotime($d_sales->s_duedate)).'\',
                                                \''.date('d-m-Y',strtotime($d_sales->s_finishdate)).'\',
                                                \''.number_format($d_sales->s_gross,0,',','.').'\',
                                                '.$d_sales->s_disc_percent.',
                                                '.$d_sales->s_disc_value.',
                                                \''.number_format($d_sales->s_gross-$d_sales->s_disc_percent-$d_sales->s_disc_value,0,',','.').'\',
                                                \''.number_format($d_sales->s_ongkir,0,',','.').'\',
                                                \''.number_format($d_sales->s_bulat,0,',','.').'\',
                                                \''.number_format($d_sales->s_net,0,',','.').'\',
                                                \''.number_format($d_sales->s_bayar,0,',','.').'\',
                                                \''.number_format($d_sales->s_kembalian,0,',','.').'\',
                                                \''.$d_sales->s_customer.'\',
                                                \''.$d_sales->s_nama_cus.'\',
                                                \''.$d_sales->s_status.'\',                                                
                                                '.($d_sales->s_net-$d_sales->s_bayar).',
                                                \''.$d_sales->s_jenis_bayar.'\',
                                                
                                                \''.$d_sales->s_alamat_cus.'\',
                                                )" ><i class="fa fa-eye"></i> 
                          </button>
                          <button type="button" class="btn btn-xs btn-warning" title="Edit"onclick="editPenjualan(
                                                '.$d_sales->s_id.',
                                                \''.$d_sales->s_note.'\',
                                                \''.$d_sales->s_machine.'\',
                                                
                                                \''.date('d-m-Y',strtotime($d_sales->s_date)).'\',
                                                \''.date('d-m-Y',strtotime($d_sales->s_duedate)).'\',
                                                \''.date('d-m-Y',strtotime($d_sales->s_finishdate)).'\',
                                                \''.number_format($d_sales->s_gross,0,',','.').'\',
                                                '.$d_sales->s_disc_percent.',
                                                '.$d_sales->s_disc_value.',
                                                \''.number_format($d_sales->s_gross-$d_sales->s_disc_percent-$d_sales->s_disc_value,0,',','.').'\',
                                                \''.number_format($d_sales->s_ongkir,0,',','.').'\',
                                                \''.number_format($d_sales->s_bulat,0,',','.').'\',
                                                \''.number_format($d_sales->s_net,0,',','.').'\',
                                                \''.number_format($d_sales->s_bayar,0,',','.').'\',
                                                \''.number_format($d_sales->s_kembalian,0,',','.').'\',
                                                \''.$d_sales->s_customer.'\',
                                                \''.$d_sales->s_nama_cus.'\',
                                                \''.$d_sales->s_status.'\',                                                
                                                '.($d_sales->s_net-$d_sales->s_bayar).',
                                                \''.$d_sales->s_jenis_bayar.'\',
                                                
                                                \''.$d_sales->s_alamat_cus.'\',
                                                )" '.$disable.' ><i class="fa fa-edit"></i>
                          </button>
                          <button type="button" class="btn btn-xs btn-danger" title="Hapus" onclick="deleteProduksi(
                          '.$d_sales->s_id.'
                          )" '.$disable.'><i class="fa fa-times"></i>
                          </button>
                          </div>';

                            return $html;
                        })










                        ->rawColumns(['item','action','s_status'])
                        ->make(true);            
    }
                                              

    static function printNota($s_id){
          $sales=DB::table('d_sales')->leftJoin('m_customer','s_customer','=','c_id')
                 ->where('s_id',$s_id)->first();
          $sales_dt=DB::table('d_sales_dt')
                    ->join('m_item','sd_item','=','i_id')
                    ->join('m_satuan','s_id','=','i_satuan')
                    ->where('sd_sales',$s_id)
                    ->get();
          $data['sales']=$sales;
          $data['sales_dt']=$sales_dt;
          return $data;

    }







      static function simpanPesanan($request){        
        return DB::transaction(function () use ($request) {   
          if($request->s_nama_cus==""){
            $data=['status'=>'gagal','data'=>'Nama pelanggan harus di isi'];
            return $data;
          }
          if($request->s_alamat_cus==""){
            $data=['status'=>'gagal','data'=>'Alamat pelanggan harus di isi'];
            return $data;
          }

      $query = DB::select(DB::raw("SELECT MAX(RIGHT(r_code,4)) as kode_max from d_receivable WHERE DATE_FORMAT(r_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
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

$r_code = "DPR-".date('ym')."-".$kd;

          $s_gross = format::format($request->s_gross);
          $s_ongkir = format::format($request->s_ongkir);          
          $s_disc_value = format::format($request->s_disc_value);
          $s_disc_percent = format::format($request->s_disc_percent);
          $s_net= format::format($request->s_net);
           $kembalian= format::format($request->kembalian);
          $bayar= format::format($request->s_bayar);
          $s_bulat= format::format($request->s_bulat);

          $s_id=d_sales::max('s_id')+1;             
          $note='PESANAN-'.$s_id.'/'.date('Y.m.d');
          if($request->s_customer==''){
            $request->s_customer=0;
          }
          
          d_sales::create([
                    's_id' =>$s_id ,
                    's_comp'=>Session::get('user_comp'),                    
                    's_channel'=>'Pesanan',
                    's_jenis_bayar'=>$request->s_jenis_bayar,
                    's_date'=>date('Y-m-d',strtotime($request->s_date)),
                    's_duedate'=>date('Y-m-d',strtotime($request->s_duedate)),
                    's_finishdate'=>date('Y-m-d',strtotime($request->s_finishdate)),
                    's_note'=>$note,
                    's_machine'=>Session::get('kasir'),
                    's_create_by'=>Auth::user()->m_id,
                    /*'s_customer'=>$request->s_customer,*/
                    's_nama_cus'=>$request->s_nama_cus,
                    's_alamat_cus'=>$request->s_alamat_cus,
                    's_gross' =>$s_gross,
                    's_disc_percent'=>$s_disc_percent,
                    's_disc_value'=>$s_disc_value,
                    's_tax'=>0,
                    's_ongkir'=>$s_ongkir,
                    's_net'=>$s_net,
                    's_status'=>$request->status,
                    's_bayar'=>$bayar,
                    /*'s_kembalian'=>$kembalian,*/
                    's_bulat'=>$s_bulat
           ]);

          $r_id=d_receivable::max('r_id')+1;          
          if($s_net-$bayar<0){
            $p_outstanding=0;
            $r_pay=$s_net;            
            }else{
            $p_outstanding=$s_net-$bayar;
            $r_pay=$bayar;
          }

          
          d_receivable::create([
                'r_id'=>$r_id,
                'r_date'=>date('Y-m-d',strtotime($request->s_date)),
                'r_duedate'=>date('Y-m-d',strtotime($request->s_duedate)),
                'r_type' =>'Penjualan Pesanan',
                'r_code'=>$r_code,
                /*'r_mem',*/
                'r_customer_name'=>$request->s_nama_cus,
                'r_alamat_cus'=>$request->s_alamat_cus,
                'r_ref'=>$note,
                'r_value'=>$s_net,
                'r_pay'=>$r_pay,
                'r_outstanding'=>$p_outstanding,              

            ]);
        if($bayar!=0){
          d_receivable_dt::create([
              'rd_receivable' =>$r_id,
              'rd_detailid'   =>1,
              'rd_datepay'    =>date('Y-m-d',strtotime($request->s_date)),             
              'rd_value'      =>$r_pay,
              'rd_status'     =>'Y'
          ]);
        }

  
          for ($i=0; $i <count($request->sd_item); $i++) {  
                
               $sd_detailid=d_sales_dt::
                              where('sd_sales','=',$s_id)->max('sd_detailid')+1;      

                  $comp=$request->comp[$i];

                  $position=$request->position[$i];
                  

                  $sd_price = format::format($request->sd_price[$i]);

                  $sd_total = format::format($request->sd_total[$i]);

                  $sd_disc_value = format::format($request->sd_disc_value[$i]);              

                  $sd_disc_percentvalue = format::format($request->sd_disc_percentvalue[$i]);

                  $sd_qty= format::format($request->sd_qty[$i]);

                  d_sales_dt::create([
                            'sd_sales' =>$s_id ,
                            'sd_detailid'=>$sd_detailid,   
                            'sd_date'    =>date('Y-m-d',strtotime($request->s_date)),                             
                            'sd_comp'=>$comp,                    
                            'sd_position'=>$position,                            
                            'sd_item'=>$request->sd_item[$i],
                            'sd_qty'=>$sd_qty,                    
                            'sd_price' =>$sd_price,
                            'sd_disc_percent'=>$request->sd_disc_percent[$i],
                            'sd_disc_value'=>$sd_disc_value,
                            'sd_disc_percentvalue'=>$sd_disc_percentvalue,
                            'sd_total'=>$sd_total-$sd_disc_value-$sd_disc_percentvalue,
                  ]);

          
        }

/*dd($request->all());*/
$bayar=count($request->sp_nominal);
$totalBayar=0;
          for ($n=0; $n <$bayar; $n++) {  
            $jmlBayar=$bayar-1;   
            $sp_paymentid=d_sales_payment::
                          where('sp_sales','=',$s_id)->max('sp_paymentid')+1;  
            $sp_nominal = format::format($request->sp_nominal[$n]);    
            $s_kembalian = format::format($request->kembalian);
            if($jmlBayar==$n && $s_kembalian>0){              
              $sp_nominal=$sp_nominal-$s_kembalian;
            }        

            if($request->sp_date[$n]==0){
              $sp_date=date('Y-m-d');
            }else{
              $sp_date=$request->sp_date[$n];
            }

              d_sales_payment::create([
                  'sp_sales'=>$s_id,
                  'sp_paymentid'=>$sp_paymentid,
                  'sp_comp'=>Session::get('user_comp'),                    
                  'sp_method'=>$request->sp_method[$n],
                  'sp_nominal'=>$sp_nominal,
                  'sp_date'=>$sp_date,
                ]);

          $totalBayar+=$sp_nominal;
        } 

      
          $salesUpdate=d_sales::where('s_id',$s_id);
          $salesUpdate->update([
                  's_bayar'=>$totalBayar
            ]); 
          $data=['status'=>'sukses','data'=>'sukses' ,'s_id'=>$s_id,'s_status'=>$request->status];
          return json_encode($data);
      });
    }





     static function perbaruiPesanan ($request){
      
      return DB::transaction(function () use ($request) {           
         $updateSales=d_sales::where('s_id',$request->s_id);
         /*dd($request->all());*/
/*dd($request->all());*/
          $s_gross = format::format($request->s_gross);
          $s_ongkir = format::format($request->s_ongkir);          
          $s_disc_value = format::format($request->s_disc_value);
          $s_disc_percent = format::format($request->s_disc_percent);
          $s_net= format::format($request->s_net);
          $kembalian= format::format($request->kembalian);
          $bayar= format::format($request->s_bayar);
          $s_bulat= format::format($request->s_bulat);
          $status=$updateSales->first()->s_status;
          $updateSales->update([
                    /*'s_machine'=>$request->s_machine,*/
                    's_create_by'=>Auth::user()->m_id,
                    /*'s_customer'=>$request->s_customer,*/
                /*    's_nama_cus'=>$request->s_nama_cus,
                    's_alamat_cus'=>$request->s_alamat_cus,*/
                    's_gross' =>$s_gross,
                    's_disc_percent'=>$s_disc_percent,
                    's_disc_value'=>$s_disc_value,                    
                    's_ongkir'=>$s_ongkir,
                    's_net'=>$s_net,
                    's_bayar'=>$bayar,
                    /*'s_kembalian'=>$kembalian,*/
                    's_bulat'=>$s_bulat,
                    's_status'=>'final',
                    ]);

       for ($i=0; $i <count($request->sd_item); $i++) {  
        //update
              if($request->sd_sales[$i]!=='' && $request->sd_detailid[$i]!=='' &&
                $request->sd_sales[$i]!==null && $request->sd_detailid[$i]!==null){  
               

                $upadte_sales_dt=d_sales_dt::where('sd_sales',$request->sd_sales[$i])
                                  ->where('sd_detailid',$request->sd_detailid[$i])
                                  ->where('sd_item',$request->sd_item[$i]);
              $sd_price = format::format($request->sd_price[$i]);

              $sd_total = format::format($request->sd_total[$i]);

              $sd_disc_value = format::format($request->sd_disc_value[$i]);              

              $sd_disc_percentvalue = format::format($request->sd_disc_percentvalue[$i]);

              $sd_qty= format::format($request->sd_qty[$i]);

                $upadte_sales_dt->update([
                                  'sd_qty'=>$sd_qty,
                                  'sd_price' =>$sd_price,
                                  'sd_disc_percent'=>$request->sd_disc_percent[$i],
                                  'sd_disc_value'=>$sd_disc_value,
                                  'sd_disc_percentvalue'=>$sd_disc_percentvalue,
                                  'sd_total'=>$sd_total-$sd_disc_value-$sd_disc_percentvalue,

                                  ]);
         }else{
          

              
                $s_id=$updateSales->first()->s_id;

                $sd_detailid=d_sales_dt::
                              where('sd_sales','=',$s_id)->max('sd_detailid')+1;      

                  $comp=$request->comp[$i];
                  
                  $position=$request->position[$i];

                  $sd_price = format::format($request->sd_price[$i]);

                  $sd_total = format::format($request->sd_total[$i]);

                  $sd_disc_value = format::format($request->sd_disc_value[$i]);              

                  $sd_disc_percentvalue = format::format($request->sd_disc_percentvalue[$i]);

                  $sd_qty= format::format($request->sd_qty[$i]);

                  $comp=$request->comp[$i];

                  $position=$request->position[$i];

                  d_sales_dt::create([
                            'sd_sales' =>$s_id ,
                            'sd_detailid'=>$sd_detailid, 
                            'sd_date'    =>date('Y-m-d',strtotime($request->s_date)),                            
                            'sd_comp'=>$comp,                    
                            'sd_position'=>$position,                                       
                            'sd_item'=>$request->sd_item[$i],
                            'sd_qty'=>$sd_qty,                    
                            'sd_price' =>$sd_price,
                            'sd_disc_percent'=>$request->sd_disc_percent[$i],
                            'sd_disc_value'=>$sd_disc_value,
                            'sd_disc_percentvalue'=>$sd_disc_percentvalue,
                            'sd_total'=>$sd_total-$sd_disc_value-$sd_disc_percentvalue,
                  ]);
                   
        
         }
      }
        

      $deletePayment=d_sales_payment::
                     where('sp_sales','=', $updateSales->first()->s_id)->delete();

$bayar=count($request->sp_nominal);            
$totalBayar=0;
      for ($n=0; $n <$bayar; $n++) {  
        $jmlBayar=$bayar-1;   
            $sp_paymentid=d_sales_payment::
                          where('sp_sales','=', $updateSales->first()->s_id)->max('sp_paymentid')+1;  
            $sp_nominal = format::format($request->sp_nominal[$n]);    
            $s_kembalian = format::format($request->kembalian);
            if($jmlBayar==$n && $s_kembalian>0){              
              $sp_nominal=$sp_nominal-$s_kembalian;
            }            


            if($request->sp_date[$n]==0){
              $sp_date=date('Y-m-d');
            }else{
              $sp_date=$request->sp_date[$n];
            }
              d_sales_payment::create([
                  'sp_sales'=> $updateSales->first()->s_id,
                  'sp_paymentid'=>$sp_paymentid,
                  'sp_comp'=>Session::get('user_comp'),                    
                  'sp_method'=>$request->sp_method[$n],
                  'sp_nominal'=>$sp_nominal,
                  'sp_date' =>$sp_date
                ]);

      $totalBayar+=$sp_nominal;
      } 

      
          $salesUpdate=d_sales::where('s_id',$request->s_id);
          $salesUpdate->update([
                  's_bayar'=>$totalBayar
            ]);



      $s_id=$updateSales->first()->s_id;
        $data=['status'=>'sukses','data'=>'sukses' ,'s_id'=>$s_id,'s_status'=>$updateSales->first()->s_status];
        return json_encode($data);
    });
    }

    static function serahTerima($request){      
      return DB::transaction(function () use ($request) {   
        $jumlahJurnalHpp=0;
        $id=$request->idTerima;

        $d_sales=d_sales::where('s_id',$id)->first();
        $updateSales=d_sales::where('s_id',$id);  

        $s_date=date('Y-m-d',strtotime($d_sales->s_date));     

          
          $status=$updateSales->first()->s_status;
          $updateSales->update([                    
                    's_status'=>'Terima',
                   ]);       


       $d_sales_dt=d_sales_dt::where('sd_sales',$id)->get();


        for ($i=0; $i <count($d_sales_dt); $i++) { 
          
          $comp=$d_sales_dt[$i]->sd_comp;
          $position=$d_sales_dt[$i]->sd_position; 
          $s_note=$updateSales->first()->s_note;


        $item_titipan_qty=d_item_titipan::join('d_itemtitipan_dt','it_id','=','idt_itemtitipan')->where('it_comp',Session::get('user_comp'))->where('it_status','!=','lunas')->where('idt_item',$d_sales_dt[$i]->sd_item)->select('idt_terjual','idt_sisa')->first();
/*dd($d_sales_dt[$i]->sd_item);*/
if($item_titipan_qty){
        $item_titipan=d_item_titipan::join('d_itemtitipan_dt','it_id','=','idt_itemtitipan')->where('it_comp',Session::get('user_comp'))->where('it_status','!=','lunas')->where('idt_item',$d_sales_dt[$i]->sd_item);
                  
        $item_titipan->update([
                                  'idt_terjual'=>$item_titipan_qty->idt_terjual+$d_sales_dt[$i]->sd_qty,
                                  'idt_sisa'=>$item_titipan_qty->idt_sisa-$d_sales_dt[$i]->sd_qty
                                  ]);
}




          $simpanMutasi=mutasi::mutasiStok($d_sales_dt[$i]->sd_item,$d_sales_dt[$i]->sd_qty ,$comp,$position,$flag='',$s_note,$ket='',$s_date);          
            if($simpanMutasi['true']){     
            $jumlahJurnalHpp+=$simpanMutasi['totalHpp'];
            }else{
              $data=['status'=>'gagal','data'=>'Stok tidak mencukupi.' ,'s_id'=>$request->s_id,'s_status'=>$updateSales->first()->s_status];
              DB::rollBack();     
              return $data;      
            }
        }


        $jurnalSales=d_sales::where('s_id',$request->s_id);               
        $jurnalSales->update([
             's_jurnal'=>$jumlahJurnalHpp
        ]);

        $data=['status'=>'sukses','data'=>'Stok berhasil disimpan.' ,'s_id'=>$request->s_id,'s_status'=>$updateSales->first()->s_status];
        return $data;
      });
    }
}
	
?>