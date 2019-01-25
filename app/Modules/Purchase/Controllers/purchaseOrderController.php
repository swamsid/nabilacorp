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
use App\Modules\Purchase\model\d_purchase_order;
use App\Modules\Purchase\model\d_purchaseorder_dt;

use App\m_supplier;

use Datatables;






class purchaseOrderController extends Controller
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

   public function konvertRp($value)
    {
      $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
      return (int)str_replace(',', '.', $value);
    }
   public function seachItemPurchase(Request $request){
         return   m_itemm::seachItemPurchase($request);
   }
   public function simpanOrder(Request $request){
      d_purchase_order::simpanOrder($request);

   }
   public function orderIndex(){
    $tindex =view('Purchase::orderpembelian/tab-index');
    $history =view('Purchase::orderpembelian/tab-history');
    /*$to =view('Purchase::orderpembelian/tambah_order');   */

    $modal =view('Purchase::orderpembelian/modal');
    $modaledit =view('Purchase::orderpembelian/modal-edit');

    $modaldetail=view('Purchase::orderpembelian/modal-detail-peritem');
    $modaldetail_show=view('Purchase::orderpembelian/modal-detail-order');

     return view('Purchase::orderpembelian/index',compact('tindex','history','to','modal','modaledit','modaldetail','modaldetail_show'));
   }
   public function dataOrder(Request $request){
      return d_purchase_order::dataOrder($request);
   }
   public function formOrder()
    {
         return view('Purchase::orderpembelian/tambah_order');
    }
     public function getDataForm($id)
    {
         return d_purchase_order::getDataForm($id);
    }
        public function getDataCodePlan(Request $request)
    {

         return d_purchase_order::getDataCodePlan($request);
    }

     public function seachSupplier(Request $request) {
        // dd($request->all());
      // return 'a';
        return m_supplier::seachSupplier($request);

     }
     public function savePo(Request $request)
     {
       // dd($request->all());

      return d_purchase_order::savePo($request);

     }
     public function getDataDetail(Request $request,$id)
     {
        // return 'a';
        $dataHeader = d_purchase_order::join('m_supplier', 's_id', '=', 'po_supplier')
                            ->join('d_mem','m_id','=','po_mem')
                            ->where('po_id',$id)->first();
        // $dataHeader = d_purchase_order::where('po_id',$id)->first();
        $dataIsi = d_purchaseorder_dt::
                                join('d_purchase_order','podt_purchaseorder','=','po_id')
                                ->leftjoin('m_item','podt_item','=','i_id')
                                // ->leftjoin('d_item_supplier','is_item','=','i_id')
                                // ->leftjoin('m_price','m_pitem','=','i_id')
                                ->leftjoin('m_satuan', 's_id', '=', 'podt_satuan')
                                // ->leftjoin('d_stock','s_item','=','i_id')
                                ->where('podt_purchaseorder', '=', $id)
                                // ->where('po_comp',$gudang->p_comp)
                                // ->where('popen(command, mode)_gudang',$gudang->p_gudang)
                                // ->where('podt_ispo', '=', "FALSE")
                                // ->where('podt_isconfirm', '=', "TRUE")
                                ->orderBy('podt_created', 'DESC')
                                ->get();
            // $prev_harga = [];
            $harga = [];

            for ($i=0; $i <count($dataIsi) ; $i++) {
              // $prev_harga = '';
              $prev_harga[$i] = DB::table('d_item_supplier')
                                ->where('is_item',$dataIsi[$i]->i_id)
                                ->get();

                if ($dataIsi[$i]->satuan_position == 1) {
                  if ($dataIsi[$i]->is_price1 != null) {
                      $harga[$i] = $dataIsi[$i]->is_price1;
                  }else{
                      $harga[$i] = 0;
                  }
                }elseif ($dataIsi[$i]->satuan_position == 2) {
                  if ($dataIsi[$i]->is_price2 != null) {
                      $harga[$i] = $dataIsi[$i]->is_price2;
                  }else{
                      $harga[$i] = 0;
                  }
                }elseif ($dataIsi[$i]->satuan_position == 3) {
                  if ($dataIsi[$i]->is_price3 != null) {
                      $harga[$i] = $dataIsi[$i]->is_price3;
                  }else{
                      $harga[$i] = 0;
                  }
                }
            }

            // return $prev_harga;
            // return $harga;


        return response()->json([
            'status' => 'sukses',
            'data_isi' => $dataIsi,
            'header' => $dataHeader,
            'data_prev' => $harga,
        ]);
     }
     public function deleteDataOrder(Request $request)
     {
      $dataHeader = d_purchase_order::where('po_id',$request->idPo)->delete();
      $dataDetail = d_purchaseorder_dt::where('podt_purchaseorder',$request->idPo)->delete();
       // dd($request->all()); 
        return response()->json([
            'status' => 'sukses',
        ]);
     }
     public function getDataEdit($id)
     {    
        $dataHeader = d_purchase_order::join('m_supplier','s_id','po_supplier')->where('po_id',$id)->where('po_status','=','WT')->get();
        
        $dataIsi = d_purchaseorder_dt::join('m_item','i_id','podt_item')
                            ->join('m_satuan','s_id','podt_satuan')
                            ->leftjoin('d_stock','s_item','=','i_id')
                            ->where('podt_purchaseorder',$id)
                            ->orderBy('i_id','ASC')
                            ->get();


        $tamp=[];
        foreach ($dataIsi as $key => $value) {
          $tamp[$key]=$value->podt_item;
        }     
        $urut_index = count($tamp);
        $tamp=array_map("strval",$tamp); 


        return view('Purchase::orderpembelian/edit_order',compact('data','tamp','urut_index','dataIsi','dataHeader'));
     }
     public function updatePo(Request $request)
     {
       // dd($request->all());
      for ($i=0; $i <count($request->id_header_remove) ; $i++) { 
        $delete = DB::table('d_purchaseorder_dt')
                            ->where('podt_detailid',$request->id_detail_remove[$i])
                            ->where('podt_purchaseorder',$request->id_header_remove[$i])
                            ->delete();
      }
      for ($i=0; $i <count($request->podt_purchaseorder) ; $i++) { 
        $update = DB::table('d_purchaseorder_dt')
                            ->where('podt_detailid',$request->podt_detailid[$i])
                            ->where('podt_purchaseorder',$request->podt_purchaseorder[$i])
                            ->update([
                                'podt_qtysend'=>$request->fieldQtyconfirm[$i],
                                'podt_qty'=>$request->fieldQtyconfirm[$i],
                                'podt_price'=>$request->podt_price[$i],
                                'podt_total'=>$request->podt_total[$i],
                            ]);
      }

      return response()->json(['status'=>'sukses']);

     }

}
 /*<button class="btn btn-outlined btn-info btn-sm" type="button" data-target="#detail" data-toggle="modal">Detail</button>*/
