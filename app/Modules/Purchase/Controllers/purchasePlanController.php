<?php

namespace App\Modules\Purchase\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;
use App\m_itemm;
use App\Http\Controllers\Controller;
use App\mMember;
use App\Modules\Purchase\model\d_purchase_plan;
use App\Modules\Purchase\model\d_purchaseplan_dt;
use Datatables;
use Session;
use Response;
use Auth;


class purchasePlanController extends Controller
{ 
   public function seachItemPurchase(Request $request, $gudang)
   {

      $namaGudang = DB::table('d_gudangcabang')
                    ->where('gc_id',$gudang)
                    ->select('gc_gudang')->first();
      if ($namaGudang->gc_gudang == 'GUDANG PENJUALAN') 
      {
         $term = $request->term;
         $results = array();
         $queries = DB::table('m_item')
           ->select('i_id','i_type','i_sat1','i_sat2','i_sat3','i_code','i_name')
           ->where('i_name', 'LIKE', '%'.$term.'%')
           ->where('i_type', 'BJ')
           ->take(25)->get();

         if ($queries == null) 
         {
           $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
         } 
         else 
         {
            foreach ($queries as $val) 
            {
            //ambil stok berdasarkan type barang
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gudang' AND s_position = '$gudang' limit 1) ,'0') as qtyStok"));
            $stok = $query[0]->qtyStok;

             //get prev cost
            $idItem = $val->i_id;
            $prevCost = DB::table('d_stock_mutation')
                     // ->select(DB::raw('MAX(sm_hpp) as hargaPrev'))
                  ->select('sm_hpp', 'sm_qty')
                  ->where('sm_item', '=', $idItem)
                  ->where('sm_mutcat', '=', "16")
                  ->orderBy('sm_date', 'desc')
                  ->limit(1)
                  ->first();

            if ($prevCost == null) 
            {
              $default_cost = DB::table('m_price')->select('m_pbuy1')->where('m_pitem', '=', $idItem)->first();
              $hargaLalu = $default_cost->m_pbuy1;
            }
            else
            {
               $hargaLalu = $prevCost->sm_hpp;
            }
             
             //get data txt satuan
            $txtSat1 = DB::table('m_satuan')->select('s_name', 's_id')->where('s_id','=', $val->i_sat1)->first();
            $txtSat2 = DB::table('m_satuan')->select('s_name', 's_id')->where('s_id','=', $val->i_sat2)->first();
            $txtSat3 = DB::table('m_satuan')->select('s_name', 's_id')->where('s_id','=', $val->i_sat3)->first();

             $results[] = [ 'id' => $val->i_id,
                            'label' => $val->i_code .' - '.$val->i_name,
                            'stok' => (int)$stok,
                            'sat' => [$val->i_sat1, $val->i_sat2, $val->i_sat3],
                            'satTxt' => [$txtSat1->s_name, $txtSat2->s_name, $txtSat3->s_name],
                            'prevCost' =>number_format((int)$hargaLalu,2,",",".")
                          ];
           }
         }

         return Response::json($results);
      }
      else
      {
         $term = $request->term;
         $results = array();
         $queries = DB::table('m_item')
           ->select('i_id','i_type','i_sat1','i_sat2','i_sat3','i_code','i_name')
           ->where('i_name', 'LIKE', '%'.$term.'%')
           ->where('i_type', 'BB')
           ->take(25)->get();
         // dd($queries);
         if ($queries == null) 
         {
           $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
         } 
         else 
         {
           foreach ($queries as $val) 
           {
            //ambil stok berdasarkan type barang
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gudang' AND s_position = '$gudang' limit 1) ,'0') as qtyStok"));
            $stok = $query[0]->qtyStok;
  
             //get prev cost
            $idItem = $val->i_id;
            $prevCost = DB::table('d_stock_mutation')
                       // ->select(DB::raw('MAX(sm_hpp) as hargaPrev'))
                       ->select('sm_hpp', 'sm_qty')
                       ->where('sm_item', '=', $idItem)
                       ->where('sm_mutcat', '=', "16")
                       ->orderBy('sm_date', 'desc')
                       ->limit(1)
                       ->first();

            if ($prevCost == null) 
            {
               $default_cost = DB::table('m_price')->select('m_pbuy1')->where('m_pitem', '=', $idItem)->first();
               $hargaLalu = $default_cost->m_pbuy1;
            }
            else
            {
               $hargaLalu = $prevCost->sm_hpp;
            }

             //get data txt satuan
            $txtSat1 = DB::table('m_satuan')->select('s_name', 's_id')->where('s_id','=', $val->i_sat1)->first();
            $txtSat2 = DB::table('m_satuan')->select('s_name', 's_id')->where('s_id','=', $val->i_sat2)->first();
            $txtSat3 = DB::table('m_satuan')->select('s_name', 's_id')->where('s_id','=', $val->i_sat3)->first();
            $results[] = [ 'id' => $val->i_id,
                           'label' => $val->i_code .' - '.$val->i_name,
                           'stok' => (int)$stok,
                           'sat' => [$val->i_sat1, $val->i_sat2, $val->i_sat3],
                           'satTxt' => [$txtSat1->s_name, $txtSat2->s_name, $txtSat3->s_name],
                           'prevCost' =>number_format((int)$hargaLalu,2,",",".")
                          ];
           }
         }
         
         return Response::json($results);
      }
      
   }

   public function storePlan(Request $request)
   {
   // dd($request->all());
   DB::beginTransaction();
   try {
      //kode plan
      $query = DB::select(DB::raw("SELECT MAX(RIGHT(p_code,4)) as kode_max from d_purchase_plan WHERE DATE_FORMAT(p_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));

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
      //id plan
      $p_id=d_purchase_plan::max('p_id')+1;
      $p_code = "PO-".date('ym')."-".$kd;
      d_purchase_plan::create([
              'p_id' => $p_id,
              'p_comp' => Session::get('user_comp'),
              'p_mem' => Auth::user()->m_id, 
              'p_code' => $p_code,
              'p_supplier' => $request->id_supplier,
              'p_status' => 'WT',
              'p_created' => Carbon::now()
              
                                   
        ]);
        // dd($request->all());
        for ($i=0; $i <count($request->ppdt_item); $i++) 
        {  
            $detailid=d_purchaseplan_dt::where('ppdt_pruchaseplan',$p_id)->max('ppdt_detailid')+1;
            d_purchaseplan_dt::create([
               'ppdt_pruchaseplan' => $p_id,
               'ppdt_detailid' => $detailid,
               'ppdt_item' => $request->ppdt_item[$i],
               'ppdt_qty' => str_replace('.', '', $request->ppdt_qty[$i]),
               'ppdt_satuan' => $request->ppdt_satuan[$i],
               'ppdt_prevcost' => str_replace('.', '', $request->ppdt_prevcost[$i]),
               'ppdt_isconfirm' => 'FALSE'
            ]);
         }

      DB::commit();
      return response()->json([
          'status' => 'sukses',
          'nota' => $p_code,
      ]);
    } catch (\Exception $e) {
    DB::rollback();
    return response()->json([
        'status' => 'gagal',
        'data' => $e
      ]);
    }
   }

   public function planIndex()
   {     
     $daftar =view('Purchase::rencanapembelian/daftar');   
     $history =view('Purchase::rencanapembelian/history');   
     $modalDetail =view('Purchase::rencanapembelian/modal-detail');   
     $modalEdit =view('Purchase::rencanapembelian/modal-edit');   
     
     return view('Purchase::rencanapembelian.rencana',compact('daftar','history','modalDetail','modalEdit'));
   }

   public function dataPlan(Request $request)
   {
      $tanggal1 = date('Y-m-d',strtotime($request->tanggal1))." 00:00:00";
      $tanggal2 = date('Y-m-d',strtotime($request->tanggal2))." 23:59:59";
      $data = d_purchase_plan::select('p_created',
                                       'p_code',
                                       'm_name',
                                       's_name',
                                       'p_status',
                                       'p_status_date'
                                    )
               ->join('m_supplier','d_purchase_plan.p_supplier','=','m_supplier.s_id')
               ->join('d_mem','d_purchase_plan.p_mem','=','d_mem.m_id')
               ->whereBetween('p_created', [$tanggal1, $tanggal2])
               ->where('p_comp','=',Session::get('user_comp'))
               ->orderBy('p_created', 'DESC')
               ->get();
              // dd($data);
      // return $data;
      return DataTables::of($data)
      ->addIndexColumn()

      ->editColumn('status', function ($data)
      {
         if ($data->p_status == "WT") 
         {  
            return '<span class="label label-info">Waiting</span>';
         }
         elseif ($data->p_status == "DE") 
         {
            return '<span class="label label-warning">Dapat diedit</span>';
         }
         elseif ($data->p_status == "FN") 
         {
            return '<span class="label label-success">Disetujui</span>';
         }
      })
     
      ->editColumn('tglBuat', function ($data) 
      {
         return date('d M Y', strtotime($data->p_created)) . ', ' . date('H:i:s', strtotime($data->p_created));
      })
      ->addColumn('tglConfirm', function ($data) 
      {
         if ($data->p_status_date == null) 
         {
             return '-';
         }
         else 
         {
             return $data->p_status_date ? with(new Carbon($data->p_status_date))->format('d M Y') : '';
         }
      })

     ->addColumn('aksi', function($data)
      {
         if ($data->p_status == "WT" || $data->p_status == "DE") 
         {
            return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailPlanAll("'.$data->p_id.'")><i class="fa fa-eye"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editPlanAll("'.$data->p_id.'")><i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Hapus"
                          onclick=deletePlan("'.$data->p_id.'")><i class="fa fa-times"></i>
                      </button>
                  </div>'; 
         }
         elseif ($data->p_status == "FN") 
         {
            return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailPlanAll("'.$data->p_id.'")><i class="fa fa-eye"></i> 
                      </button>
                  </div>'; 
         }
      })
      ->rawColumns([ 'tglBuat',
                     'status', 
                     'aksi',
                     'tglConfirm'])
      ->make(true);
   }

   public function getDetailPlan($id){     
      return d_purchase_plan::getDetailPlan($id);
   }
   public function getEditPlan($id){     
      return d_purchase_plan::getEditPlan($id);
   }
   public function deletePlan($id){     
      return d_purchase_plan::deletePlan($id);
   }
   public function updatePlan(Request $request){         
      return d_purchase_plan::perbaruiPlan($request);
   }
   


   
   public function formPlan()
    {        
         return view('Purchase::rencanapembelian/create');
    }

    public function create()
    {
        return view('Purchase::rencanapembelian/create');
    }
    public function tambah_pembelian()
    {
        return view('/purchasing/returnpembelian/tambah_pembelian');
    }
    public function tambah_order()
    {
        
    }
    public function bahan()
    {
        return view('/purchasing/rencanabahanbaku/bahan');
    }
}
 /*<button class="btn btn-outlined btn-info btn-sm" type="button" data-target="#detail" data-toggle="modal">Detail</button>*/