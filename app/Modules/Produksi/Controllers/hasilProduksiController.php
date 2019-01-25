<?php

namespace App\Modules\Produksi\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Modules\Produksi\model\d_product_result;
use App\m_itemm;




class hasilProduksiController extends Controller
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
    public function index()
    {        
        
        
         $dataProduksi=view('Produksi::hasilProduksi/data-produksi');  
         $form=view('Produksi::hasilProduksi/form-produksi');  
         $detail=view('Produksi::hasilProduksi/modal-detail');  
         return view('Produksi::hasilProduksi/index',compact('dataProduksi','form','detail'));  
    }   

    
    public function seachItemProduksi(Request $request)
    {        
        return m_itemm::seachItemProduksi($request);
    }

    public function seachItemMutasi(Request $request)
    {        
        return m_itemm::seachItemMutasi($request);
    }

    
    public function data(Request $request)
    {        
        return d_product_result::data($request);
    }

    public function editDetail($id)
    {
        
        
      $data=d_product_result::editDetail($id);
      $tamp=[];
      foreach ($data as $key => $value) {
          $tamp[$key]=$value->i_id;
      }      
      $tamp=array_map("strval",$tamp);      
      return view('Produksi::hasilProduksi/editDetail',compact('data','tamp'));
    }


    public function create(Request $request)
    {
        return d_product_result::simpan($request);
    }

    public function updateData ($id,Request $request){
        /*dd($request->all());*/
         return d_product_result::perbarui($id,$request);
    }
    public function detail($id){
            $data=d_product_result::detail($id);   
            return view('Produksi::hasilProduksi/detail',compact('data'));
    }
    public function destroy($id){
        return d_product_result::destroy($id);   
    }


}
