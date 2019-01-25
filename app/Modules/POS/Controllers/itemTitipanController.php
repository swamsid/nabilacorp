<?php

namespace App\Modules\POS\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;

use App\m_itemm;

use App\m_supplier;

use App\Http\Controllers\Controller;

use App\mMember;
use App\Modules\POS\model\m_paymentmethod;
use App\Modules\POS\model\d_item_titipan;
use App\Modules\POS\model\d_itemtitipan_dt;
use Datatables;

use Auth;






class itemTitipanController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function item(Request $item)
    { 
      return m_itemm::seachItem($item);
    }
    public function searchItemCode(Request $item)
    { 
      
      return m_itemm::searchItemCode($item);
    }    
    public function index()
    { 
      $paymentmethod=m_paymentmethod::pm();       
      $pm =view('POS::paymentmethod/paymentmethod',compact('paymentmethod'));  
      $data['form']=view('POS::barangTitipan/form');      
      $data['list']=view('POS::barangTitipan/list');  
      $data['modal']=view('POS::barangTitipan/modal');     
      return view('POS::barangTitipan/index',compact('data','pm'));
    }
    function chekQtyReturn($item,$comp,$position){
        return d_item_titipan::chekQtyReturn($item,$comp,$position);
    }

    function data(Request $request){
      if($request->ajax()){
        return d_item_titipan::itemTitipan($request);
      }else{
        return 'f';
      }      
    }

    function listData(Request $request){      
        return view('POS::barangTitipan/tableList');
    }


    function store(Request $request){      
      return d_item_titipan::store($request);
    }

    function edit($id){
      return d_item_titipan::edit($request);
    }

    function update(Request $request){      
          return d_item_titipan::updateTitipan($request);
    }
    function titipanDt($id){    
        $data=d_itemtitipan_dt::itemTitipanDt($id);
        return view('POS::barangTitipan/modal',compact('data'));                  
    }

    function editTitipanDt($id,Request $request){        
      $status=$request->s_status;      
      $data=d_itemtitipan_dt::editTitipanDt($id);      
      $tamp=[];
      foreach ($data as $key => $value) {
          $tamp[$key]=$value->i_id;
      }      
      $tamp=array_map("strval",$tamp);            
      return view('POS::barangTitipan/editDetailPenjualan',compact('data','tamp','status'));
      
    }

    function serahTerima($id){
      $master=d_item_titipan::dataTitipan($id);      
      $data=d_itemtitipan_dt::itemTitipanDt($id);      
      if($master){
        return view('POS::barangTitipan/detailSerahTerima',compact('data','master'));          
      }else{
        return 'data tidak ada';      
      }
    }
    function serahTerimaStore(Request $request){      
      return  d_item_titipan::serahTerimaStore($request);
    }
    function itemTitipan(Request $request){
      return m_itemm::searchItemTitipan($request);
    }

}
