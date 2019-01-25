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
use App\Modules\POS\model\d_item_titip;
use App\Modules\POS\model\d_itemtitip_dt;
use Datatables;

use Auth;






class ItemTitipController extends Controller
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
      $data['form']=view('POS::barangTitip/form');      
      $data['list']=view('POS::barangTitip/list');  
      $data['modal']=view('POS::barangTitip/modal');     
      return view('POS::barangTitip/index',compact('data','pm'));
    }

    function data(Request $request){
      /*if($request->ajax()){*/
        return d_item_titip::itemTitip($request);
     /* }else{
        return 'f';
      }     */ 
    }


    function store(Request $request){      
      return d_item_titip::store($request);
    }

    function edit($id){
      return d_item_titipan::edit($request);
    }

    function update(Request $request){
          return d_item_titipan::update($request);
    }

    function serahTerima($id){
      $master=d_item_titip::dataTitip($id);      
      $data=d_itemtitip_dt::itemTitipDt($id);
      return view('POS::barangTitip/detailSerahTerima',compact('data','master'));      
    }

function searchItemTitipan(Request $request){
      return m_itemm::searchItemTitipan($request);
}

    function searchItemTitip(Request $request){
      return d_item_titip::searchItemTitip($request);
    }

  function titipDt($id){
        $data=d_itemtitip_dt::itemTitipDt($id);
        
        return view('POS::barangTitip/modal',compact('data'));                  
  }
}
