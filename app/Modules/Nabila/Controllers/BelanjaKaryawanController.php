<?php

namespace App\Modules\Nabila\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;

use App\m_item;
use App\d_sales_payment;
use App\Modules\POS\model\d_receivable;
use App\Modules\POS\model\d_receivable_dt;

use App\Http\Controllers\Controller;

use App\mMember;
use App\Modules\POS\model\m_paymentmethod;
use App\Modules\POS\model\d_sales;
use App\Modules\POS\model\d_sales_dt;
use App\Modules\POS\model\m_machine;
use App\Modules\Master\model\m_pegawai_man;
use Datatables;
use App\Lib\format;
use App\Lib\mutasi;
use Session;
use Auth;






class BelanjaKaryawanController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function delete($id) {
      $d_sales = d_sales::find($id);
      if($d_sales->s_status != 'draft') {
          $res = [
            'status' => 'error',
            'message' => 'Transaksi tidak dapat dihapus'
          ];
      }
      else {
        DB::beginTransaction();
        try {
          $d_sales_dt = d_sales_dt::where('sd_sales', $id);
          $d_sales_dt->delete();
          $d_sales->delete();

          $res = [
            'status' => 'sukses',
          ];
          DB::commit();
        }
        catch( \Exception $e ) {
          DB::rollback();
          $res = [
            'status' => 'error',
            'message' => 'Terjadi kesalahan. ' . $e
          ];
        }
      }

      return response()->json($res);
    }

    public function POSpenjualan()
    {
      $pilihan=view('Nabila::POSpenjualan.pilihan');
      return view('Nabila::POSpenjualan/POSpenjualan',compact('pilihan'));
    }
    //auto complete barang
    public function item(Request $item)
    {      
      return m_item::seachItem($item);
    }
    public function searchItemCode(Request $item)
    {      
      return m_item::searchItemCode($item);
    }
    
    //auto complete customer
    public function customer(Request $customer){
      return m_customer::customer($customer);     
    }

    public function posPesanan()
    { 
      /*$paymentmethod=m_paymentmethod::pm();      
      $pm=view('Nabila::paymentmethod/paymentmethod',compact('paymentmethod'));    */

      /*$data['toko']=view('Nabila::belanjakaryawan/pesanan');      
      $data['listtoko']=view('Nabila::belanjakaryawan/listpesanan');   
      return view('Nabila::belanjakaryawan/pos-pesanan',compact('data'));
*/

      $printPl=view('Produksi::sam');
      $flag='Pesanan';
      $daftarHarga=DB::table('m_price_group')->where('pg_active','=','TRUE')->get();  
      $paymentmethod=m_paymentmethod::pm();       
      $pm =view('POS::paymentmethod/paymentmethod',compact('paymentmethod'));    
      $machine=m_machine::showMachineActive();      
      $data['toko']=view('Nabila::belanjakaryawan/pesanan',compact('machine','paymentmethod','daftarHarga'));      
      $data['listtoko']=view('Nabila::belanjakaryawan/listpesanan');   
      return view('Nabila::belanjakaryawan/index',compact('data','pm','printPl'));




    }

    function create(Request $request){      
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
          $note='KARYAWAN-'.$s_id.'/'.date('Y.m.d');
          if($request->s_customer==''){
            $request->s_customer=0;
          }
          
          d_sales::create([
                    's_id' =>$s_id ,
                    's_comp'=>Session::get('user_comp'),                    
                    's_channel'=>'karyawan',
                    's_jenis_bayar'=>$request->s_jenis_bayar,
                    's_date'=>date('Y-m-d',strtotime($request->s_date)),
                    's_duedate'=>date('Y-m-d',strtotime($request->s_duedate)),
                    's_finishdate'=>date('Y-m-d',strtotime($request->s_finishdate)),
                    's_note'=>$note,
                    's_machine'=>Session::get('kasir'),
                    's_create_by'=>Auth::user()->m_id,
                    's_type_price'=>$request->s_type_price,
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
                'r_type' =>'belanja karyawan',
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
                            'sd_price_disc' =>$sd_price-$sd_disc_value-$sd_disc_percentvalue,
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

     function update(Request $request){
      
      
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
                                  'sd_price_disc' =>$sd_price-$sd_disc_value-$sd_disc_percentvalue,
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
                            'sd_price_disc' =>$sd_price-$sd_disc_value-$sd_disc_percentvalue,
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

     function serahFinal(Request $request){      
      return d_sales::serahFinal($request); 
    }


    function penjualanDtPesanan($id,Request $request){  
    
      $status=$request->s_status;      
        
      $data=d_sales_dt::penjualanDt($id);
      $tamp=[];
      foreach ($data as $key => $value) {
          $tamp[$key]=$value->i_id;
      }      
      $tamp=array_map("strval",$tamp);      
      return view('Nabila::belanjakaryawan/editDetailPenjualan',compact('data','tamp','status'));
      
    }


    function penjualanViewDtPesanan($id){            
      $data=d_sales_dt::penjualanDt($id);
      $tamp=[];
      foreach ($data as $key => $value) {
          $tamp[$key]=$value->i_id;
      }      
      $tamp=array_map("strval",$tamp);      
      return view('Nabila::belanjakaryawan/viewDetailPenjualan',compact('data','tamp'));
      
    }

    function listPenjualanPesanan(Request $request){
      if($request->ajax()){
        return view('Nabila::belanjakaryawan/tableListPesanan');
      }else{
        return 'f';
      }
        
    }
    function listPenjualanDataPesanan(Request $request){
        $from=date('Y-m-d',strtotime($request->tanggal1));
        $to=date('Y-m-d',strtotime($request->tanggal2));

               
        $d_sales = DB::table('d_sales')
                  ->join('m_machine','m_id','=','s_machine')                
                  ->leftJoin('m_pegawai_man', 's_nama_cus', '=', 'c_id')
                  ->where('s_channel','karyawan')
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
                            if ($d_sales->s_status == 'Final')
                                return '<span class="label label-default">Final</span>';
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
                          
                          </div>';
                            return $html;
                        })
                        ->rawColumns(['item','action','s_status'])
                        ->make(true);  
    }
  function printNotaPesanan($id, Request $request){
      /*$sp_nominal=[];
      for ($i=0; $i <count($request->sp_nominal) ; $i++) { 
        $sp_nominal['nominal'][$i]=$request->sp_nominal[$i];
        $sp_nominal['date'][$i]=date('d-m-Y',strtotime($request->sp_date[$i]));
      }         */   

      

      $ttlBayar=$s_gross = format::format($request->s_bayar);      
      /*$jumlah=count(($request->sd_item));      */
      $bayar=$request->s_bayar;
      $kembalian=$request->kembalian;

      $data=d_sales::printNota($id);
      $dt=d_sales_dt::where('sd_sales',$id)->select('sd_sales')->get();
      $jumlah=count($dt);
      $reff=$data['sales']->s_note;
      $piutang=DB::table('d_receivable')->join('d_receivable_dt','r_id','=','rd_receivable')->where('r_ref','=',$reff)->get();      
     return view('Nabila::belanjakaryawan/printNota',compact('data','kembalian','bayar','jumlah','piutang','ttlBayar'));
     
   
  }

   public function POSpenjualanPesanan()
    {
      return view('Nabila::belanjakaryawan/pos-pesanan');
    }

    public function find_pegawai(Request $req) {
      $keyword = $req->keyword;
      $keyword = $keyword != null ? $keyword : '';

      $m_pegawai_man = m_pegawai_man::take(10);
      if($keyword != '') {
        $m_pegawai_man = $m_pegawai_man->where('c_name', 'LIKE', "%$keyword%");
      }

      $m_pegawai_man = $m_pegawai_man->select( DB::raw('c_id AS id'), DB::raw('c_nama AS text'), 'c_ktp_alamat' )->get();
      $res = ['m_pegawai_man' => $m_pegawai_man];

      return response()->json($res);
    }
}