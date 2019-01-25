<?php

namespace App\Modules\POS\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use app\Customer;
use Carbon\carbon;
use DB;

use App\m_item;

use App\Http\Controllers\Controller;

use App\mMember;
use App\Modules\POS\model\m_paymentmethod;


class MutasiController extends Controller
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
    public function harga()
    {
        return view('/penjualan/manajemenharga/harga');
    }

    public function promosi()
    {
        return view('/penjualan/manajemenpromosi/promosi');
    }

    public function layananpesanan()
    {
        return view('/penjualan/layananpesanan/layananpesanan');
    }

    public function rencana()
    {
        return view('/penjualan/rencanapenjualan/rencana');
    }

    public function monitoringorder()
    {
        return view('/penjualan/monitoringorder/monitoring');
    }

    public function r_penjualan()
    {
        return view('/penjualan/manajemenreturn/r_penjualan');
    }

    public function progress()
    {
        return view('/penjualan/monitorprogress/progress');
    }
    public function tambah_rencana()
    {
        return view('/penjualan/rencanapenjualan/tambah_rencana');
    }
    public function mutasi()
    {
      return view('/penjualan/mutasistok/mutasi');
    }
    public function tambah_layananpesanan()
    {
      return view('/penjualan/layananpesanan/tambah_layananpesanan');
    }
    public function penjualanmobile()
    {
      return view('/penjualan/penjualanmobile/penjualanmobile');
    }
    public function produklangsung()
    {
      return view('/penjualan/produklangsung/produklangsung');
    }
    public function penjualanexpired()
    {
      return view('/penjualan/penjualanexpired/penjualanexpired');
    }
    public function repackaging()
    {
      return view('/penjualan/repackaging/repackaging');
    }
    public function konsinyasi()
    {
      return view('/penjualan/konsinyasi/konsinyasi');
    }
    public function POSpenjualan()
    {
      return view('/penjualan/POSpenjualan/POSpenjualan');
    }
    public function item(Request $item)
    {      
      return m_item::seachItem($item);
    }
    public function POSpenjualanToko()
    { 
      $paymentmethod=m_paymentmethod::pm();      
      $pm=view('POS::paymentmethod/paymentmethod',compact('paymentmethod'));    
      $data['toko']=view('POS::POSpenjualanToko/toko',compact('pm'));      
      $data['listtoko']=view('POS::POSpenjualanToko/listtoko');        
                           
      return view('POS::POSpenjualanToko/POSpenjualanToko',compact('data'));
    }
    public function paymentmethod(){
      $pm=m_paymentmethod::pm();
      $data=view('POS::POSpenjualanToko/paymentmethod',compact('pm'));      
      return json_encode($data);
    }
    public function POSpenjualanKonsinyasi()
    {
      return view('/penjualan/POSpenjualanKonsinyasi/POSpenjualanKonsinyasi');
    }
    public function POSpenjualanMobile()
    {
      return view('/penjualan/POSpenjualanMobile/POSpenjualanMobile');
    }
    public function POSpenjualanPesanan()
    {
      return view('/penjualan/POSpenjualanPesanan/POSpenjualanPesanan');
    }
}
