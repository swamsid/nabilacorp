<?php

namespace App\Modules\Produksi\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Modules\POS\model\d_sales;



class produksiController extends Controller
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
    public function produksi()
    {  
        $data=view('Produksi::sam');
     return view('Produksi::o_produksi/produksi3',compact('data'));
        
    }

 function printNota($id){
      $data=d_sales::printNota($id);
      
      return view('POS::POSpenjualanToko/printNota',compact('data'));
   
  }
    public function monitoring()
    {
        return view('/produksi/monitoringprogress/monitoring');
    }

     public function spk()
    {
        return view('/produksi/spk/spk');
    }

     public function baku()
    {
        return view('/produksi/bahanbaku/baku');
    }

     public function sdm()
    {
        return view('/produksi/sdm/sdm');
    }

     public function produksi2()
    {
        return view('/produksi/produksi/produksi2');
    }

     public function produksi3()
    {
        return view('/produksi/o_produksi/produksi3');
    }

     public function waste()
    {
        return view('/produksi/waste/waste');
    }
    public function tambah_produksi()
    {

        return view('/produksi/o_produksi/tambah_produksi');
    }
}
