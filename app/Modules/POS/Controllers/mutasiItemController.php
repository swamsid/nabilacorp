<?php

namespace App\Modules\POS\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;
use App\Http\Controllers\Controller;
use App\Modules\POS\model\d_mutasi_item;
use App\Modules\POS\model\d_mutationitem_material;
use App\Modules\POS\model\d_mutationitem_product;
use Datatables;



use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;


class mutasiItemController extends Controller
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


    public function mutasiItemIndex()
    {
      $mutasiItem=view('POS::mutasiItem/mutasi_item');
      $form=view('POS::mutasiItem/form-mutasi');
      return view('POS::mutasiItem/mutasi',compact('mutasiItem','form'));
    }
    public function dataMutasiItem(Request $request)
    {
      return d_mutasi_item::mutasiItem($request);
    }

    public function store(Request $request){
        return d_mutasi_item::store($request);
    }

    public function perbarui(Request $request,$id){
        return d_mutasi_item::perbarui($request,$id);
    }

    function mutasiItemDt($id,Request $request){
      $chek=$request->type;
      $dt=$request->dt;
        if($chek=='Bahan'){
          $status=$request->s_status;          
          $data=d_mutationitem_material::mutasiItemDt($id);          
          $tamp=[];
          foreach ($data as $key => $value) {
              $tamp[$key]=$value->i_id;
          }
          $tamp=array_map("strval",$tamp);
          return view('POS::mutasiItem/editDetailBahan',compact('data','tamp','status','dt'));
        }

        else if($chek=='Hasil'){
          $status=$request->s_status;
          $data=d_mutationitem_product::mutasiItemDt($id);
          $tamp=[];
          foreach ($data as $key => $value) {
              $tamp[$key]=$value->i_id;
          }
          $tamp=array_map("strval",$tamp);
          return view('POS::mutasiItem/editDetailHasil',compact('data','tamp','status','dt'));
        }
    }

    public function destroy($id){
      return d_mutasi_item::destroy($id);
    }

}
