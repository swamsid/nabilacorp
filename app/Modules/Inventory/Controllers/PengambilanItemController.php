<?php

namespace App\Modules\Inventory\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\d_gudangcabang;
use App\d_productresult_dt;
use App\d_delivery_order;
use App\d_delivery_orderdt;
use App\d_stock;
use App\d_stock_mutation;
use Carbon\Carbon;
use DB;
use Response;
use Datatables;
use App\Lib\mutasi;

class PengambilanItemController extends Controller
{
    public function index(){
    	$gudang = d_gudangcabang::join('m_comp','m_comp.c_id','=','gc_comp')
            ->where('gc_gudang','GUDANG PENJUALAN')
    		->get();

    	return view('Inventory::pengiriman.index',compact('gudang'));
    }

    public function tabelDelivery($comp){
    	$data = d_productresult_dt::select('m_item.i_code',
            'm_item.i_name',
            'd_productresult_dt.prdt_qty',
            'd_productresult_dt.prdt_productresult',
            'd_productresult_dt.prdt_detail',
            'd_productresult_dt.prdt_item',
            'prdt_sisa',
            'prdt_kirim')
            ->join('d_productresult', 'd_productresult_dt.prdt_productresult', '=', 'd_productresult.pr_id')
            ->join('d_spk', 'd_productresult.pr_spk', '=', 'd_spk.spk_id')
            ->join('m_item', 'd_productresult.pr_item', '=', 'm_item.i_id')
            ->where('prdt_status', 'RD')
            // ->where('spk_comp',$comp)
            ->get();
        // dd($data);

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '<div class="text-center" data-toggle="buttons">
                <label class="btn btn-default">
                  <input id="something" type="checkbox" name="delivery[]" value="' . $data->prdt_productresult . '|' . $data->prdt_detail . '|' . $data->prdt_item . '|' . $data->prdt_qty . '">
                  <span class="glyphicon glyphicon-ok"></span>
                </label>
              </div>';

            })
            ->addColumn('prdt_qty', function ($data) {
                return '<input  id="prdt_qty" 
                      class="form-control text-right" 
                      type="text" 
                      name="prdt_qty[]" 
                      readonly
                      value="' . $data->prdt_qty . '">';

            })
            
            ->addColumn('prdt_qtySisa', function ($data) {
                return '<input  id="prdt_qtySisa'.$data->prdt_item.'" 
                      class="form-control text-right" 
                      type="text" 
                      readonly
                      name="prdt_qtySisa[]" 
                      value="' . $data->prdt_sisa . '">';

            })
            ->addColumn('prdt_qtyKirim', function ($data) {
                return '<input  id="prdt_qtyKirim'.$data->prdt_item.'" 
                      class="form-control text-right" 
                      type="number" 
                      name="prdt_qtyKirim[]" 
                      value=""
                      onkeyup="hitungKirim('.$data->prdt_item.',' .$data->prdt_sisa. ')"
                      onclick="hitungKirim('.$data->prdt_item.',' .$data->prdt_sisa. ')">';
                      
            })
            ->addColumn('prdt_item', function ($data) {
                return '' . $data->i_name . '<input  id="prdt_productresult" 
                      class="form-control hidden" 
                      type="text" 
                      name="prdt_productresult[]" 
                      readonly
                      value="' . $data->prdt_productresult . '">
                <input  id="prdt_detail" 
                      class="form-control hidden" 
                      type="text" 
                      name="prdt_detail[]" 
                      readonly
                      value="' . $data->prdt_detail . '">
                <input  id="prdt_item" 
                      class="form-control hidden" 
                      type="text" 
                      name="prdt_item[]" 
                      readonly
                      value="' . $data->prdt_item . '">';

            })
            ->addIndexColumn()
            ->rawColumns(['prdt_qty', 'prdt_item','prdt_qtyKirim','prdt_qtySisa'])
            ->make(true);
    }

    public function tabelKirim($tgl1, $tgl2, $comp)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7, -5);
        $d = substr($tgl1, 0, 2);
        $tgl1 = $y . '-' . $m . '-' . $d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7, -5);
        $d2 = substr($tgl2, 0, 2);
        $tgl2 = $y2 . '-' . $m2 . '-' . $d2;

        $data = d_delivery_order::select('do_date_send',
                                        'do_nota',
                                        'do_time',
                                        'do_date_received',
                                        'do_id',
                                        'c_name',
                                        'gc_gudang')
            ->where('do_date_send', '>=', $tgl1)
            ->where('do_date_send', '<=', $tgl2)
            ->join('d_gudangcabang','d_gudangcabang.gc_id','=','do_send')
            ->join('m_comp','m_comp.c_id','=','do_sendcomp')
            // ->where('do_comp',$comp)
            ->get();

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '<div class="text-center" data-toggle="buttons">
                <button style="margin-left:5px;" 
                          title="Lihat Detail" 
                          type="button"
                          onclick="lihatItem(' . $data->do_id . ')"
                          data-toggle="modal"
                          data-target="#modalDetailProduksi" 
                          class="btn btn-info fa fa-eye btn-sm"
                  </button>
                </div>';

            })
            ->editColumn('do_date_send', function ($user) {
                return date('d M Y', strtotime($user->do_date_send)) .' / '. $user->do_nota;
            })
            ->editColumn('tujuan', function ($user) {
                return $user->c_name .' - '. $user->gc_gudang;
            })
            ->rawColumns(['do_date_send', 'tujuan','action'])
            ->make(true);
    }

    function store(Request $request)
    {  
        DB::beginTransaction();
        try { 
            $gudTujuan = d_gudangcabang::select('gc_id','gc_comp')
                  ->where('gc_id',$request->prdt_produksi)
                  ->first();
            // nota do
            $year = carbon::now()->format('y');
            $month = carbon::now()->format('m');
            $date = carbon::now()->format('d');

            $maxiddo = d_delivery_order::select('do_id')->max('do_id') + 1;

            $nota_do = 'DO' . $year . $month . $date . '-' . '000' . '-' . $maxiddo;
            // end nota do
            $maxid = d_delivery_order::select('do_id')->max('do_id') + 1;

            d_delivery_order::insert([
                'do_id' => $maxid,
                'do_comp' => $request->comp,
                'do_send' => $gudTujuan->gc_id,
                'do_sendcomp' => $gudTujuan->gc_comp,
                'do_nota' => $nota_do,
                'do_date_send' => Carbon::now(),
                'do_time' => Carbon::now(),
                'do_insert' => Carbon::now()
            ]);

            for ($i = 0; $i < count($request->prdt_item); $i++) 
            {
                if ($request->prdt_qtyKirim[$i] != null) 
                {
                    d_delivery_orderdt::insert([
                        'dod_do' => $maxid,
                        'dod_detailid' => $i + 1,
                        'dod_prdt_productresult' => $request->prdt_productresult[$i],
                        'dod_prdt_detail' => $request->prdt_detail[$i],
                        'dod_item' => $request->prdt_item[$i],
                        'dod_qty_send' => $request->prdt_qtyKirim[$i],
                        'dod_date_send' => Carbon::now(),
                        'dod_time_send' => Carbon::now(),
                        'dod_qty_received' => 0,
                        'dod_status' => 'WT'
                    ]);
    
                    $cek = d_productresult_dt::where('prdt_productresult', $request->prdt_productresult[$i])
                        ->where('prdt_detail', $request->prdt_detail[$i])
                        ->first();
    
                    d_productresult_dt::where('prdt_productresult', $request->prdt_productresult[$i])
                        ->where('prdt_detail', $request->prdt_detail[$i])
                        ->update([
                            'prdt_kirim' => $request->prdt_qtyKirim[$i] + $cek->prdt_kirim, 
                            'prdt_sisa' =>$cek->prdt_sisa - $request->prdt_qtyKirim[$i], 
                        ]);
                    
                    // $compp = $request->comp;
                    $gc_id = d_gudangcabang::select('gc_id')
                          ->where('gc_gudang','GUDANG PRODUKSI')
                          // ->where('gc_comp',$compp)
                          ->first();
    
                    if (mutasi::mutasiStok(
                        $request->prdt_item[$i],
                        $request->prdt_qty[$i],
                        $comp = $gc_id->gc_id,
                        $position = $gc_id->gc_id,
                        $flag = 'MENGURANGI',
                        $nota_do,
                        'MENGURANGI',
                        Carbon::now(),
                        8)) {
                    }
    
                    $maxidd_stock = d_stock::select('s_id')->max('s_id') + 1;
                    //end add id d_stock
                    $gc_sending = d_gudangcabang::select('gc_id')
                          ->where('gc_gudang','GUDANG SENDING')
                          // ->where('gc_comp',$compp)
                          ->first();
                          // dd($gc_sending);
                    $stock = d_stock::where('s_item', $request->prdt_item[$i])
                        ->where('s_comp', $gudTujuan->gc_id)
                        ->where('s_position', $gc_sending->gc_id)
                        ->first();
    
                    if ($stock == null) 
                    {
                        d_stock::insert([
                            's_id' => $maxidd_stock,
                            's_comp' => $gudTujuan->gc_id,
                            's_position' => $gc_sending->gc_id,
                            's_item' => $request->prdt_item[$i],
                            's_qty' => $request->prdt_qtyKirim[$i]
                        ]);
    
                        d_stock_mutation::create([
                            'sm_stock' => $maxidd_stock,
                            'sm_detailid' => 1,
                            'sm_date' => Carbon::now(),
                            'sm_comp' => $gudTujuan->gc_id,
                            'sm_position' => $gc_sending->gc_id,
                            'sm_mutcat' => 9,
                            'sm_item' => $request->prdt_item[$i],
                            'sm_qty' => $request->prdt_qtyKirim[$i],
                            'sm_qty_used' => 0,
                            'sm_qty_sisa' => $request->prdt_qtyKirim[$i],
                            'sm_qty_expired' => 0,
                            'sm_detail' => 'PENAMBAHAN',
                            'sm_reff' => $nota_do,
                            'sm_insert' => Carbon::now()
                        ]);
    
                    } 
                    else 
                    {
    
                        $stockUpdate = $stock->s_qty + $request->prdt_qtyKirim[$i];
    
                        $stock->update([
                            's_qty' => $stockUpdate
                        ]);
    
                        $sm_detailid = d_stock_mutation::select('sm_detailid')
                                ->where('sm_item', $request->prdt_item[$i])
                                ->where('sm_comp', $gudTujuan->gc_id)
                                ->where('sm_position', $gc_sending->gc_id)
                                ->max('sm_detailid') + 1;
    
                        d_stock_mutation::create([
                            'sm_stock' => $stock->s_id,
                            'sm_detailid' => $sm_detailid,
                            'sm_date' => Carbon::now(),
                            'sm_comp' => $gudTujuan->gc_id,
                            'sm_position' => $gc_sending->gc_id,
                            'sm_mutcat' => 9,
                            'sm_item' => $request->prdt_item[$i],
                            'sm_qty' => $request->prdt_qtyKirim[$i],
                            'sm_qty_used' => 0,
                            'sm_qty_sisa' => $request->prdt_qtyKirim[$i],
                            'sm_qty_expired' => 0,
                            'sm_detail' => 'PENAMBAHAN',
                            'sm_reff' => $nota_do,
                            'sm_insert' => Carbon::now()
                        ]);
                    }
    
                    $status = d_productresult_dt::where('prdt_productresult', $request->prdt_productresult[$i])
                        ->where('prdt_detail', $request->prdt_detail[$i])
                        ->first();
    
                    if ($status->prdt_qty == $status->prdt_kirim) {
                        $status->update([
                            'prdt_status' => 'FN'
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function orderId(Request $request)
    {
        $data = d_delivery_order::select('do_id')
            ->where('do_id', '=', $request->x)
            ->first();

        return view('Inventory::pengiriman.tabelItem', compact('data'));
    }

    public function itemTabelKirim($id)
    {
        $data = d_delivery_orderdt::where('dod_do', '=', $id)
            ->join('m_item', 'i_id', '=', 'dod_item')
            ->get();

        return DataTables::of($data)
            ->editColumn('dod_status', function ($inquiry) {
                if ($inquiry->dod_status == 'WT')
                    return 'Belum di Terima';
                if ($inquiry->dod_status == 'FN')
                    return 'Sudah di Terima';
            })
            ->addIndexColumn()
            ->make(true);
    }

}
