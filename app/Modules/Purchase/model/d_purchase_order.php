<?php

namespace App\Modules\Purchase\model;

use Illuminate\Database\Eloquent\Model;

use App\Lib\format;

use App\m_item;

use DB;

use Auth;

use Datatables;

use Carbon\Carbon;

use Response;

use Session;

class d_purchase_order extends Model
{

    protected $table = 'd_purchase_order';
    protected $primaryKey = 'po_id';
    const CREATED_AT = 'po_created';
    const UPDATED_AT = 'po_updated';

      protected $fillable =  ['po_id',
                              'po_date',
                              'po_purchaseplan',
                              'po_supplier',
                              'po_code',
                              'po_mem',
                              'po_method',
                              'po_total_gross',
                              'po_discount',
                              'po_disc_percent',
                              'po_disc_value',
                              'po_tax_percent',
                              'po_tax_value',
                              'po_total_net',
                              'po_received',
                              'po_date_confirm',
                              'po_duedate',
                              'po_status',
                              'po_mpo',
                              'po_status',
                              'po_position',
                              'po_updated'];

    static function dataOrder($request)
    {
        $data = d_purchase_order::join('m_supplier','s_id','=','po_supplier')
                ->leftjoin('d_mem','po_mem','=','m_id')
                ->select(
                              'po_id',
                              'po_date',
                              'po_purchaseplan',
                              'po_supplier',
                              'po_code',
                              'po_mem',
                              'po_method',
                              'po_total_gross',
                              'po_discount',
                              'po_disc_percent',
                              'po_disc_value',
                              'po_tax_percent',
                              'po_tax_value',
                              'po_total_net',
                              'po_received',
                              'po_date_confirm',
                              'po_duedate',
                              'po_status',
                              'po_created',
                              'po_updated',
                              'm_id',
                              'm_name',
                              's_company'


                  )
                //->where('po_status', '=', 'FN')
                ->orderBy('po_date', 'DESC')
                ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('status', function ($data)
          {
          if ($data->po_status == "WT")
          {
            return '<span class="label label-default">Waiting</span>';
          }
          elseif ($data->po_status == "DE")
          {
            return '<span class="label label-warning">Dapat diedit</span>';
          }
          elseif ($data->po_status == "CF")
          {
            return '<span class="label label-info">Disetujui</span>';
          }
          else
          {
            return '<span class="label label-success">Selesai</span>';
          }
        })
        ->editColumn('tglOrder', function ($data)
        {
            if ($data->po_date == null)
            {
                return '-';
            }
            else
            {
                return $data->po_date ? with(new Carbon($data->po_date))->format('d M Y') : '';
            }
        })
        ->editColumn('hargaTotalNet', function ($data)
        {
          return 'Rp. '.number_format($data->po_total_net,0,",",".");
        })
        ->editColumn('tglMasuk', function ($data)
        {
          if ($data->po_date_received == null)
          {
              return '-';
          }
          else
          {
              return $data->po_date_received ? with(new Carbon($data->po_date_received))->format('d M Y') : '';
          }
        })
        ->addColumn('action', function($data)
          {
            if ($data->po_status == "WT")
            {
              return '<div class="text-center">
                          <button class="btn btn-sm btn-success" title="Detail"
                              onclick=detailOrder("'.$data->po_id.'")><i class="fa fa-eye"></i>
                          </button>
                          <button class="btn btn-sm btn-warning" title="Edit"
                              onclick=editOrder("'.$data->po_id.'")><i class="glyphicon glyphicon-edit"></i>
                          </button>
                          <button class="btn btn-sm btn-danger" title="Delete"
                              onclick=deleteOrder("'.$data->po_id.'")><i class="glyphicon glyphicon-trash"></i>
                          </button>
                      </div>';
            }
            elseif ($data->po_status == "DE")
            {
              return '<div class="text-center">
                          <button class="btn btn-sm btn-success" title="Detail"
                              onclick=detailOrder("'.$data->po_id.'")><i class="fa fa-eye"></i>
                          </button>
                          <button class="btn btn-sm btn-warning" title="Edit"
                              onclick=editOrder("'.$data->po_id.'")><i class="glyphicon glyphicon-edit"></i>
                          </button>
                          <button class="btn btn-sm btn-danger" title="Delete"
                              onclick=deleteOrder("'.$data->po_id.'") disabled><i class="glyphicon glyphicon-trash"></i>
                          </button>
                      </div>';
            }
            else
            {
              return '<div class="text-center">
                          <button class="btn btn-sm btn-success" title="Detail"
                              onclick=detailOrder("'.$data->po_id.'")><i class="fa fa-eye"></i>
                          </button>
                          <button class="btn btn-sm btn-warning" title="Edit"
                              onclick=editOrder("'.$data->po_id.'") disabled><i class="glyphicon glyphicon-edit"></i>
                          </button>
                          <button class="btn btn-sm btn-danger" title="Delete"
                              onclick=deleteOrder("'.$data->po_id.'") disabled><i class="glyphicon glyphicon-trash"></i>
                          </button>
                      </div>';
            }

          })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }



     static function getDataForm($id)
    {
          $gudang = d_purchase_plan::where('p_id',$id)->first();
          $dataIsi = d_purchaseplan_dt::
                                join('d_purchase_plan','ppdt_pruchaseplan','=','p_id')
                                ->join('m_item','ppdt_item','=','i_id')
                                ->leftjoin('d_item_supplier','is_item','=','i_id')
                                ->leftjoin('m_price','m_pitem','=','i_id')
                                ->join('m_satuan', 's_id', '=', 'ppdt_satuan')
                                ->leftjoin('d_stock','s_item','=','i_id')
                                ->select('i_id',
                                         'm_item.i_code',
                                         'm_item.i_name',
                                         'ppdt_totalcost',
                                         's_name',
                                         'ppdt_qty',
                                         'ppdt_qtyconfirm',
                                         'ppdt_prevcost',
                                         's_qty',
                                         'ppdt_pruchaseplan',
                                         'ppdt_detailid',
                                         'p_comp',
                                         'ppdt_satuan_position as satuan_position',
                                         'ppdt_satuan as satuan',
                                         'i_sat1',
                                         'i_sat2',
                                         'i_sat3',
                                         'p_gudang',
                                         'is_price1',
                                         'is_price2',
                                         'is_price3',
                                         'm_pbuy1',
                                         'm_pbuy2',
                                         'm_pbuy3'
                                )
                                ->where('ppdt_pruchaseplan', '=', $id)
                                ->where('p_comp',$gudang->p_comp)
                                ->where('p_gudang',$gudang->p_gudang)
                                ->where('ppdt_ispo', '=', "FALSE")
                                ->where('ppdt_isconfirm', '=', "TRUE")
                                ->orderBy('ppdt_detailid', 'ASC')
                                ->get();
            // $prev_harga = [];
            $harga = [];

            for ($i=0; $i <count($dataIsi) ; $i++) {
              // $prev_harga = '';
                $prev_harga[$i] = DB::table('d_item_supplier')
                                ->where('is_item',$dataIsi[$i]->i_id)
                                ->get();

                if ($dataIsi[$i]->satuan_position == 1) {
                  if ($dataIsi[$i]->is_price1 != null) {
                      $harga[$i] = $dataIsi[$i]->is_price1;
                  }else{
                      $harga[$i] = 0;
                  }
                }elseif ($dataIsi[$i]->satuan_position == 2) {
                  if ($dataIsi[$i]->is_price2 != null) {
                      $harga[$i] = $dataIsi[$i]->is_price2;
                  }else{
                      $harga[$i] = 0;
                  }
                }elseif ($dataIsi[$i]->satuan_position == 3) {
                  if ($dataIsi[$i]->is_price3 != null) {
                      $harga[$i] = $dataIsi[$i]->is_price3;
                  }else{
                      $harga[$i] = 0;
                  }
                }
            }

            // return [$prev_harga,$dataIsi];
            // return $harga;


        return response()->json([
            'status' => 'sukses',
            'data_isi' => $dataIsi,
            'data_prev' => $harga,
        ]);
    }


     static function getDataCodePlan($request)
    {
      
        $formatted_tags = array();
        $term = $request->term;

        if (empty($term)) {
            $sup = DB::table('d_purchase_plan')
                     ->select('p_code', 'p_id','s_id','s_company','p_comp','p_position','p_gudang')
                     ->join('d_purchaseplan_dt','ppdt_pruchaseplan','=','p_id')
                     ->join('m_supplier','s_id','=','p_supplier')
                     ->where('ppdt_isconfirm', '=', "TRUE")
                     ->where('ppdt_ispo', '=', "FALSE")
                     ->where('p_comp', '=', Session::get('user_comp'))
                     ->groupBy('p_code','p_id','s_id','s_company')
                     ->get();
            foreach ($sup as $val) {
                $formatted_tags[] = ['p_id' => $val->p_id, 'label' => $val->p_code,'s_company'=>$val->s_company,'s_id'=>$val->s_id];
            }
            return Response::json($formatted_tags);
        }
        else
        {
          // return 'a';
            $sup = DB::table('d_purchase_plan')
                    
                     ->select('p_code', 'p_id','s_id','s_company','p_comp','p_position','p_gudang')
                     ->join('d_purchaseplan_dt','ppdt_pruchaseplan','=','p_id')
                     ->join('m_supplier','s_id','=','p_supplier')
                     ->where('ppdt_isconfirm', '=', "TRUE")
                     ->where('ppdt_ispo', '=', "FALSE")
                     ->where('p_status', '=', "WT")
                     ->where('p_code', 'LIKE', '%'.$term.'%')
                     ->where('p_comp', '=', Session::get('user_comp'))
                     ->groupBy('p_code','p_id','s_id','s_company')
                     ->get();
            // return $sup;
            foreach ($sup as $val) {
                $formatted_tags[] = ['p_id' => $val->p_id, 'label' => $val->p_code,'s_company'=>$val->s_company,'s_id'=>$val->s_id,'p_comp'=>$val->p_comp,'p_position'=>$val->p_position,'p_gudang'=>$val->p_gudang];
            }
            return Response::json($formatted_tags);
        }
    }

    public function konvertRp($value)
    {
      $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
      return (int)str_replace(',', '.', $value);
    }

    static function savePo($request)
     {
      // dd($request->all());
      // DB::beginTransaction();
      // try {
      $totalGross = str_replace(['Rp', '\\', '.', ' '], '', $request->totalGross);
      // $totalGross = $this->konvertRp();
      $discValue = (int)str_replace("%","",$request->diskonHarga);
      $replaceCharPPN = (int)str_replace("%","",$request->ppnHarga);
      // $diskonPotHarga = $this->konvertRp($request->potonganHarga);
      $prev_harga = str_replace(['Rp', '\\', '.', ' '], '', $request->prev_harga);
      $diskonPotHarga = str_replace(['Rp', '\\', '.', ' '], '', $request->potonganHarga);
      $diskonPotHarga = str_replace(',', '.', $diskonPotHarga);
      // $discValue = $totalGross * $replaceCharDisc / 100;

      $p_id=d_purchase_order::max('po_id')+1;

      $query = DB::select(DB::raw("SELECT MAX(RIGHT(po_code,4)) as kode_max from d_purchase_order WHERE DATE_FORMAT(po_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));

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

      $p_code = "PO-".date('ym')."-".$kd;

      $dataHeader = new d_purchase_order;
      $dataHeader->po_id = $p_id;
      $dataHeader->po_date = date('Y-m-d',strtotime($request->tanggal));
      $dataHeader->po_purchaseplan = $request->cariKodePlan;
      $dataHeader->po_supplier = $request->supplier;
      $dataHeader->po_code = $p_code;
      $dataHeader->po_mem = $request->idStaff;
      $dataHeader->po_method = $request->methodBayar;
      $dataHeader->po_total_gross = $totalGross;
      // $dataHeader->po_discount = $diskonPotHarg;
      // $dataHeader->po_disc_percent = $replaceCharDisc;
      $dataHeader->po_disc_value = $discValue;
      $dataHeader->po_tax_percent = $replaceCharPPN;
      
      $dataHeader->po_tax_value = ($totalGross - $diskonPotHarga - $discValue) * ($replaceCharPPN / 100);
      $dataHeader->po_total_net = str_replace(['Rp', '\\', '.', ' '], '', $request->totalNett_after_disc);
      $dataHeader->po_total_gross = str_replace(['Rp', '\\', '.', ' '], '', $request->totalGross);
      // $dataHeader->po_received = str_replace(['Rp', '\\', '.', ' '], '', $request->totalNett);
      $dataHeader->po_date_confirm = date('Y-m-d',strtotime($request->tanggal));
      $dataHeader->po_duedate = date('Y-m-d',strtotime($request->tanggal));
      $dataHeader->po_status = 'WT';
      $dataHeader->po_created = date('Y-m-d h:i:s');
      $dataHeader->po_updated =  date('Y-m-d h:i:s');
      $dataHeader->po_comp = $request->p_comp;
      $dataHeader->po_position = $request->p_position;
      // $dataHeader->po_gudang = $request->p_gudang;
      $dataHeader->save();

      $update_plan = DB::table('d_purchase_plan')->update(['p_status_date'=>date('Y-m-d')]); 

      for ($i=0; $i <count($request->fieldNamaItem) ; $i++) {
        $dataDetail = new d_purchaseorder_dt;
        $dataDetail->podt_purchaseorder = $p_id;
        $dataDetail->podt_detailid = $i+1;
        $dataDetail->podt_satuan = $request->fieldSatuan[$i];
        $dataDetail->podt_item = $request->podt_item[$i];
        $dataDetail->podt_purchaseplandt = $request->podt_purchaseorder[$i];
        $dataDetail->podt_qty = $request->fieldQty[$i];
        $dataDetail->podt_qtysend = $request->fieldQtyconfirm[$i];
        $dataDetail->podt_qtyconfirm = $request->fieldQtyconfirm[$i];
        $dataDetail->podt_disc =  str_replace(['Rp', '\\', '.', ' '], '', $request->podt_disc_detail[$i]);
        $dataDetail->podt_prevcost = str_replace(['Rp', '\\', '.', ' '], '', $request->podt_prevprice[$i]);
        $dataDetail->podt_price = str_replace(['Rp', '\\', '.', ' '], '', $request->podt_price[$i]);
        $dataDetail->podt_total = str_replace(['Rp', '\\', '.', ' '], '', $request->podt_total[$i]);
        $dataDetail->podt_gross = $request->podt_total_net[$i];
        $dataDetail->podt_isconfirm = 'TRUE';
        $dataDetail->podt_created = date('Y-m-d h:i:s');
        $dataDetail->podt_updated = date('Y-m-d h:i:s');
        $dataDetail->save();

        $dataBrg = DB::table('m_item')->where('i_id',$request->podt_item[$i])->update([
          'i_price'=> str_replace('.', '', $request->podt_prevprice[$i]),
        ]);



        $update = DB::table('d_purchase_plan')->where('p_id',$request->cariKodePlan)->update([
            'p_status'=>'FN',
        ]);


      }
      // DB::commit();
    return response()->json([
          'status' => 'sukses',
      ]);
    // } catch (\Exception $e) {
    // DB::rollback();
    // return response()->json([
    //     'status' => 'gagal',
    //     'data' => $e
    //   ]);
    // }



     }

     

     




}
