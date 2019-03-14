<?php

namespace App\Modules\POS\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;
use App\m_itemm;
use App\m_supplier;
use App\Http\Controllers\Controller;
use App\mMember;
use App\Modules\POS\model\m_paymentmethod;
use App\Modules\POS\model\d_item_titip;
use App\Modules\POS\model\d_itemtitip_dt;
use Datatables;
use Auth;
use App\m_consigne;
use Session;
use App\Lib\format;
use App\Lib\mutasi;

class itemTitipController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function item(Request $item)
    { 
      return m_itemm::seachItem($item);
    }
    public function searchItemCode(Request $item)
    { 
      
      return m_itemm::searchItemCode($item);
    }    
    public function index()
    { 
      $paymentmethod=m_paymentmethod::pm();       
      $pm =view('POS::paymentmethod/paymentmethod',compact('paymentmethod')); 
      $consigne = m_consigne::select('c_id',
                                       'c_code',
                                       'c_company')
                     ->where('c_isactive','Y')
                     ->get(); 
      $data['form']=view('POS::barangTitip/form', compact('consigne'));      
      $data['list']=view('POS::barangTitip/list', compact('consigne'));  
      $data['modal']=view('POS::barangTitip/modal', compact('consigne'));     
      return view('POS::barangTitip/index',compact('data','pm','consigne'));
    }

    function data(Request $request){
      /*if($request->ajax()){*/
        return d_item_titip::itemTitip($request);
     /* }else{
        return 'f';
      }     */ 
    }


   function store(Request $request)
   {
      return DB::transaction(function () use ($request) 
      {        
         $it_id=d_item_titip::max('it_id')+1;
         $query = DB::select(DB::raw("SELECT MAX(RIGHT(it_code,4)) as kode_max from d_item_titip WHERE DATE_FORMAT(it_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
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
      
         $it_code = "TTN-".date('ym')."-".$kd;

         $cabang=Session::get('user_comp');
         $tujuan=DB::table('d_gudangcabang')
            ->where('gc_gudang','GUDANG TITIP')
            ->where('gc_comp',$cabang)
            ->first();
      
         $it_total= format::format($request->it_total);        
         $date=date('Y-m-d',strtotime($request->it_date));
         d_item_titip::create([
               'it_id'=>$it_id,            
               'it_comp'=>$cabang,
               'it_code'=>$it_code,
               'it_consigne'=>$request->consigne,
               'it_date'=>$date,
               'it_keterangan'=>$request->it_keterangan,
               'it_total' =>$it_total,
           ]);


         $jumlah=count($request->idt_item);      
         for ($i=0; $i <$jumlah ; $i++) 
         {
            $idt_qty= format::format($request->idt_qty[$i]); 
            $hpp= format::format($request->idt_price[$i]);   
            $comp=$request->comp[$i];
            $position=$request->position[$i];
            $compTujuan=$tujuan->gc_id;
            $positionTujuan=$request->position[$i];
            $detailTujuan='TAMBAH BARANG TITIP';
            $simpanMutasi=mutasi::simpanTranferMutasi($request->idt_item[$i],$idt_qty,$comp,$position,$flag='TAMBAH BARANG TITIP',$it_code,$ket='e',$date,$compTujuan,$positionTujuan,1,$detailTujuan);
            if($simpanMutasi['true']){
               $idt_detailid=d_itemTitip_dt::where('idt_itemTitip',$it_id)
                                  ->max('idt_detailid')+1;                                           
               d_itemTitip_dt::create([
                   'idt_itemtitip'=>$it_id,
                   'idt_detailid'=>$idt_detailid,
                   'idt_date'    => date('Y-m-d',strtotime($request->it_date)),
                   'idt_comp'=>$comp,
                   'idt_position'=>$position,
                   'idt_item'=>$request->idt_item[$i],
                   'idt_qty'=>$idt_qty,
                   'idt_price'=>$hpp    
               ]);
            }
         }  

         $data=['status'=>'sukses','data'=>'sukses'];
         return json_encode($data);
      });     
      
   }

    function edit($id){
      return d_item_titipan::edit($request);
    }

    function update(Request $request){
          return d_item_titipan::update($request);
    }

   function serahTerima($id){ 
      $master = d_item_titip::where('it_comp',Session::get('user_comp'))
               ->join('m_consigne','m_consigne.c_id','=','it_con')
               ->where('it_id',$id)->first();   
      $data = d_itemtitip_dt::select('i_id',
                                    'i_code',
                                    'idt_itemtitip',
                                    'idt_detailid',
                                    'idt_date',
                                    'idt_item',
                                    'idt_qty',
                                    'idt_price',
                                    'idt_position',
                                    'idt_comp',
                                    'i_name',
                                    'm_satuan.s_name',
                                    's_qty',
                                    'idt_terjual',
                                    'idt_return',DB::raw(" (select sd_qty from d_sales_dt where sd_item=idt_item and idt_date=sd_date) as terjual"))
                     ->join('m_item','idt_item','=','i_id')
                      ->join('m_satuan','s_id','=','i_sat1')                      
                      ->leftjoin('d_stock',function($join){
                        $join->on('s_item','=','i_id');
                        $join->on('s_comp','=','idt_comp');
                        $join->on('s_position','=','idt_position');

                     })
                      ->where('idt_itemtitip',$id)
                      ->get();                     
                      
      return view('POS::barangTitip/detailSerahTerima',compact('data','master'));      
   }

function searchItemTitipan(Request $request){
      return m_itemm::searchItemTitipan($request);
}

    function searchItemTitip(Request $request){
      return d_item_titip::searchItemTitip($request);
    }

  function titipDt($id){
        $data=d_itemtitip_dt::itemTitipDt($id);
        
        return view('POS::barangTitip/modal',compact('data'));                  
  }
}
