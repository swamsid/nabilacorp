<?php

namespace App\Modules\Purchase\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;

use App\m_item;

use App\Http\Controllers\Controller;

use App\mMember;
use App\Modules\Purchase\model\d_purchase_plan;
use App\Modules\Purchase\model\d_purchase_order;
use App\Modules\Purchase\model\d_purchaseorder_dt;
use App\d_purchasing;
use Datatables;

class purchaseConfirmController extends Controller
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


   public function seachItemPurchase(Request $request){
         return   m_item::seachItemPurchase($request);
   }
   public function storePlan(Request $request){
      d_purchase_plan::simpan($request);

   }
   public function confirmIndex(){
     $tbh =view('Purchase::konfirmasipembelian/tab-belanjaharian');
     $td =view('Purchase::konfirmasipembelian/tab-daftar');
     $to =view('Purchase::konfirmasipembelian/tab-order');
     $tr =view('Purchase::konfirmasipembelian/tab-return');

     $mcb =view('Purchase::konfirmasipembelian/modal-confirm-belanjaharian');
     $mco =view('Purchase::konfirmasipembelian/modal-confirm-order');
     $mcr =view('Purchase::konfirmasipembelian/modal-confirm-return');
     $mc =view('Purchase::konfirmasipembelian/modal-confirm');

     return view('Purchase::konfirmasipembelian/index',compact('tbh','td','to','tr','mcb','mco','mcr','mc'));
   }
public function getDataRencanaPembelian(Request $request)
  {
    $data = d_purchase_plan::join('m_supplier','d_purchase_plan.p_supplier','=','m_supplier.s_id')
              ->join('d_mem','d_purchase_plan.p_mem','=','d_mem.m_id')
            // ->select('d_pcsp_id','d_pcsp_code','d_pcsp_code','s_company','d_pcsp_status','d_pcsp_datecreated','d_pcsp_dateconfirm', 'd_mem.m_id', 'd_mem.m_name')
            // ->orderBy('d_pcsp_datecreated', 'DESC')
            ->get();
    // return $data;
    return DataTables::of($data)
    ->addIndexColumn()
    ->editColumn('status', function ($data)
      {
      if ($data->p_status == "WT")
      {
        return '<span class="label label-info">Waiting</span>';
      }
      elseif ($data->p_status == "DE")
      {
        return '<span class="label label-warning">Dapat diedit</span>';
      }
      elseif ($data->p_status == "CF")
      {
        return '<span class="label label-success">Finish</span>';
      }
    })
    ->editColumn('tglBuat', function ($data)
    {
        if ($data->p_date == null)
        {
            return '-';
        }
        else
        {
            return $data->p_date ? with(new Carbon($data->p_date))->format('d M Y') : '';
        }
    })
    ->editColumn('tglConfirm', function ($data)
    {
        if ($data->p_confirm == null)
        {
            return '-';
        }
        else
        {
            return $data->p_confirm ? with(new Carbon($data->p_confirm))->format('d M Y') : '';
        }
    })
    ->addColumn('action', function($data)
      {
        if ($data->p_status == "WT")
        {
            return '<div class="text-center">
                      <button class="btn btn-sm btn-primary" title="Ubah Status"
                          onclick=konfirmasiPlanAll("'.$data->p_id.'")><i class="fa fa-check"></i>
                      </button>
                  </div>';
        }
        else
        {
            return ' ';
        }
      })
    ->rawColumns(['status', 'action'])
    ->make(true);
  }


   public function confirmRencanaPembelian($id,$type){
      return d_purchase_plan::confirmRencanaPembelian($id,$type);
   }

   public function konfirmasiPurchasePlan(Request $request){
   /*dd($request->all());   */
      return d_purchase_plan::konfirmasiPurchasePlan($request);
   }

   public function konfirmasiOrder(Request $request,$id,$type){
   // dd($request->all());
   $dataHeader = d_purchase_order::join('m_supplier','po_supplier','=','s_id')
                            ->leftjoin('d_mem','po_mem','=','m_id')
                            ->select(
                                'po_id',
                                'po_code',
                                's_company',
                                'po_date',
                                'po_status',
                                DB::raw('IFNULL(po_date_confirm, "") AS p_confirm'),
                                DB::raw('IFNULL(m_id, "") AS m_id'),
                                DB::raw('IFNULL(m_name, "") AS m_name'))
                            ->where('po_id', '=', $id)
                            ->orderBy('po_date', 'DESC')
                            ->get();
    return $statusLabel = $dataHeader[0]->p_status;
    $dataHeader[0]->p_date=date('d-m-Y',strtotime($dataHeader[0]->p_date));
    if ($statusLabel == "WT")
    {
        $spanTxt = 'Waiting';
        $spanClass = 'label-info';
    }
    elseif ($statusLabel == "DE")
    {
        $spanTxt = 'Dapat Diedit';
        $spanClass = 'label-warning';
    }
    elseif ($statusLabel == 'CF')
    {
        $spanTxt = 'Di setujui';
        $spanClass = 'label-success';
    }
    if ($type == "all")
    {

      $dataIsi = d_purchaseorder_dt::join('m_item','ppdt_item','=','i_id')
                                ->join('m_satuan', 's_id', '=', 'i_satuan')
                                ->leftjoin('d_stock','s_item','=','i_id')
                                ->select('i_id',
                                         'm_item.i_code',
                                         'm_item.i_name',
                                         's_name',
                                         'podt_qty',
                                         'podt_qtyconfirm',
                                         DB::raw('IFNULL(s_qty, 0) AS s_qty'),
                                         'podt_prevcost',
                                         'podt_pruchaseplan',
                                          'o4pdt_detailid'
                                )
                                ->where('ppdt_pruchaseplan', '=', $id)
                                ->orderBy('ppdt_created', 'DESC')
                                ->get();

    }
    else
    {

       $dataIsi = d_purchaseorder_dt::join('m_item','ppdt_item','=','i_id')
                                ->join('m_satuan', 's_id', '=', 'i_satuan')
                                ->leftjoin('d_stock','s_item','=','i_id')
                                ->select('i_id',
                                         'm_item.i_code',
                                         'm_item.i_name',
                                         's_name',
                                         'podt_qty',
                                         'podt_qtyconfirm',
                                         's_qty',
                                         'podt_prevcost',
                                         'podt_pruchaseplan',
                                         'po4dt_detailid'
                                )
                                ->where('ppdt_pruchaseplan', '=', $id)
                                ->where('ppdt_isconfirm', '=', "TRUE")
                                ->orderBy('ppdt_created', 'DESC')
                                ->get();


    }

    return Response()->json([
        'status' => 'sukses',
        'header' => $dataHeader,
        'data_isi' => $dataIsi,
        'spanTxt' => $spanTxt,
        'spanClass' => $spanClass,
    ]);
      // return d_purchase_plan::konfirmasiOrder($request);
   }
   public function getdatatableOrder()
   {
      // return 'a';
     $data = d_purchase_order::join('m_supplier','d_purchase_order.po_supplier','=','m_supplier.s_id')
              ->join('d_mem','d_purchase_order.po_mem','=','d_mem.m_id')
            // ->select('d_pcsp_id','d_pcsp_code','d_pcsp_code','s_company','d_pcsp_status','d_pcsp_datecreated','d_pcsp_dateconfirm', 'd_mem.m_id', 'd_mem.m_name')
            // ->orderBy('d_pcsp_datecreated', 'DESC')
            ->get();
    // return $data;
    return DataTables::of($data)
    ->addIndexColumn()
    ->editColumn('status', function ($data){
      if ($data->po_status == "WT")
      {
        return '<span class="label label-info">Waiting</span>';
      }
      elseif ($data->po_status == "DE")
      {
        return '<span class="label label-warning">Dapat diedit</span>';
      }
      elseif ($data->po_status == "CF")
      {
        return '<span class="label label-success">Finish</span>';
      }
    })
    ->editColumn('tglBuat', function ($data)
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
    ->editColumn('tglConfirm', function ($data)
    {
        if ($data->po_date_confirm == null)
        {
            return '-';
        }
        else
        {
            return $data->po_date_confirm ? with(new Carbon($data->po_date_confirm))->format('d M Y') : '';
        }
    })
    ->addColumn('action', function($data)
      {
        if ($data->po_status == "WT")
        {
            return '<div class="text-center">
                      <button class="btn btn-sm btn-primary" title="Ubah Status"
                          onclick=konfirmasiOrder("'.$data->po_id.'")><i class="fa fa-check"></i>
                      </button>
                  </div>';
        }
        else
        {
            return ' ';
        }
      })
    ->rawColumns(['status', 'action'])
    ->make(true);
   }



   public function formPlan()
    {
         return view('Purchase::rencanapembelian/create');
    }

    public function rencana()
    {
        return view('/purchasing/rencanapembelian/rencana');
    }

    public function belanja()
    {
        return view('/purchasing/belanjaharian/belanja');
    }

    public function tambah_belanja()
    {
        return view('/purchasing/belanjaharian/tambah_belanja');
    }

    public function pembelian()
    {
        return view('/purchasing/returnpembelian/pembelian');
    }

    public function suplier()
    {
        return view('/purchasing/belanjasuplier/suplier');
    }

    public function langsung()
    {
        return view('/purchasing/belanjalangsung/langsung');
    }

    public function produk()
    {
        return view('/purchasing/belanjaproduk/produk');
    }
    public function pasar()
    {
        return view('/purchasing/belanjapasar/pasar');
    }
    public function create()
    {
        return view('Purchase::rencanapembelian/create');
    }
    public function tambah_pembelian()
    {
        return view('/purchasing/returnpembelian/tambah_pembelian');
    }
    public function tambah_order()
    {

    }
    public function bahan()
    {
        return view('/purchasing/rencanabahanbaku/bahan');
    }

  public function confirmOrderPembelian($id,$type)
  {
    // return 'a';
    // dd($request->all());

    $dataHeader = d_purchase_order::join('m_supplier','d_purchase_order.po_supplier','=','m_supplier.s_id')
                ->join('d_mem','d_purchase_order.po_mem','=','d_mem.m_id')
                ->select('po_created','s_company','po_id','po_code', 'po_duedate','d_mem.m_name','d_mem.m_id','po_status')
                ->where('po_id', '=', $id)
                // ->orderBy('d_pcs_date_created', 'DESC')
                ->get();
    // return $dataHeader;

    $statusLabel = $dataHeader[0]->po_status;
    if ($statusLabel == "WT")
    {
        $spanTxt = 'Waiting';
        $spanClass = 'label-info';
    }
    elseif ($statusLabel == "DE")
    {
        $spanTxt = 'Dapat Diedit';
        $spanClass = 'label-warning';
    }
    elseif ($statusLabel == "CF")
    {
        $spanTxt = 'Di setujui';
        $spanClass = 'label-success';
    }

    if ($type == "all")
    {
      $dataIsi = d_purchaseorder_dt::join('m_item', 'd_purchaseorder_dt.i_id', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_purchaseorder_dt.d_pcsdt_sat', '=', 'm_satuan.m_sid')
                ->select('d_purchaseorder_dt.*', 'm_item.*', 'm_satuan.*')
                ->where('d_purchaseorder_dt.d_pcs_id', '=', $id)
                ->orderBy('d_purchaseorder_dt.d_pcsdt_created', 'DESC')
                ->get();
    }
    else
    {
      $dataIsi = d_purchaseorder_dt::join('m_item', 'd_purchaseorder_dt.podt_item', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_purchaseorder_dt.podt_satuan', '=', 'm_satuan.s_id')
                ->select('d_purchaseorder_dt.*', 'm_item.*','m_satuan.*')
                ->where('podt_purchaseorder',$id)
                // ->where('d_purchase_order.d_pcsdt_isconfirm', '=', "TRUE")
                // ->orderBy('d_purchase_order.d_pcsdt_created', 'DESC')
                ->get();
    }
    // return $dataIsi;
    foreach ($dataIsi as $val)
    {
      //cek item type
      $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
      //get satuan utama
      $sat1[] = $val->i_sat1;
    }
    // return $sat1;
    // return $itemType;
    for ($i=0; $i <count($itemType) ; $i++) {
       $dataStok = DB::table('d_stock')->where('s_item',$itemType[$i]->i_id)->get();
    }
    // return $dataStok;
    //variabel untuk count array
    $counter = 0;
    //ambil value stok by item type
    // $dataStok = $this->getStokByType($itemType, $sat1, $counter);
    // return
    return Response()->json([
        'status' => 'sukses',
        'header' => $dataHeader,
        'data_isi' => $dataIsi,
        // 'data_stok' => $dataStok['val_stok'],
        // 'data_satuan' => $dataStok['txt_satuan'],
        'spanTxt' => $spanTxt,
        'spanClass' => $spanClass,
    ]);
  }

  public function confirmOrderSubmit(Request $request)
  {

// dd($request->all());
    if ($request->statusOrderConfirm == 'CF') {
        $dataHeader = DB::table('d_purchase_order')->where('po_id',$request->idOrder)->update([
          'po_status'=>'CF'
        ]);

        for ($i=0; $i <count($request->fieldConfirmOrder) ; $i++) {
          $dataisi = DB::table('d_purchaseorder_dt')->where('podt_purchaseorder',$request->idOrder)->where('podt_detailid',$request->fieldIdDtOrder[$i])->update([
            'podt_qtyconfirm'=>$request->fieldConfirmOrder[$i]
          ]);
        }
    }else{
      // return 'ini belum ';
    }

    return response()->json(['status'=>'sukses']);


  }

}
 /*<button class="btn btn-outlined btn-info btn-sm" type="button" data-target="#detail" data-toggle="modal">Detail</button>*/
