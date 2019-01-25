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

use Datatables;

use Session;






class purchasePlanController extends Controller
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
    

   
   public function seachItemPurchase(Request $request){
         return m_itemm::seachItemPurchase($request);
   }
   public function storePlan(Request $request){
      return d_purchase_plan::simpan($request);

   }
   public function planIndex(){     
     $daftar =view('Purchase::rencanapembelian/daftar');   
     $history =view('Purchase::rencanapembelian/history');   
     $modalDetail =view('Purchase::rencanapembelian/modal-detail');   
     $modalEdit =view('Purchase::rencanapembelian/modal-edit');   
     
     return view('Purchase::rencanapembelian/rencana',compact('daftar','history','modalDetail','modalEdit'));
   }
   public function dataPlan(Request $request){

      $tanggal1 = date('Y-m-d',strtotime($request->tanggal1));
      $tanggal2 = date('Y-m-d',strtotime($request->tanggal2));
      $data = d_purchase_plan::join('m_supplier','d_purchase_plan.p_supplier','=','m_supplier.s_id')
              ->join('d_mem','d_purchase_plan.p_mem','=','d_mem.m_id')
              // ->select('d_pcsp_id','d_pcsp_code','s_company','d_pcsp_status','d_pcsp_datecreated','d_pcsp_dateconfirm', 'd_mem.m_id', 'd_mem.m_name')
              ->whereBetween('d_purchase_plan.p_date', [$tanggal1, $tanggal2])
              ->where('p_comp','=',Session::get('user_comp'))
              ->orderBy('p_created', 'DESC')
              ->get();
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
      ->editColumn('hargaTotal', function ($data) 
      {
        return 'Rp. '.number_format($data->d_pcsh_totalprice,2,",",".");
      })
     ->addColumn('aksi', function($data)
      {
        if ($data->p_status == "WT") 
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
        elseif ($data->p_status == "DE") 
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailPlanAll("'.$data->p_id.'")><i class="fa fa-eye"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editPlan("'.$data->p_id.'")><i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Hapus"
                          onclick=deletePlan("'.$data->p_id.'") disabled><i class="fa fa-times"></i>
                      </button>
                  </div>'; 
        }
        elseif ($data->p_status == "FN") 
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailPlanAll("'.$data->p_id.'")><i class="fa fa-eye"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editPlan("'.$data->p_id.'") disabled><i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Hapus"
                          onclick=deletePlan("'.$data->p_id.'") disabled><i class="fa fa-times"></i>
                      </button>
                  </div>'; 
        }
      })
      ->rawColumns(['status', 'aksi','tglConfirm'])
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