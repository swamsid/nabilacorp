<?php
  
namespace App\Modules\Produksi\Controllers;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use App\d_productresult;
use App\d_productresultdt;
use App\d_spk;
use App\m_itemm;
use App\d_productplan;
use App\d_sales_dt;
use App\Modules\POS\model\d_sales;
use DataTables;
use Auth;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;

class MonitoringProgressController extends Controller
{

  public function monitoring(){
    
    if (Auth::user()->punyaAkses('Monitoring Order & Stock','ma_read')) {      
      $autoPlan = view('Produksi::monitoringprogress.auto_plan');  
      return view('Produksi::monitoringprogress.index',compact('autoPlan'));
    }else{
      return view('system.hakakses.errorakses');
    }
  }

  public function tabel(Request $request){

      if($request->fil=='A')
      {
         $comp=Session::get('user_comp');    
         $salesPlan=DB::table('d_sales_plan')->join('d_salesplan_dt','sp_id','=','spdt_salesplan')
                  ->where('sp_status',DB::raw("'N'"))              
                  ->select(DB::raw("sum(spdt_qty) as spdt_qty"),'spdt_item')->groupBy('spdt_item');

         $pp = DB::Table('d_productplan')
         ->where(function($query){
           $query->where('pp_isspk',DB::raw("'N'"))
                 ->orwhere('pp_isspk',DB::raw("'Y'"))
                 ->orwhere('pp_isspk',DB::raw("'P'"));
           })
         ->select(DB::raw("sum(pp_qty) as pp_qty"), 'pp_item')             
         ->groupBy('pp_item');

         $sales = DB::Table('d_sales')
         ->where('s_channel', DB::raw("'Pesanan'"))
         ->where(function ($query) {
             $query->where('s_status',DB::raw("'final'"));
         })             
         ->leftjoin('d_sales_dt','d_sales.s_id', '=' , 'd_sales_dt.sd_sales');

         $cabang=Session::get('user_comp');            
         $position=DB::table('d_gudangcabang')
                           ->whereIn('gc_gudang',['GUDANG PENJUALAN','GUDANG PRODUKSI'])
                           ->where('gc_comp',$cabang)
                           ->select('gc_id')->get();    

         $stock = DB::Table('d_stock')
         ->select('s_item',DB::raw("sum(s_qty) as s_qty"));

         for ($i=0; $i <count($position) ; $i++) 
         { 
            $stock->orWhere(function($query) use ($position,$i){
                        $query->where('s_comp',DB::raw("'1'"))->where('s_position',DB::raw($position[$i]->gc_id));
                    }); 
         }
         $stock->groupBy('s_item');

         $mon = DB::Table('m_item')
            ->select('i_id','i_code','i_name','s_qty','pp_qty','spdt_qty',
                DB::raw("sum(sd_qty) as jumlah"), 
                DB::raw("count(sd_sales) as nota"), 
                DB::raw("max(s_date) as s_date"))
            ->leftjoin(DB::raw( sprintf( '(%s) d_stock', $stock->toSql() ) ), function ($join){
                $join->on('m_item.i_id','=','d_stock.s_item');
              })
            ->leftjoin(DB::raw( sprintf( '(%s) d_sales_plan', $salesPlan->toSql() ) ), function ($join){
                $join->on('i_id','=','spdt_item');
              })
            ->leftjoin(DB::raw( sprintf( '(%s) d_productplan', $pp->toSql() ) ), function ($join){
                $join->on('m_item.i_id','=','d_productplan.pp_item');
              })
            ->leftjoin(DB::raw( sprintf( '(%s) d_sales', $sales->toSql() ) ), function ($join){
                $join->on('i_id','=','sd_item');
              })
            ->where('i_type','BP')
            ->where('i_active','Y')
            ->groupBy('i_id')
            ->get();


         $dat = array();
         foreach ($mon as $r) 
         {
            $dat[] = (array) $r;
         }
         $i=0;
         $data = array();
         foreach ($dat as $key) 
         {      
            $data[$i]['pp_item'] = $key['i_code'];
            $data[$i]['i_name'] = $key['i_name'];
            if(($key['jumlah']+$key['spdt_qty'])==0)
            {
               $data[$i]['jumlahKw'] = 0; 
               $data[$i]['jumlah'] = 0;          
            }
            if(($key['jumlah']+$key['spdt_qty'])!=0)
            {
               $data[$i]['jumlahKw'] = number_format( $key['jumlah']+$key['spdt_qty'] ,0,',','.'); 
               $data[$i]['jumlah'] = $key['jumlah']+$key['spdt_qty'];       
            }
            $data[$i]['pp_qty'] = $key['pp_qty'] == null ? 0 : $key['pp_qty'];
            $data[$i]['pp_qtyKw'] = $key['pp_qty'] == null ? 0 :  number_format( $key['pp_qty'] ,0,',','.');
            $data[$i]['s_qty'] = $key['s_qty'] == null ? 0 : 
                                $key['s_qty'];
            $data[$i]['s_qtyKw'] = $key['s_qty'] == null ? 0 : 
                                 number_format( $key['s_qty'] ,0,',','.');

            $key['s_date'] = $key['s_date'] == null ? '1945-08-17' : $key['s_date'];
            $data[$i]['nota'] = '<span class="hide">'.$key['s_date'].'</span>
                                 <button id="nota" 
                                    class="btn btn-info btn-sm nota" 
                                    data-toggle="modal" 
                                    data-target="#nota"
                                    data-id="'.$key['i_id'].'">
                                    '.$key['nota'].
                                 '</button>';
            $data[$i]['plan'] = '<a href="#" data-toggle="modal" 
                                    data-target="#modal" 
                                    class="btn btn-info btn-sm plan" 
                                    data-id="'.$key['i_id'].'"
                                    data-name="'.$key['i_name'].'">Plan</a>';

            $data[$i]['j_butuh'] = ($data[$i]['jumlah'] - $data[$i]['s_qty']) <= 0 ? '-' : 
                                    ($data[$i]['jumlah'] - $data[$i]['s_qty']);
            $data[$i]['j_butuhKw'] = ($data[$i]['jumlah'] - $data[$i]['s_qty']) <= 0 ? '-' : 
                                    number_format($data[$i]['jumlah'] - $data[$i]['s_qty'] ,0,',','.');
            $data[$i]['j_kurang'] = $data[$i]['j_butuh'] == '-' ? '-' :  
                                   $data[$i]['j_butuh'] - $data[$i]['pp_qty'] <= 0 ? '-' : 
                                   number_format( $data[$i]['j_butuh'] - $data[$i]['pp_qty'] ,0,',','.');
           $i++;
         }
         $datax = array('data' => $data);
         echo json_encode($datax);

      }
      else if($request->fil=='O')
      {
         $comp = Session::get('user_comp');    
         $salesPlan = DB::table('d_sales_plan')
            ->join('d_salesplan_dt','sp_id','=','spdt_salesplan')
            ->where('sp_status',DB::raw("'N'"))
            // ->where('sp_comp',DB::raw("$comp"))               
            ->select(DB::raw("sum(spdt_qty) as spdt_qty"),'spdt_item')
            ->groupBy('spdt_item');

         $pp = DB::Table('d_productplan')
            ->where(function($query){
              $query->where('pp_isspk',DB::raw("'N'"))
                    ->orwhere('pp_isspk',DB::raw("'Y'"))
                    ->orwhere('pp_isspk',DB::raw("'P'"));
              })
            ->select(DB::raw("sum(pp_qty) as pp_qty"), 'pp_item')
            // ->where('pp_comp',DB::raw("$comp"))               
            ->groupBy('pp_item');

         $sales = DB::Table('d_sales')
            ->where('s_channel', DB::raw("'Pesanan'"))
            ->where(function ($query) {
                $query->where('s_status',DB::raw("'final'"));
              })
            // ->where('s_comp',DB::raw("$comp"))               
            ->leftjoin('d_sales_dt','d_sales.s_id', '=' , 'd_sales_dt.sd_sales');

         $cabang=Session::get('user_comp');            
         $position=DB::table('d_gudangcabang')
            ->whereIn('gc_gudang',['GUDANG PENJUALAN','GUDANG PRODUKSI'])
            ->where('gc_comp',$cabang)
            ->select('gc_id')
            ->get();    

         $stock = DB::Table('d_stock')
            ->select('s_item',DB::raw("sum(s_qty) as s_qty"));

         for ($i=0; $i <count($position) ; $i++) 
         { 
           $stock->orWhere(function($query) use ($position,$i){
                       $query->where('s_comp',DB::raw("'1'"))
                           ->where('s_position',DB::raw($position[$i]->gc_id));
                   }); 
         }
         $stock->groupBy('s_item');
         
         $mon = DB::Table('m_item')
            ->select('i_id','i_code','i_name','s_qty','pp_qty','spdt_qty',
               DB::raw("sum(sd_qty) as jumlah"), 
               DB::raw("count(sd_sales) as nota"), 
               DB::raw("max(s_date) as s_date"))
            ->leftjoin(DB::raw( sprintf( '(%s) d_stock', $stock->toSql() ) ), function ($join){
               $join->on('m_item.i_id','=','d_stock.s_item');
             })
            ->leftjoin(DB::raw( sprintf( '(%s) d_sales_plan', $salesPlan->toSql() ) ), function ($join){
               $join->on('i_id','=','spdt_item');
             })
            ->leftjoin(DB::raw( sprintf( '(%s) d_productplan', $pp->toSql() ) ), function ($join){
               $join->on('m_item.i_id','=','d_productplan.pp_item');
             })
            ->leftjoin(DB::raw( sprintf( '(%s) d_sales', $sales->toSql() ) ), function ($join){
               $join->on('i_id','=','sd_item');
             })
            ->where('i_type','BP')
            ->where('i_active','Y')
            ->groupBy('i_id')
            ->get();

        //return $mon;
         $dat = array();
         foreach ($mon as $r) 
         {
            $dat[] = (array) $r;
         }
         $i=0;
         $data = array();
       foreach ($dat as $key) 
       {      
         if(($key['jumlah']+$key['spdt_qty'])!=0)
         {
            $data[$i]['pp_item'] = $key['i_code'];
            $data[$i]['i_name'] = $key['i_name'];

            if(($key['jumlah']+$key['spdt_qty'])==0)
            {
               $data[$i]['jumlahKw'] = 0;
               $data[$i]['jumlah'] = 0;          
            }
            if(($key['jumlah']+$key['spdt_qty'])!=0)
            {
               $data[$i]['jumlahKw'] = number_format( $key['jumlah']+$key['spdt_qty'] ,0,',','.'); 
               $data[$i]['jumlah'] = $key['jumlah']+$key['spdt_qty'];          
            }

            $data[$i]['pp_qtyKw'] = number_format( $key['pp_qty'] == null ? 0 : $key['pp_qty'] ,0,',','.');
            $data[$i]['pp_qty'] = $key['pp_qty'] == null ? 0 : $key['pp_qty'];
            $data[$i]['s_qtyKw'] = number_format( $key['s_qty'] ,0,',','.') == null ? 0 : 
                                 number_format( $key['s_qty'] ,0,',','.');
            $data[$i]['s_qty'] = $key['s_qty'] == null ? 0 : 
                                 $key['s_qty'];
            $key['s_date'] = $key['s_date'] == null ? '1945-08-17' : $key['s_date'];
            $data[$i]['nota'] = '<span class="hide">'.$key['s_date'].'</span>
                                 <button id="nota" 
                                    class="btn btn-info btn-sm nota" 
                                    data-toggle="modal" 
                                    data-target="#nota"
                                    data-id="'.$key['i_id'].'">
                                    '.$key['nota'].
                                 '</button>';
            $data[$i]['plan'] = '<a href="#" data-toggle="modal" data-target="#modal" 
                                    class="btn btn-info btn-sm plan" 
                                    data-id="'.$key['i_id'].'"
                                    data-name="'.$key['i_name'].'">Plan</a>';

            $data[$i]['j_butuh'] = ($data[$i]['jumlah'] - $data[$i]['s_qty']) <= 0 ? '-' : 
                                 ($data[$i]['jumlah'] - $data[$i]['s_qty']);
            $data[$i]['j_butuhKw'] = ($data[$i]['jumlah'] - $data[$i]['s_qty']) <= 0 ? '-' : 
                                     number_format( $data[$i]['jumlah'] - $data[$i]['s_qty'] ,0,',','.');

            $data[$i]['j_kurang'] = $data[$i]['j_butuh'] == '-' ? '-' :  
                                    $data[$i]['j_butuh'] - $data[$i]['pp_qty'] <= 0 ? '-' : 
                                    number_format( $data[$i]['j_butuh'] - $data[$i]['pp_qty'] ,0,',','.');
           $i++;
         }
       }
       $datax = array('data' => $data);
       echo json_encode($datax);   
    }
  }

  public function bukaNota($id){
    $pesanan = d_sales::select('s_note','s_finishdate','s_date','sd_qty')
      ->join('d_sales_dt','d_sales_dt.sd_sales','=','s_id')
      ->join('m_item','m_item.i_id','=','sd_item')
      ->where('i_id',$id)
      ->get();
 
    return view('Produksi::monitoringprogress.nota',compact('pesanan'));
  }

  public function plan($id){

    $plan = d_productplan::
          where('pp_item',$id)
        ->where(function ($query) {
              $query->where('pp_isspk','Y')
                    ->orWhere('pp_isspk','N')
                    ->orWhere('pp_isspk','P');
                  })
        ->orderBy('pp_date','asc')
        ->get();

    $spkY = DB::Table('d_productplan')
        ->select(DB::raw("sum(pp_qty) as pp_qty"))
        ->where('pp_item',$id)
        ->where('pp_isspk','Y')
        ->groupBy('pp_isspk')
        ->get();

    $spkN = DB::Table('d_productplan')
        ->select(DB::raw("sum(pp_qty) as pp_qty"))
        ->where('pp_item',$id)
        ->where('pp_isspk','N')
        ->groupBy('pp_isspk')
        ->get();

    $spkP = DB::Table('d_productplan')
        ->select(DB::raw("sum(pp_qty) as pp_qty"))
        ->where('pp_item',$id)
        ->where('pp_isspk','P')
        ->groupBy('pp_isspk')
        ->get();
 
    $spk = array();
    if(count($spkY) > 0){
      $spk['Y'] = $spkY[0]->pp_qty;
    }else{
      $spk['Y'] = 0;
    }

    if(count($spkN) > 0){
      $spk['N'] = $spkN[0]->pp_qty;
    }else{
      $spk['N'] = 0;
    }

    if(count($spkP) > 0){
      $spk['P'] = $spkP[0]->pp_qty;
    }else{
      $spk['P'] = 0;
    }

    return view('Produksi::monitoringprogress.plan', compact('plan','spk','id'));  
  }

  public function save(Request $request){
  DB::beginTransaction();
  try {
    $del = DB::Table('d_productplan')
      ->where('pp_item',$request->pp_item)
      ->where('pp_isspk','N')
      ->delete();

      $maxid = DB::Table('d_productplan')->select('pp_id')->max('pp_id');
      if ($maxid <= 0 || $maxid == '') {
        $maxid  = 1;
      }else{
        $maxid += 1;
      }
      $pp = array();
      for ($i=0; $i < $request->rowPlan; $i++) {
        if ($request->{'pp_qty'.$i} == null) {
          return response()->json([
            'status' => 'gagal',
            'data' => $e
          ]);
        }else{
          $pp[$i] = DB::Table('d_productplan')
            ->insert([
              'pp_id' => $maxid,
              'pp_comp' => $request->mem_comp,
              'pp_item' => $request->pp_item,
              'pp_date' => Carbon::parse($request->{'tanggal'.$i})->format('Y-m-d'),
              'pp_qty' => $request->{'pp_qty'.$i},
            ]);    

          $maxid++;
        }
      }
    DB::commit();
    return response()->json([
        'status' => 'sukses'
    ]);
    } catch (\Exception $e) {
    DB::rollback();
    return response()->json([
        'status' => 'gagal',
        'data' => $e
    ]);
    }
  }

  public function autoPlan(){
    // $comp=Session::get('user_comp');    
    $salesPlan=DB::table('d_sales_plan')->join('d_salesplan_dt','sp_id','=','spdt_salesplan')
               ->where('sp_status',DB::raw("'N'"))
               // ->where('sp_comp',DB::raw("$comp"))               
               ->select(DB::raw("sum(spdt_qty) as spdt_qty"),'spdt_item')->groupBy('spdt_item');

    $pp = DB::Table('d_productplan')
      ->where(function($query){
        $query->where('pp_isspk',DB::raw("'N'"))
              ->orwhere('pp_isspk',DB::raw("'Y'"))
              ->orwhere('pp_isspk',DB::raw("'P'"));
        })
      ->select(DB::raw("sum(pp_qty) as pp_qty"), 'pp_item')
      // ->where('pp_comp',DB::raw("$comp"))               
      ->groupBy('pp_item');

    $sales = DB::Table('d_sales')
      ->where('s_channel', DB::raw("'Pesanan'"))
      ->where(function ($query) {
          $query->where('s_status',DB::raw("'final'"));
        })
      // ->where('s_comp',DB::raw("$comp"))               
      ->leftjoin('d_sales_dt','d_sales.s_id', '=' , 'd_sales_dt.sd_sales');
    /*dd($sales->toSql());*/

    $cabang=Session::get('user_comp');            
    $position=DB::table('d_gudangcabang')
      ->whereIn('gc_gudang',['GUDANG PENJUALAN','GUDANG PRODUKSI'])
      ->where('gc_comp',$cabang)
      ->select('gc_id')->get();    

    $stock = DB::Table('d_stock')
      ->select('s_item',DB::raw("sum(s_qty) as s_qty"));
      /*->where(function($query){
          $query->where('s_comp',DB::raw("'2'"))->where('s_position',DB::raw("'2'"));
        })
      ->orWhere(function($query){
          $query->where('s_comp',DB::raw("'6'"))->where('s_position',DB::raw("'6'"));
        })
      ->orWhere(function($query){
          $query->where('s_comp',DB::raw("'2'"))->where('s_position',DB::raw("'5'"));
        });*/

      for ($i=0; $i <count($position) ; $i++) { 
        $stock->orWhere(function($query) use ($position,$i){
                    $query->where('s_comp',DB::raw("'1'"))->where('s_position',DB::raw($position[$i]->gc_id));
                }); 
      }
      $stock->groupBy('s_item');
      
     $mon = DB::Table('m_item')
        ->select('i_id','i_code','i_name','s_qty','pp_qty','spdt_qty',
            DB::raw("sum(sd_qty) as jumlah"), 
            DB::raw("count(sd_sales) as nota"), 
            DB::raw("max(s_date) as s_date"))
        ->leftjoin(DB::raw( sprintf( '(%s) d_stock', $stock->toSql() ) ), function ($join){
            $join->on('m_item.i_id','=','d_stock.s_item');
          })
        ->leftjoin(DB::raw( sprintf( '(%s) d_sales_plan', $salesPlan->toSql() ) ), function ($join){
            $join->on('i_id','=','spdt_item');
          })
        ->leftjoin(DB::raw( sprintf( '(%s) d_productplan', $pp->toSql() ) ), function ($join){
            $join->on('m_item.i_id','=','d_productplan.pp_item');
          })
        ->leftjoin(DB::raw( sprintf( '(%s) d_sales', $sales->toSql() ) ), function ($join){
            $join->on('i_id','=','sd_item');
          })
        ->where('i_type','BP')
        ->where('i_active','Y')
        ->groupBy('i_id')
        ->get();

     //return $mon;
    $dat = array();
    foreach ($mon as $r) {
      $dat[] = (array) $r;
    }
    $i=0;
    $data = array();
    foreach ($dat as $key) {      
      if(($key['jumlah']+$key['spdt_qty'])!=0){
        $data[$i]['pp_item'] = $key['i_code'];
        $data[$i]['i_name'] = $key['i_code'] .' - '. $key['i_name'];
        
        if(($key['jumlah']+$key['spdt_qty'])==0){
          $data[$i]['jumlah'] =0;          
        }
        if(($key['jumlah']+$key['spdt_qty'])!=0){
          $data[$i]['jumlah'] =$key['jumlah']+$key['spdt_qty'];          
        }
        


        $data[$i]['pp_qty'] = $key['pp_qty'] == null ? 0 : $key['pp_qty'];
        $data[$i]['s_qty'] = $key['s_qty'] == null ? 0 : $key['s_qty'];
        /*$data[$i]['jumlah'] = $key['jumlah'] == null ? 0 : $key['jumlah'];*/
        $key['s_date'] = $key['s_date'] == null ? '1945-08-17' : $key['s_date'];
        $data[$i]['nota'] = '<span class="hide">'.$key['s_date'].'</span><button id="nota" class="btn btn-info btn-sm nota" 
                                                          data-toggle="modal" 
                                                          data-target="#nota"
                                                          data-id="'.$key['i_id'].'">
                                                          '.$key['nota'].'</button>';
        $data[$i]['plan'] = '<a href="#" data-toggle="modal" data-target="#modal" 
                                                class="btn btn-info btn-sm plan" 
                                                data-id="'.$key['i_id'].'"
                                                data-name="'.$key['i_name'].'">Plan</a>';

        $data[$i]['j_butuh'] = ($data[$i]['jumlah'] - $data[$i]['s_qty']) <= 0 ? '-' : ($data[$i]['jumlah'] - $data[$i]['s_qty']);
        $jKurang = $data[$i]['j_butuh'] == '-' ? '-' :  $data[$i]['j_butuh'] - $data[$i]['pp_qty'] <= 0 ? '-' : $data[$i]['j_butuh'] - $data[$i]['pp_qty'];
        if ($jKurang == '-') {
          $jKurang = 0;
        }
        $data[$i]['j_kurang'] = '<input type="hidden" class="form-control input-sm text-right" name="i_id[]" value="'.$key['i_id'].'"><input type="number" class="form-control input-sm text-right" name="plan[]" value="'.$jKurang.'">';
        $i++;
      }
      
    }
    // dd($jKurang);
    $datax = array('data' => $data);
    echo json_encode($datax);
  }

  public function saveAutoPlan(Request $request){
    DB::beginTransaction();
    try {
    for ($i=0; $i < count($request->plan) ; $i++) { 
      if ($request->plan[$i] != "0") {
        $pp_id = d_productplan::select('pp_id')->max('pp_id')+1;
        d_productplan::create([
                    'pp_id' => $pp_id,
                    'pp_date' => Carbon::now(),
                    'pp_item' => $request->i_id[$i],
                    'pp_qty' => $request->plan[$i],
                    'pp_isspk' => 'N'
        ]);
    }
  }
  DB::commit();
    return response()->json([
          'status' => 'sukses'
      ]);
    } catch (\Exception $e) {
    DB::rollback();
    return response()->json([
        'status' => 'gagal',
        'data' => $e
      ]);
    }
}
}

