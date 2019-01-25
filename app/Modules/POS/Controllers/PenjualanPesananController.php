<?php

namespace App\Modules\POS\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;



use App\Http\Controllers\Controller;

use App\mMember;
use App\Modules\POS\model\m_paymentmethod;
use App\Modules\POS\model\d_salesb;
use App\Modules\POS\model\d_sales_dt;
use App\Modules\POS\model\m_machine;
use Datatables;
use App\Lib\format;
use App\m_item;





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

      /*$data['toko']=view('POS::pos-pesanan/pesanan');      
      $data['listtoko']=view('POS::pos-pesanan/listpesanan');   
      return view('POS::pos-pesanan/pos-pesanan',compact('data'));
*/

      $printPl=view('Produksi::sam');
      $flag='Pesanan';
      $daftarHarga=DB::table('m_price_group')->where('pg_active','=','TRUE')->get();  
      $paymentmethod=m_paymentmethod::pm();       
      $pm =view('POS::paymentmethod/paymentmethod',compact('paymentmethod'));    
      $machine=m_machine::showMachineActive();      
      $data['toko']=view('POS::pos-pesanan/pesanan',compact('machine','paymentmethod','daftarHarga'));      
      $data['listtoko']=view('POS::pos-pesanan/listpesanan');   
      return view('POS::pos-pesanan/pos-pesanan',compact('data','pm','printPl'));




    }

    function create(Request $request){      
      return d_salesb::simpanPesanan($request);
    }

     function update(Request $request){
      
      return d_salesb::perbaruiPesanan($request);
    }

     function serahTerima(Request $request){      
      return d_salesb::serahTerima($request); 
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


    function penjualanViewDtPesanan($id){            
      $data=d_sales_dt::penjualanDt($id);
      $tamp=[];
      foreach ($data as $key => $value) {
          $tamp[$key]=$value->i_id;
      }      
      $tamp=array_map("strval",$tamp);      
      return view('POS::POSpenjualanToko/viewDetailPenjualan',compact('data','tamp'));
      
    }

    function listPenjualanPesanan(Request $request){
      if($request->ajax()){
        return view('POS::pos-pesanan/tableListPesanan');
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
      $comp=m_item::perusahaan();
      

      $data=d_salesb::printNota($id);
      
      
      $dt=d_sales_dt::where('sd_sales',$id)->select('sd_sales')->get();
      $jumlah=count($dt);
      $reff=$data['sales']->s_note;
      $piutang=DB::table('d_receivable')->join('d_receivable_dt','r_id','=','rd_receivable')->where('r_ref','=',$reff)->get();      
     return view('POS::pos-pesanan/printNota',compact('data','kembalian','bayar','jumlah','piutang','ttlBayar','comp'));
     
   
  }

   public function POSpenjualanPesanan()
    {
      return view('POS::pos-pesanan/pos-pesanan');
    }
}
 /*<button class="btn btn-outlined btn-info btn-sm" type="button" data-target="#detail" data-toggle="modal">Detail</button>*/