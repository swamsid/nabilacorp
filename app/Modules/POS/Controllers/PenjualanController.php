<?php

namespace App\Modules\POS\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;

use App\m_itemm;
use App\m_price;
use App\d_stock;

use App\Http\Controllers\Controller;

use App\mMember;
use App\Modules\POS\model\m_paymentmethod;
use App\Modules\POS\model\m_machine;
use App\Modules\POS\model\d_salesb;
use App\Modules\POS\model\d_sales_dt;

use Datatables;

use Auth;






class PenjualanController extends Controller
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
    
   /* public function cut(){
      $connector = new FilePrintConnector("\\\TAZIZ-PC\POS-80");
      $printer = new Printer($connector);
      $printer -> cut();
      $printer -> close();

    }*/
    
    public function indexStok(){
        return view('POS::penjualanStock/index',compact('d'));
    }
    public function dataStok(){
      $stok=d_stock::dataStok();
      return $stok;      
    }
    public function s(){
      $d='data';
      return view('POS::POSpenjualanToko/s',compact('d'));
    }
    public function POSpenjualan()
    {
      
      $pilihan=view('POS::POSpenjualan.pilihan');
      return view('POS::POSpenjualan/POSpenjualan',compact('pilihan'));
    }
    //auto complete barang
    
    public function itemRencana(Request $item)
    { 
      return m_itemm::itemRencana($item);
    }
    public function item(Request $item)
    { 
      return m_itemm::seachItem($item);
    }
    public function searchItemCode(Request $item)
    { 
      
      return m_itemm::searchItemCode($item);
    }
    
    //auto complete customer
    public function customer(Request $customer){
      return m_customer::customer($customer);     
    }

    function paymentmethod (Request $request){
      $jumlah=$request->dataIndex;
      $paymentmethod=m_paymentmethod::pm();       
      $data =view('POS::paymentmethod/paymentmethod',compact('paymentmethod','jumlah'));    
      $a='';
      $a.=$data;
      $x=['view'=>$a,'jumlah'=>$jumlah];
      return $x;
    }
    function paymentmethodEdit($id,$flag){
      $data=m_paymentmethod::paymentmethodEdit($id,$flag);              
      $jumlah=count($data['sales_pm']);
       $data =view('POS::paymentmethod/paymentmethodEdit',compact('data','jumlah'));    
       $a='';
      $a.=$data;
      $x=['view'=>$a,'jumlah'=>$jumlah];
      return $x;

    }
    
    public function posToko()
    { 
      $printPl=view('Produksi::sam');
      $flag='Toko';
      $paymentmethod=m_paymentmethod::pm();       
      $daftarHarga=DB::table('m_price_group')->where('pg_active','=','TRUE')->get();             
      $pm =view('POS::paymentmethod/paymentmethod',compact('paymentmethod'));    
      $machine=m_machine::showMachineActive();      
      $data['toko']=view('POS::POSpenjualanToko/toko',compact('machine','paymentmethod','daftarHarga'));      
      $data['listtoko']=view('POS::POSpenjualanToko/listtoko');   
      return view('POS::POSpenjualanToko/POSpenjualanToko',compact('data','pm','printPl','paymentmethod'));
    }

    function create(Request $request){
      return d_salesb::simpan($request);
    }

     function update(Request $request){
      
      return d_salesb::perbarui($request);
    }

    function penjualanDtToko($id,Request $request){      
      $status=$request->s_status;
      $data=d_sales_dt::penjualanDt($id);
      $tamp=[];
      foreach ($data as $key => $value) {
          $tamp[$key]=$value->i_id;
      }      
      $tamp=array_map("strval",$tamp);           
      return view('POS::POSpenjualanToko/editDetailPenjualan',compact('data','tamp','status'));
      
    }

    


    function penjualanViewDtToko($id){            
      $data=d_sales_dt::penjualanDt($id);
      $tamp=[];
      foreach ($data as $key => $value) {
          $tamp[$key]=$value->i_id;
      }      
      $tamp=array_map("strval",$tamp);      
      return view('POS::POSpenjualanToko/viewDetailPenjualan',compact('data','tamp'));
      
    }


    function listPenjualan(Request $request){
      if($request->ajax()){
        return view('POS::POSpenjualanToko/tableListToko');
      }else{
        return 'f';
      }
        
    }
    function listPenjualanData(Request $request){
      /*if($request->ajax()){*/
        return d_salesb::listPenjualanData($request);
      /*}else{
        return 'f';
      }*/
      
    }
  function printNota($id, Request $request){
      /*$jumlah=count(($request->sd_item));     */      
      

      

      $bayar=$request->s_bayar;
      $kembalian=$request->kembalian;
      $data=d_salesb::printNota($id);
      $dt=d_sales_dt::where('sd_sales',$id)->select('sd_sales')->get();
      $jumlah=count($dt);
      
      return view('POS::POSpenjualanToko/printNota',compact('data','kembalian','bayar','jumlah'));
   
  }
   public function POSpenjualanPesanan()
    {
      return view('/penjualan/POSpenjualanPesanan/POSpenjualanPesanan');
    }

    // Method untuk modul manajemen harga
    public function harga() {
      return view('POS::manajemenharga/harga');
    }

    public function find_m_price() {
      $m_price = m_price::take(100)->get();
      foreach ($m_price as $item) {
        $item['i_code'] = '';
        $item['i_name'] = '';
        $item['i_type'] = '';
        $item['g_name'] = '';
        if($item->m_item != null) {
          $item['i_code'] = $item->m_item->i_code;
          $item['i_name'] = $item->m_item->i_name;
          $item['i_type'] = $item->m_item->i_type;
          $item['g_name'] = $item->m_item->m_group->g_name;

        }
      }

      $data = array('data' => $m_price);
      return response()->json($data);
    }

    public function update_m_price(Request $req) {
      $m_pid = $req->m_pid;
      $m_pid = $m_pid != null ? $m_pid : '';
      $status = 'gagal';
      if($m_pid != '') {
        $m_pbuy1 = $req->m_pbuy1;
        $m_pbuy1 = $m_pbuy1 != null ? $m_pbuy1 : '';
        $m_pbuy2 = $req->m_pbuy2;
        $m_pbuy2 = $m_pbuy2 != null ? $m_pbuy2 : '';
        $m_pbuy3 = $req->m_pbuy3;
        $m_pbuy3 = $m_pbuy3 != null ? $m_pbuy3 : '';

        $data = m_price::find($m_pid);
        $data->m_pbuy1 = $req->m_pbuy1;
        $data->m_pbuy2 = $req->m_pbuy2;
        $data->m_pbuy3 = $req->m_pbuy3;
        $data->save(); 
        $status = 'sukses';
      }

      $res = array('status' => $status);
      return response()->json($res);
    }
    // =======================================================
}
 /*<button class="btn btn-outlined btn-info btn-sm" type="button" data-target="#detail" data-toggle="modal">Detail</button>*/