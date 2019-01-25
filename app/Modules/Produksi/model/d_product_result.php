<?php

namespace App\Modules\Produksi\model;

use Illuminate\Database\Eloquent\Model;

use DB;

use Datatables;

use App\Lib\format;

use App\Lib\mutasi;

use App\Modules\Produksi\model\d_productresult_dt;

use Session;

class d_product_result extends Model
{
    protected $table = 'd_productresult';
    protected $primaryKey = 'pr_id';
    const CREATED_AT = 'pr_created';
    const UPDATED_AT = 'pr_updated';

    protected $fillable = ['pr_id','pr_comp','pr_code','pr_date','pr_note','pr_status'];

    static function data($request){
      $from=date('Y-m-d',strtotime($request->tanggal1));
      $to=date('Y-m-d',strtotime($request->tanggal2));
      $productresult=d_product_result::whereBetween('pr_date', [$from, $to])->where('pr_comp',Session::get('user_comp'))->get();

       return Datatables::of($productresult)
                        ->editColumn('pr_date', function ($productresult) {
                                return date('d-m-Y',strtotime($productresult->pr_date));
                        })
                        ->addColumn('action', function ($productresult) {
                            $disable='';
                            if($productresult->pr_status=='Y'){
                              $disable='disabled';
                            }

                            $html='';

                          $html.='<div class="text-center">
                          <button class="btn btn-sm btn-success" title="Detail" onclick="detail(
                                                '.$productresult->pr_id.',
                                                \''.$productresult->pr_code.'\',
                                                \''.date('d-m-Y',strtotime($productresult->pr_date)).'\',
                                                \''.$productresult->pr_note.'\',
                          )"><i class="fa fa-eye"></i>
                          </button>
                          <button class="btn btn-sm btn-warning" title="Edit" onclick="edit(
                                                '.$productresult->pr_id.',
                                                \''.$productresult->pr_code.'\',
                                                \''.date('d-m-Y',strtotime($productresult->pr_date)).'\',
                                                \''.$productresult->pr_note.'\',
                          )" '.$disable.' ><i class="fa fa-edit"></i>
                          </button>
                          <button class="btn btn-sm btn-danger" title="Hapus" onclick="deleteProduksi(
                          '.$productresult->pr_id.'
                          )" '.$disable.'><i class="fa fa-times"></i>
                          </button>
                          </div>';

                            return $html;
                        })
                        ->rawColumns(['action','p_status'])
                      ->make(true);


    }

    static function editDetail($id){
          return DB::table('d_productresult_dt')->join('m_item','prdt_item','=','i_id')
                 ->join('m_satuan','s_id','=','i_satuan')
                 /*->join('d_stock','s_item','=','i_id')*/
                  ->join('d_stock',function($join){
                  $join->on('s_item','=','i_id');
                  $join->on('s_comp','=','prdt_comp');
                  $join->on('s_position','=','prdt_position');
                  })
                 ->where('prdt_productresult',$id)
                 ->orderBy('prdt_detailid','ASC')
                 ->get();
    }

    static function detail($id){
          return DB::table('d_productresult_dt')->join('m_item','prdt_item','=','i_id')
                 ->join('m_satuan','s_id','=','i_satuan')
                 ->where('prdt_productresult',$id)
                 ->orderBy('prdt_detailid','ASC')
                 ->get();
    }

    static function simpan($request){
      return DB::transaction(function () use ($request) {
       $pr_id=d_product_result::max('pr_id')+1;
               $query = DB::select(DB::raw("SELECT MAX(RIGHT(pr_code,4)) as kode_max from d_productresult WHERE DATE_FORMAT(pr_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
      $kd = "";

      if(count($query)>0)
      {
        foreach($query as $k)
        {
          $tmp = ((int)$k->kode_max)+1;
          $kd = sprintf("%05s", $tmp);
        }
      }
      else
      {
        $kd = "00001";
      }

      $pr_code = "PR-".date('ym')."-".$kd;

    $pr_date=date('Y-m-d',strtotime($request->pr_date));
              d_product_result::create([
                      'pr_id'=>$pr_id,
                      'pr_comp'=>Session::get('user_comp'),
                      'pr_date'=>$pr_date,
                      'pr_code'=>$pr_code,
                      'pr_note'=>$request->pr_note,
                ]);
              for ($i=0; $i <count($request->prdt_item); $i++) {

              $prdt_hpp= format::format($request->prdt_hpp[$i]);
              $prdt_qty= format::format($request->prdt_qty[$i]);
              $detailid=d_productresult_dt::where('prdt_productresult',$pr_id)->max('prdt_detailid')+1;
              $comp=$request->comp[$i];
              $position=$request->position[$i];
               d_productresult_dt::create([
                                'prdt_productresult'=>$pr_id,
                                'prdt_detailid'=>$detailid,
                                'prdt_item'=>$request->prdt_item[$i],
                                'prdt_qty'=>$prdt_qty,
                                'prdt_hpp'=>$prdt_hpp,
                                'prdt_comp'=>$comp,
                                'prdt_position'=>$position,
                                 ]);

               
                $simpanMutasi=mutasi::tambahmutasi($request->prdt_item[$i],$prdt_qty,$comp,$position,'TAMBAH BARANG HASIL PRODUKSI',5,$pr_code,'','',$prdt_hpp,$pr_date);


                if($simpanMutasi['true']){

                }else{

                  DB::rollBack();
                  $data=['status'=>'gagal','data'=>'gagal'];
                  return json_encode($data);

                }
             }

          $data=['status'=>'sukses','data'=>'sukses'];
          return json_encode($data);

      });
    }


 static function perbarui($id,$request){
    return DB::transaction(function () use ($id,$request) {
              $pr_code=$request->pr_code;
              $pr_date=date('Y-m-d',strtotime($request->pr_date));
              $updateProductresult=
                          d_product_result::where('pr_id',$id);
              $updateProductresult->update([
                      'pr_note'=>$request->pr_note
                ]);





            $hapusdtHasil=[];
          if($request->hapusdtHasil!=null){
            $hapusdtHasil = explode(',',$request->hapusdtHasil);
          }


  //Hapus Material
        for ($h=0; $h <count($hapusdtHasil) ; $h++) {
                $hapusItem=$hapusdtHasil[$h];
                $hapus_product_dt=d_productresult_dt::where('prdt_productresult',$id)->where('prdt_item',$hapusItem);

                if($hapus_product_dt->first()){
                  $permintaan=$hapus_product_dt->first()->prdt_qty;

                  if($permintaan>0){

              $comp=$request->comp[$h];

              $position=$request->position[$h];                                                 
        $simpanMutasi=mutasi::hapusMutasi($hapusItem,$permintaan,$comp,$position,$flag='Hasil Produksi',$pr_code);

              

              if($simpanMutasi['true']){
                    $hapus_product_dt->delete();
              }else{

                  DB::rollBack();
                  $data=['status'=>'gagal','data'=>'gagal'];
                  return json_encode($data);

              }










                    }
                }
          }








             for ($i=0; $i <count($request->prdt_item); $i++) {


              if($request->prdt_productresult[$i]!=='' && $request->prdt_detailid[$i]!=='' &&
                $request->prdt_productresult[$i]!==null && $request->prdt_detailid[$i]!==null){

              $permintaan=format::format($request->prdt_qty[$i])-format::format($request->jumlahAwal[$i]);
              $prdt_hpp= format::format($request->prdt_hpp[$i]);
              $comp=$request->comp[$i];
              $position=$request->position[$i];

              $simpanMutasi=mutasi::perbaruimutasi($request->prdt_item[$i],$permintaan,$comp,$position,$flag='Hasil Produksi',$idFlag=3,$pr_code,$flagTujuan='',$idMutasiTujuan='',$prdt_hpp);


              if($simpanMutasi['true']){

                  $prdt_qty= format::format($request->prdt_qty[$i]);

                  $productresult_dt=d_productresult_dt::where('prdt_productresult',$id)->where('prdt_detailid',$request->prdt_detailid[$i]);

                   $productresult_dt->update([
                                    'prdt_qty'=>$prdt_qty,
                                    'prdt_hpp'=>$prdt_hpp
                                     ]);

              }else{
                  DB::rollBack();
                  $data=['status'=>'gagal','data'=>'gagal'];
                  return json_encode($data);
              }




             }else{


              $prdt_hpp= format::format($request->prdt_hpp[$i]);
              $prdt_qty= format::format($request->prdt_qty[$i]);
              $detailid=d_productresult_dt::where('prdt_productresult',$id)->max('prdt_detailid')+1;
              $comp=$request->comp[$i];
              $position=$request->position[$i];

               d_productresult_dt::create([
                                'prdt_productresult'=>$id,
                                'prdt_detailid'=>$detailid,
                                'prdt_comp'=>$comp,
                                'prdt_position'=>$position,
                                'prdt_item'=>$request->prdt_item[$i],
                                'prdt_qty'=>$prdt_qty,
                                'prdt_qty_sisa'=>$prdt_qty,
                                'prdt_hpp'=>$prdt_hpp
                                 ]);

$simpanMutasi=mutasi::tambahmutasi($request->prdt_item[$i],$prdt_qty,$comp,$position,'TAMBAH BARANG HASIL PRODUKSI','5',$pr_code,'','',$prdt_hpp,$pr_date);

              if($simpanMutasi['true']){


              }else{
                  DB::rollBack();
                  $data=['status'=>'gagal','data'=>'gagal'];
                  return json_encode($data);
              }







         }



             }

        $data=['status'=>'sukses','data'=>'sukses'];
        return json_encode($data);
      });
 }

 static function destroy($id){
  return DB::transaction(function () use ($id) {
        $updateProductresult=
                          d_product_result::where('pr_id',$id);
        if($updateProductresult->first()->pr_status=='Y'){
            $data=['status'=>'gagal','data'=>'Data sudah digunakan'];
            return json_encode($data);
        }


          $hapus_product_dt=d_productresult_dt::where('prdt_productresult',$id)->get();


  //Hapus Material
        for ($h=0; $h <count($hapus_product_dt) ; $h++) {
                $hapusItem=$hapus_product_dt[$h]->prdt_item;

                $hapus=d_productresult_dt::where('prdt_productresult',$id)->where('prdt_item',$hapusItem);

                if($hapus->first()){
                  $permintaan=$hapus->first()->prdt_qty;

                  if($permintaan>0){

      $simpanMutasi=mutasi::hapusMutasi($hapusItem,$permintaan,$hapus_product_dt[0]->prdt_comp,$hapus_product_dt[0]->prdt_position,$flag='Hasil Produksi',$updateProductresult->first()->pr_code);


              if($simpanMutasi['true']){
                $hapus->delete();

              }else{
                  DB::rollBack();
                  $data=['status'=>'gagal','data'=>'gagal'];
                  return json_encode($data);
              }





                    }
                }
          }
           $updateProductresult->delete();
        $data=['status'=>'sukses','data'=>'sukses'];
        return json_encode($data);

  });
 }
  }
