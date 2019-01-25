<?php

namespace App\Modules\Purchase\model;

use Illuminate\Database\Eloquent\Model;

use App\Lib\format;

use App\m_item;

use App\d_item_supplier;

use DB;

use Auth;

use Datatables;

use Carbon\Carbon;

use Session;


class d_purchase_plan extends Model
{  



    protected $table = 'd_purchase_plan';
    protected $primaryKey = 'p_id';
    const CREATED_AT = 'p_created';
    const UPDATED_AT = 'p_updated';
    
     protected $fillable = ['p_id','p_date','p_code','p_supplier','p_position','p_mem','p_confirm','p_status','p_status_date','p_comp','p_gudang'];

     static function simpan ($request){      
      // return DB::transaction(function () use ($request) {     
      // dd($request->all());
      // return 'a';      
      $p_id=d_purchase_plan::max('p_id')+1;
     
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
      
       // dd($request->all());
      $p_code = "PO-".date('ym')."-".$kd;

      d_purchase_plan::create([
              'p_id'=>$p_id,
              'p_comp'=>Session::get('user_comp'),
              'p_position'=>Session::get('user_comp'),
              'p_gudang'=>$request->gudang,
              'p_date'=>date('Y-m-d',strtotime($request->p_date)),
              'p_code'=>$p_code,
              'p_status'=>'WT',
              'p_supplier'=>$request->id_supplier,
              'p_mem'=>Auth::user()->m_id,                      
        ]);
        // dd($request->all());
        for ($i=0; $i <count($request->ppdt_item); $i++) {  
          // dd($request->index_satuan[$i]);
        $ppdt_prevcost= format::format($request->is_price[$i]);
        $detailid=d_purchaseplan_dt::where('ppdt_pruchaseplan',$p_id)->max('ppdt_detailid')+1;

         d_purchaseplan_dt::create([
                          'ppdt_pruchaseplan'=>$p_id,
                          'ppdt_detailid'=>$detailid,
                          'ppdt_item'=>$request->ppdt_item[$i],
                          'ppdt_qty'=>$request->ppdt_qty[$i],  
                          'ppdt_totalcost'=>$request->harga_total[$i],
                          'ppdt_prevcost'=>$ppdt_prevcost,
                          'ppdt_satuan'=>$request->satuan_pilih[$i],
                          'ppdt_isconfirm'=>'TRUE',
                          'ppdt_satuan_position'=>$request->index_satuan[$i],
                           ]);
       }

        $data=['status'=>'sukses'];
        return json_encode($data);

      }


    static function perbaruiPlan ($request){
      // dd($request->all());
      for ($i=0; $i <count($request->ppdt_detailid_old) ; $i++) { 
        $total_price_old = str_replace(['Rp', '\\', '.', ' '], '', $request->total_price_old);

        $update_data = d_purchaseplan_dt::where('ppdt_pruchaseplan','=',$request->id_purchaseplan)
                    ->where('ppdt_detailid','=',$request->ppdt_detailid_old[$i])
                    ->update([
                      'ppdt_qty'=>$request->ppdt_qty_old[$i],  
                      'ppdt_totalcost'=>$total_price_old[$i],
                    ]);
      }
      for ($i=0; $i <count($request->ppdt_detailid_remove) ; $i++) { 
        $delete_data = d_purchaseplan_dt::where('ppdt_pruchaseplan','=',$request->id_purchaseplan)
                    ->where('ppdt_detailid','=',$request->ppdt_detailid_remove[$i])
                    ->delete();
      }
      for ($i=0; $i <count($request->ppdt_detailid_new) ; $i++) { 
        $detailid=d_purchaseplan_dt::where('ppdt_pruchaseplan',$request->id_purchaseplan)->max('ppdt_detailid')+1;

        $insert_data = d_purchaseplan_dt::create([
                    'ppdt_pruchaseplan'=>$request->id_purchaseplan,
                    'ppdt_detailid'=>$detailid,
                    'ppdt_item'=>$request->ppdt_item[$i],
                    'ppdt_qty'=>$request->ppdt_qty[$i],  
                    'ppdt_totalcost'=>$request->harga_total[$i],
                    'ppdt_prevcost'=>$request->harga_awal[$i],
                    'ppdt_satuan'=>$request->satuan_pilih[$i],
                    'ppdt_isconfirm'=>'TRUE',
                    'ppdt_qtyconfirm'=>0,
                    'ppdt_satuan_position'=>$request->index_satuan[$i],
                     ]);
       }

        $data=['status'=>'sukses'];
        return json_encode($data);
      }
    
    static function dataPlan($request){   
    // return 'a';                   
      $from=date('Y-m-d',strtotime($request->tanggal1));
      $to=date('Y-m-d',strtotime($request->tanggal2));
      $d_purchase_plan = d_purchase_plan::join('m_supplier','s_id','=','p_supplier')
                          ->join('d_mem','m_id','=','p_mem')
                          ->select('p_id', 'p_code', 'p_status_date','p_date', 's_name as supplier','p_status','m_name')
                          ->where('p_comp',Session::get('user_comp'))
                          ->whereBetween('p_date', [$from, $to])->get();
             // return $d_purchase_plan;            
          
          return Datatables::of($d_purchase_plan)                       
                      ->editColumn('p_status', function ($d_purchase_plan) {

                            if ($d_purchase_plan->p_status == 'WT')                                
                                return '<span class="label label-warning">Menunggu</span>';
                            if ($d_purchase_plan->p_status == 'DE')                                
                                return '<span class="label label-success">Dapat diedit</span>';
                            if ($d_purchase_plan->p_status == 'FN')                                
                                return '<span class="label label-default">Disetujui</span>';                                                          
                        })     
                        ->editColumn('p_date', function ($d_purchase_plan) {                            
                                return date('d-m-Y',strtotime($d_purchase_plan->p_date));                            
                        })                   
                        ->editColumn('p_status_date', function ($d_purchase_plan) {         
                                if($d_purchase_plan->p_status_date!=null && $d_purchase_plan->p_status_date!='0000-00-00')                   
                                return date('d-m-Y',strtotime($d_purchase_plan->p_status_date));                           
                        })
                        ->addColumn('action', function ($d_purchase_plan) {
                          $disable='';
                          $disableDE='';

                          if($d_purchase_plan->p_status=='FN'){
                            $disable='disabled';
                            $disableDE='disabled';
                          }elseif ($d_purchase_plan->p_status == "DE") {
                            $disableDE='disabled';
                          }else{
                            $disable='';
                            $disableDE='';
                          }
                          $html='';  
                          $html.='<div class="text-center">
                          <button class="btn btn-sm btn-success" title="Detail" onclick="detailPlan(
                                                '.$d_purchase_plan->p_id.',
                                                \''.$d_purchase_plan->p_code.'\',
                                                \''.$d_purchase_plan->supplier.'\',
                                                \''.date('d-m-Y',strtotime($d_purchase_plan->p_date)).'\',
                                                \''.$d_purchase_plan->p_status.'\',
                                                \''.$d_purchase_plan->m_name.'\',
                          )"><i class="fa fa-eye"></i> 
                          </button>
                          <button class="btn btn-sm btn-warning" title="Edit" onclick="editPlan(
                                                '.$d_purchase_plan->p_id.',
                                                \''.$d_purchase_plan->p_code.'\',
                                                \''.$d_purchase_plan->supplier.'\',
                                                \''.date('d-m-Y',strtotime($d_purchase_plan->p_date)).'\',
                                                \''.$d_purchase_plan->p_status.'\',
                                                \''.$d_purchase_plan->m_name.'\',
                          )" '.$disable.' ><i class="fa fa-edit"></i>
                          </button>
                          <button class="btn btn-sm btn-danger" title="Hapus" onclick="deletePlan(
                          '.$d_purchase_plan->p_id.'
                          )" '.$disableDE.'><i class="fa fa-times"></i>
                          </button>
                          </div>';

                            return $html;
                        })
                        ->rawColumns(['action','p_status'])
                      ->make(true);                              
    }

     static function getDetailPlan($id)
    {

      $data_header = d_purchase_plan::join('d_mem','m_id','=','p_mem')
                                ->join('m_supplier','p_supplier','=','s_id')
                                ->where('p_id', '=', $id)
                                ->first();
                                
      $dataIsi = d_purchaseplan_dt::join('m_item','ppdt_item','=','i_id')
                            ->join('d_purchase_plan','p_id','=','ppdt_pruchaseplan')
                            ->leftjoin('m_satuan', 's_id', '=', 'i_satuan')
                            ->leftjoin('d_stock','s_item','=','i_id')
                            ->select('i_id',
                                     'm_item.i_code',
                                     'm_item.i_name',
                                     's_name',                                         
                                     'ppdt_qty',
                                     'ppdt_qtyconfirm',
                                     's_qty',
                                     'ppdt_pruchaseplan',
                                     'ppdt_detailid'
                            )
                            ->where('ppdt_pruchaseplan', '=', $id)
                            ->where('p_comp', '=', Session::get('user_comp'))
                            ->where('ppdt_isconfirm', '=', "TRUE")
                            ->orderBy('ppdt_created', 'DESC')
                            ->get();

      return Response()->json([
          'status' => 'sukses',          
          'data_isi' => $dataIsi,
          'data_header' => $data_header,
      ]);
    }


     static function getEditPlan($id)
    {
     
      
       $data_header = d_purchase_plan::join('d_mem','m_id','=','p_mem')
                                ->join('m_supplier','p_supplier','=','s_id')
                                ->where('p_id', '=', $id)
                                ->first();
       $dataIsi = d_purchaseplan_dt::join('m_item','ppdt_item','=','i_id')
                            ->join('m_satuan', 's_id', '=', 'i_sat1')
                            ->join('m_satuan as ms', 'ms.s_id', '=', 'ppdt_satuan')
                            ->join('d_purchase_plan','p_id','=','ppdt_pruchaseplan')
                            ->leftjoin('d_stock','s_item','=','i_id')
                            ->select('i_id',
                                     'm_item.i_sat1',
                                     'ms.s_name as satuan_pilih',
                                     'm_item.i_code',
                                     'm_item.i_name',
                                     'm_satuan.s_name as satuan_awal',                                         
                                     'ppdt_qty',
                                     'ppdt_qtyconfirm',
                                     's_qty',
                                     'ppdt_pruchaseplan',
                                     'ppdt_detailid',
                                     'ppdt_prevcost',
                                     'ppdt_totalcost'
                            )
                            ->where('ppdt_pruchaseplan', '=', $id)
                            ->where('p_comp', '=', Session::get('user_comp'))
                            ->where('ppdt_isconfirm', '=', "TRUE")
                            ->get();

        
        $tamp=[];
        foreach ($dataIsi as $key => $value) {
          $tamp[$key]=$value->i_id;
        }     
        $urut_index = count($tamp);
        $tamp=array_map("strval",$tamp); 
        
        $gudang = DB::table('d_gudangcabang')->select('gc_id','gc_gudang','c_name')->join('m_comp','m_comp.c_id','=','d_gudangcabang.gc_comp')
        ->where('gc_id',1)
        ->orWhere('gc_id',7)
        ->orWhere('gc_id',8)
        ->groupBy('gc_id')->get();

      //   return Response()->json([
      //     'data_isi' => $dataIsi,
      //     'data_header' => $data_header,
      //     'gudang' => $gudang,
      // ]);
      return view('Purchase::rencanapembelian/edit',compact('data_header','dataIsi','gudang','tamp','urut_index'));

    }

    static function deletePlan($id){
        d_purchase_plan::where('p_id',$id)->delete();
        d_purchaseplan_dt::where('ppdt_pruchaseplan',$id)->delete();
        $data=['sukses'=>'sukses'];
        return json_encode($data);
    }



    static function getDataRencanaPembelian()
  {
    $data = d_purchase_plan::join('m_supplier','p_supplier','=','s_id')
            ->leftjoin('d_mem','p_mem','=','m_id')
            ->select('p_id','p_code','p_date','s_company','p_status','p_created','p_confirm', 'm_id','m_name')
            ->orderBy('p_created', 'DESC')
            ->get();    
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
        return '<span class="label label-success">Finish</span>';
      }
    })
    ->editColumn('tglBuat', function ($data) 
    {
        if ($data->p_date == null) 
        {
            return '-';
        }
        else 
        {
            return $data->p_date ? with(new Carbon($data->p_date))->format('d M Y') : '';
        }
    })
    ->editColumn('tglConfirm', function ($data) 
    {
        if ($data->p_confirm == null) 
        {
            return '-';
        }
        else 
        {
            return $data->p_confirm ? with(new Carbon($data->p_confirm))->format('d M Y') : '';
        }
    })
    ->addColumn('action', function($data)
      {
        if ($data->p_status == "WT") 
        {
            return '<div class="text-center">
                      <button class="btn btn-sm btn-primary" title="Ubah Status"
                          onclick=konfirmasiPlanAll("'.$data->p_id.'")><i class="fa fa-check"></i>
                      </button>
                  </div>'; 
        }
        else 
        {
            return '<div class="text-center">
                      <button class="btn btn-sm btn-primary" title="Ubah Status"
                          onclick=konfirmasiPlan("'.$data->p_id.'")><i class="fa fa-check"></i>
                      </button>
                  </div>'; 
        }
      })
    ->rawColumns(['status', 'action'])
    ->make(true);
  }
    

   static function confirmRencanaPembelian($id,$type)
  {
    $gudang = d_purchase_plan::where('p_id',$id)->first();
    // return json_encode($gudang);
    $dataHeader = d_purchase_plan::join('m_supplier','p_supplier','=','s_id')
                            ->leftjoin('d_mem','p_mem','=','m_id')
                            ->select(
                                'p_id',
                                'p_code',
                                's_company',
                                'p_date', 
                                'p_status',
                                DB::raw('IFNULL(p_confirm, "") AS p_confirm'),
                                DB::raw('IFNULL(m_id, "") AS m_id'),
                                DB::raw('IFNULL(m_name, "") AS m_name'))
                            ->where('p_id', '=', $id)
                            ->orderBy('p_date', 'DESC')
                            ->get();
    $statusLabel = $dataHeader[0]->p_status;
    $dataHeader[0]->p_date=date('d-m-Y',strtotime($dataHeader[0]->p_date));
    if ($statusLabel == "WT") 
    {
        $spanTxt = 'Waiting';
        $spanClass = 'label-info';
    }
    elseif ($statusLabel == "DE")
    {
        $spanTxt = 'Dapat Diedit';
        $spanClass = 'label-warning';
    }
    else
    {
        $spanTxt = 'Di setujui';
        $spanClass = 'label-success';
    }
    if ($type == "all") 
    {
      
        $dataIsi = d_purchaseplan_dt::join('m_item','ppdt_item','=','i_id')
                                ->join('d_purchase_plan','d_purchase_plan.p_id','=','ppdt_pruchaseplan')
                                ->join('m_satuan', 's_id', '=', 'i_satuan')
                                ->join('d_stock','s_item','=','i_id')
                                ->select('i_id',
                                         'm_item.i_code',
                                         'm_item.i_name',
                                         's_name',                                         
                                         'ppdt_qty',

                                         'ppdt_qtyconfirm',
                                         DB::raw('IFNULL(s_qty, 0) AS s_qty'),
                                         'ppdt_prevcost',
                                         'ppdt_pruchaseplan',
                                         'ppdt_detailid',
                                         'p_comp',
                                         'p_gudang'
                                )
                                ->where('ppdt_pruchaseplan', '=', $id)
                                ->where('p_comp',$gudang->p_comp)
                                ->where('p_gudang',$gudang->p_gudang)
                                ->orderBy('ppdt_detailid', 'ASC')
                                ->get();
      
    }
    else
    {

       $dataIsi = d_purchaseplan_dt::join('m_item','ppdt_item','=','i_id')
                                ->join('m_satuan', 's_id', '=', 'i_satuan')
                                ->join('d_stock','s_item','=','i_id')
                                ->select('i_id',
                                         'm_item.i_code',
                                         'm_item.i_name',
                                         's_name',                                         
                                         'ppdt_qty',
                                         'ppdt_qtyconfirm',
                                         's_qty',
                                         'ppdt_prevcost',
                                         'ppdt_pruchaseplan',
                                         'ppdt_detailid',
                                         'p_comp',
                                         'p_gudang'
                                )
                                ->where('ppdt_pruchaseplan', '=', $id)
                                ->where('p_comp',$gudang->p_comp)
                                ->where('p_gudang',$gudang->p_gudang)
                                ->where('ppdt_isconfirm', '=', "TRUE")
                                ->orderBy('ppdt_detailid', 'ASC')
                                ->get();
      

    }
   
    return Response()->json([
        'status' => 'sukses',
        'header' => $dataHeader,
        'data_isi' => $dataIsi,      
        'spanTxt' => $spanTxt,
        'spanClass' => $spanClass,
    ]);
  }


    static function konfirmasiPurchasePlan($request)
  {    
    // DB::beginTransaction();
    // try {
      // dd($request->all());
      
        //update table d_purchasingplan
        $plan = d_purchase_plan::where('p_id',$request->idPlan)->first();
        // return json_encode($plan);
        if ($request->statusConfirm != "WT") 
        {   

          $plan->update([
              'p_confirm' => date('Y-m-d',strtotime(Carbon::now())),
              'p_status' => $request->statusConfirm,
              'p_updated' => Carbon::now(),
          ]);
            
            //update table d_purchasingplan_dt
            $hitung_field = count($request->fieldConfirm);
            
            for ($i=0; $i < $hitung_field; $i++) 
            {
                $plandt = d_purchaseplan_dt::where('ppdt_pruchaseplan',$request->idPlan)
                          ->where('ppdt_detailid',$i+1);

                $plandt->update([
                  'ppdt_qtyconfirm' => $request->fieldConfirm[$i],
                  'ppdt_updated' => Carbon::now(),
                  'ppdt_isconfirm' => "TRUE",
                ]);
            }
            // return  $plandt;
            // return $request->fieldIdDt;
        }
        else
        {
            $plan->update([
            'p_confirm' => null,
            'p_status' => $request->statusConfirm,
            'p_updated' => Carbon::now(),
            ]);
            //update table d_purchasingplan_dt
            $hitung_field = count($request->fieldConfirm);
            for ($i=0; $i < $hitung_field; $i++) 
            {
                 $plandt = d_purchaseplan_dt::where('ppdt_pruchaseplan',$request->idPlan)
                          ->where('ppdt_detailid',$request->fieldIdDt[$i]);
                   
                $plandt->update([
                'ppdt_qtyconfirm' => $request->fieldConfirm[$i],
                'ppdt_updated' => Carbon::now(),
                'ppdt_isconfirm' => "FALSE",
                ]);
            }
        }
        
        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Rencana Order Berhasil Diupdate'
        ]);
    // } 
    // catch (\Exception $e) 
    // {
    //     DB::rollback();
    //     return response()->json([
    //         'status' => 'gagal',
    //         'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
    //     ]);
    // }
  }

  
}
	
	