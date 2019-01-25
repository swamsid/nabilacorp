<?php

namespace App\Modules\POS\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;

use App\m_item;

use App\Http\Controllers\Controller;

use App\mMember;
use App\Modules\POS\model\m_paymentmethod;
use App\Modules\POS\model\d_salesb;
use App\Modules\POS\model\d_sales_dt;

use Datatables;






class PenjualanPesananController extends Controller
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
    


    public function POSpenjualan()
    {
      $pilihan=view('POS::POSpenjualan.pilihan');
      return view('POS::POSpenjualan/POSpenjualan',compact('pilihan'));
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
      $pm=view('POS::paymentmethod/paymentmethod',compact('paymentmethod'));    */
      $data['toko']=view('POS::pos-pesanan/pesanan');      
      $data['listtoko']=view('POS::pos-pesanan/listpesanan');   
      return view('POS::pos-pesanan/pos-pesanan',compact('data'));
    }

    function create(Request $request){      
      return d_salesb::simpanPesanan($request);
    }

     function update(Request $request){
      
      return d_salesb::perbaruiPesanan($request);
    }

    function penjualanDtPesanan($id,Request $request){      
      $status=$request->s_status;      
      $data=d_sales_dt::penjualanDt($id);
      $tamp=[];
      foreach ($data as $key => $value) {
          $tamp[$key]=$value->i_id;
      }      
      $tamp=array_map("strval",$tamp);      
      return view('POS::pos-pesanan/editDetailPenjualan',compact('data','tamp','status'));
      
    }

    function listPenjualanPesanan(Request $request){
      if($request->ajax()){
        return view('POS::pos-pesanan/tableListToko');
      }else{
        return 'f';
      }
        
    }
    function listPenjualanDataPesanan(Request $request){
      /*if($request->ajax()){*/
        return d_salesb::listPenjualanData($request);
      /*}else{
        return 'f';
      }*/
      
    }
  function printNota($id){
      $data=d_salesb::printNota($id);
      return view('POS::pos-pesanan/printNota',compact('data'));
   
  }
   public function POSpenjualanPesanan()
    {
      return view('POS::pos-pesanan/pos-pesanan');
    }
}
 /*<button class="btn btn-outlined btn-info btn-sm" type="button" data-target="#detail" data-toggle="modal">Detail</button>*/