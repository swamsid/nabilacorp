<?php

namespace App\Modules\POS\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;
use App\m_consigner;
use App\m_itemm;
use App\m_item;
use App\m_supplier;
use App\Http\Controllers\Controller;
use App\mMember;
use App\Modules\POS\model\m_paymentmethod;
use App\Modules\POS\model\d_item_titipan;
use App\Modules\POS\model\d_itemtitipan_dt;
use Datatables;
use Response;
use Auth;
use App\d_item_consigner;
use Session;

class itemTitipanController extends Controller
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
      $consigner = m_consigner::select('c_id',
                                       'c_code',
                                       'c_company')
                     ->where('c_isactive','Y')
                     ->get();    
      $pm =view('POS::paymentmethod/paymentmethod',compact('paymentmethod'));  
      $data['form']=view('POS::barangTitipan/form',compact('consigner'));      
      $data['list']=view('POS::barangTitipan/list');  
      $data['modal']=view('POS::barangTitipan/modal');   
      

      return view('POS::barangTitipan/index',compact('data','pm','consigner'));
   }

   function chekQtyReturn($item,$comp,$position){

      return d_item_titipan::chekQtyReturn($item,$comp,$position);
   }

   function data(Request $request){
      $from=date('Y-m-d',strtotime($request->tanggal1));
      $to=date('Y-m-d',strtotime($request->tanggal2));
      $itemTitipan=d_item_titipan::
         join('m_consigner','c_id','=','it_supplier')
         ->whereBetween('it_date', [$from, $to])
         ->where('it_comp',Session::get('user_comp'))
         ->get();

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
    }

    function listData(Request $request){      
        return view('POS::barangTitipan/tableList');
    }


    function store(Request $request){      
      return d_item_titipan::store($request);
    }

    function edit($id){
      return d_item_titipan::edit($request);
    }

    function update(Request $request){      
          return d_item_titipan::updateTitipan($request);
    }
    function titipanDt($id){    
        $data=d_itemtitipan_dt::itemTitipanDt($id);
        return view('POS::barangTitipan/modal',compact('data'));                  
    }

    function editTitipanDt($id,Request $request){        
      $status=$request->s_status;      
      $data=d_itemtitipan_dt::editTitipanDt($id);      
      $tamp=[];
      foreach ($data as $key => $value) {
          $tamp[$key]=$value->i_id;
      }      
      $tamp=array_map("strval",$tamp);            
      return view('POS::barangTitipan/editDetailPenjualan',compact('data','tamp','status'));
      
    }

    function serahTerima($id){
      $master=d_item_titipan::join('m_consigner','c_id','=','it_supplier')
         ->where('it_comp',Session::get('user_comp'))
         ->where('it_id',$id)
         ->first();      
      $data=d_itemtitipan_dt::itemTitipanDt($id);      
      if($master){
        return view('POS::barangTitipan/detailSerahTerima',compact('data','master'));          
      }else{
        return 'data tidak ada';      
      }
    }
    function serahTerimaStore(Request $request){      
      return  d_item_titipan::serahTerimaStore($request);
    }

   function itemTitipan(Request $request)
   {
      $search = $request->term;
      $id_supplier =$request->id_supplier;
      $cabang=Session::get('user_comp');                
      $position=DB::table('d_gudangcabang')
                   ->where('gc_gudang',DB::raw("'GUDANG PENJUALAN'"))
                   ->where('gc_comp',$cabang)
                   ->select('gc_id')->first();   
      $comp=$position->gc_id;
      $position=$position->gc_id;
      if(!$position)
      {
         $results[] = [ 'id' => null, 'label' =>'Data Gudang Titipan Tidak Ada.'];
         return Response::json($results);
      }

      $sql=DB::table('d_item_consigner')->select('i_id',
                                       'i_name',
                                       'm_satuan.s_name as s_name',
                                       's_qty',
                                       'i_code')
         ->join('m_item','m_item.i_id','=','ic_item')
         ->leftjoin('d_stock',function($join) use ($comp,$position) {
              $join->on('s_item','=','i_id');
              $join->where('s_comp',$comp); 
              $join->where('s_position',$position); 
         })
         ->leftjoin('m_satuan','m_satuan.s_id','=','i_sat1')
         ->where('ic_con',$id_supplier);

      if($search!='' && $id_supplier!='')
      {          
      $sql->where(function ($query) use ($search,$id_supplier) {
            $query->where('i_name','like','%'.$search.'%');                  
            $query->where('i_type',DB::raw("'BTPN'"));    
            $query->orWhere('i_code','like','%'.$search.'%');
         });
      }                                  
      else
      {
      $results[] = [ 'id' => null, 'label' =>'Data belum lengkap'];
      return Response::json($results);
      }
             
      $sql=$sql->get();        

      $results = array();
                        
      if (count($sql)==0) 
      {
         $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
      } 
      else 
      {
         foreach ($sql as $data)
         {
            $results[] = ['label' => $data->i_code.' - '.$data->i_name, 
                           'i_id' => $data->i_id,
                           'satuan' =>$data->s_name,
                           'stok' =>number_format($data->s_qty,0,',','.'),
                           'i_code' =>$data->i_code,
                           'i_price' =>0,
                           'item' => $data->i_name, 
                           'position'=>$position,  
                           'comp'=>$comp];
         }
      } 
        return Response::json($results);
   }

   public function itemConsigner(Request $request)
   {
      $term = $request->term;

      $results = array();
       
      $queries = m_item::where('m_item.i_name', 'LIKE', '%'.$term.'%')
         ->where('i_type','BTPN')
         ->where('i_active','Y')
         ->orderBy('i_name')
         ->take(15)
         ->get();
       
      if ($queries == null) {
         $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
      } else {
         foreach ($queries as $query) 
         {
           $results[] = [  'id' => $query->i_id, 
                           'label' => $query->i_code .' - '.$query->i_name
                        ];
         }
      } 

      return Response::json($results);
   }

   public function tambahItem(Request $request)
   {
      DB::beginTransaction();
        try{
         $cek = d_item_consigner::where('ic_con',$request->consigner)
            ->where('ic_item',$request->i_id)
            ->first();
            // dd($cek);
         if ($cek != null) 
         {
            d_item_consigner::
               where('ic_con',$request->consigner)
               ->where('ic_item',$request->i_id)
               ->update([
                  'ic_item' => $request->i_id
               ]);
         }
         else
         {
            d_item_consigner::create([
               'ic_con' => $request->consigner,
               'ic_item' => $request->i_id
            ]);   
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

   public function tableRelasiCon($id){
      $item = d_item_consigner::select('ic_id',
                                    'ic_con',
                                    'i_code',
                                    'i_name')
         ->join('m_item','m_item.i_id','=','ic_item')
         ->where('ic_con',$id)
         ->get();
      // dd($item);
      
      return DataTables::of($item)

      ->editColumn('i_name', function ($data)
      {
         return $data->i_code .' - '. $data->i_name;
      })

      ->addColumn('action', function($data)
      {
         return '<div class="text-center">
                  <a onclick=hapusCon('.$data->ic_id.')
                    class="btn btn-danger btn-sm"
                    title="Hapus">
                    <i class="fa fa-trash-o"></i>
                  </a>
                </div>';

      })
      ->rawColumns(['ip_price','action'])
      ->make(true);

   }

   public function hapusRelasiCon(Request $request, $id)
   {
      DB::beginTransaction();
        try{
         d_item_consigner::where('ic_id',$id)
            ->delete();
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

   public function cariConsigner(Request $request) 
   {
        $supplier = $request->term;

        $sql=m_consigner::where(function ($query) use ($supplier) {
                  $query->where('c_company','like','%'.$supplier.'%'); 
                  $query->orWhere('c_code','like','%'.$supplier.'%');            
               })
               ->where('c_isactive','Y')
               ->get();        
        
        $results = array();
                        
        if (count($sql)==0) {
          $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
        } else {
          foreach ($sql as $data)
          {
            $results[] = ['label' => $data->c_code .' - '.$data->c_company, 'c_id' => $data->c_id];
          }
        } 
        return Response::json($results);

    }

}
