<?php

namespace App\Modules\Produksi\Controllers;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Auth;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_itemm;
use Session;
class RencanaProduksiController extends Controller
{
  public function tabel(){
    $pp_comp=Session::get('user_comp');
    $pp = DB::Table('m_item')
          ->join('d_productplan','m_item.i_id','=','d_productplan.pp_item')
          ->where('pp_isspk','N')
          // ->where('pp_comp',$pp_comp)
          ->get();

    $datax = $this->setData($pp);

    echo json_encode($datax);
  }

  public function produksi(){    
    if (Auth::user()->punyaAkses('Rencana Produksi','ma_read')) 
    {
      $modalEdit =view('Produksi::rencanaproduksi.modal');
      return view('Produksi::rencanaproduksi.index',compact('modalEdit'));
    }
    else
    {
      return view('system.hakakses.errorakses');
    }
  }

  public function save(Request $request){

    $i_name = DB::Table('m_item')
            ->where('i_name',$request->namaitem)
            ->get();

    $maxid = DB::Table('d_productplan')->select('pp_id')->max('pp_id');
       if ($maxid <= 0 || $maxid <= '') {
          $maxid  = 1;
        }else{
          $maxid += 1;
        }

    $date = carbon::now()->format('Y-m-d');
    $pp_comp=Session::get('user_comp');
    $data = array(
              'pp_id'   => $maxid,
              'pp_date' => $date,
              'pp_comp' => $pp_comp,
              'pp_item' => $request->iditem,
              'pp_qty'  => $request->pp_qty,
            );
    //return $data;
    //*dd($data);/*
    $crud = $request->crud;
    if($crud == 'tambah'){
      $simpan = DB::Table('d_productplan')
            ->insert($data);
    }
    if($crud == 'edit'){
      $data['pp_id'] = $request->pp_id;
      $simpan = DB::Table('d_productplan')
            ->where('pp_id',$request->pp_id)
            ->update($data);
    }
    if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
    }else{
            $result['error']=$data;
            $result['result']=0;
    }
    $result['crud']=$crud;
    echo json_encode($result);

  }

  public function hapus_rencana($id){      
    $hapus = DB::Table('d_productplan')
            ->where('d_productplan.pp_id',$id)
            ->delete();

    if($hapus == TRUE){
            $result['error']='';
            $result['result']=1;
    }else{
            $result['error']=$hapus;
            $result['result']=0;
    }
    echo json_encode($result);
  }

  public function edit_rencana(Request $request){
    $i_name = DB::Table('m_item')
            ->where('i_name',$request->namaitem)
            ->get();

    $pplan = DB::Table('d_productplan')
            ->where('pp_id',$request->pp_id)
            ->update([
              'pp_item' => $i_name[0]->i_id,
              'pp_qty'  => $request->pp_qty,
            ]);

    return redirect('produksi/rencanaproduksi/produksi');

  }

  public function autocomplete(Request $request){
      return m_itemm::itemSpk($request);      
  }

  public function setData($pp){
    $data = array();
    foreach ($pp as $r) {
      $data[] = (array) $r;
    }
    $i=0;
    foreach ($data as $key) {
            // add new button
      $data[$i]['button'] = ' <div class="text-center">
                                   <button class="btn btn-warning btn-sm btn-flat fa fa-edit edit"
                                                  data-toggle="modal"
                                                  data-target="#myModal"
                                                  data-name="'.$key['i_name'].'"
                                                  data-id="'.$key['pp_id'].'"
                                                  data-iditem="'.$key['i_id'].'"
                                                  data-qty="'.$key['pp_qty'].'">
                                      </button>
                                      <button id="hapus"
                                                  data-name="'.$key['i_name'].'"
                                                  data-id="'.$key['pp_id'].'"
                                                  data-iditem="'.$key['i_id'].'"
                                                  class="fa fa-trash-o hapus btn btn-danger btn-sm">
                                      </button>
                              </div> ';
      $data[$i]['pp_date']='<span class="hide">'.$key['pp_date'].'</span>'.Date('d M Y', strtotime($key['pp_date']));
      $i++;
    }
    $datax = array('data' => $data);
    return $datax;

  }
}
