<?php

namespace App\Modules\Purchase\Controllers;





use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;

use App\m_item;

use App\Http\Controllers\Controller;

use App\mMember;
use App\Modules\Purchase\model\d_purchase_plan;

use Datatables;






class purchasePlaController extends Controller
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
         return   m_item::seachItemPurchase($request);
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
      return d_purchase_plan::dataPlan($request);
   }

   public function getDetailPlan($id,$type){     
      return d_purchase_plan::getDetailPlan($id,$type);
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