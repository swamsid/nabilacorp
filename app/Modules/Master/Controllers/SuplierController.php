<?php

namespace App\Modules\Master\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Suplier;
use Datatables;
use Session;

use App\m_supplier;

class SuplierController extends Controller
{

  public function __construct()
    {
        $this->middleware('auth');
    }

    public function suplier()
    {
        return view('Master::datasuplier/suplier');
    }

    public function tambah_suplier()
    {
      return view('Master::datasuplier/tambah_suplier');
    }

    public function suplier_proses(Request $request)
    {        
        // dd($request->all());
        DB::beginTransaction();
        try 
        {   
          $tglTop = $request->tglTop;

          $m1 = DB::table('m_supplier')->max('s_id');
          $index = $m1+=1;
          $tanggal = date("Y-m-d h:i:s");

          DB::table('m_supplier')
            ->insert([
                's_id'=>$index,
                's_company'=>$request->namaSup,
                's_name' => $request->owner,
                's_npwp'=> $request->npwpSup,
                's_address'=> $request->alamat,
                's_phone1'=>$request->noTelp1,
                's_phone2'=> $request->noTelp2,
                's_rekening'=> $request->rekening,
                's_bank'=> $request->methodBayar,
                's_fax'=>$request->fax,
                's_note'=> $request->keterangan,
                's_top'=> $tglTop,
                's_limit'=>str_replace(',', '', $request->limit),
                's_insert'=>$tanggal
            ]);
        
            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master Supplier Berhasil Disimpan'
            ]);
        } 
        catch (\Exception $e) 
        {
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
          ]);
        }
    }

    public function datatable_suplier()
    {
      $data= DB::table('m_supplier')->get();
      $xyzab = collect($data);

      return Datatables::of($xyzab)
      ->addIndexColumn()
      ->editColumn('telp', function ($xyzab) {
        if ($xyzab->s_phone2 != null) 
        {
          return $xyzab->s_phone1.' | '.$xyzab->s_phone2;
        }else 
        {
          return $xyzab->s_phone1;
        }
      })
      ->editColumn('tglTop', function ($xyzab) 
      {
        if ($xyzab->s_top == null) 
        {
          return '-';
        }
        else 
        {
          return date("d-m-Y", strtotime($xyzab->s_top));
        }
      })
      ->addColumn('aksi', function ($xyzab) {
        if ($xyzab->s_active == 'Y') {
          return  '<div class="text-center">'.
                    '<a href="suplier_edit/'.$xyzab->s_id.'" 
                        class="btn btn-warning btn-sm" 
                        title="edit">'.
                        '<label class="fa fa-pencil"></label>
                    </a>'.'
                    <a href="#" 
                        onclick=ubahStatus("'.$xyzab->s_id.'") 
                        class="btn btn-primary btn-sm" 
                        title="Aktif">'.
                        '<label class="fa fa-check-square"></label>
                    </a>'.
                  '</div>';
        }else{
          return  '<div class="text-center">'.
                   '<a href="#" onclick=ubahStatus("'.$xyzab->s_id.'") class="btn btn-danger btn-sm" title="Tidak Aktif">'.
                   '<label class="fa fa-minus-square"></label></a>'.
                  '</div>';
        }
      })

      ->rawColumns(['aksi', 'limit', 'hutang'])
      ->make(true);
    }

    public function suplier_edit($s_id)
    {   
      $edit_suplier = DB::table("m_supplier")->where("s_id", $s_id)->first();
      // return json_encode($edit_suplier); 
      json_encode($edit_suplier);
      return view('Master::datasuplier/edit_suplier', ['edit_suplier' => $edit_suplier] , compact('edit_suplier', 's_id'));
    }

    public function suplier_edit_proses(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        { 
          if ($request->tglTop != "") {
            $tglTop = date('Y-m-d',strtotime($request->tglTop));
          }else{
            $tglTop = null;
          }
          

          $tanggal = date("Y-m-d h:i:s");

          DB::table('m_supplier')
            ->where('s_id',$request->get('s_idx'))
            ->update([
                's_company'=>strtoupper($request->perusahaan),
                's_name' => strtoupper($request->nama),
                's_npwp'=> $request->npwpSup,
                's_address'=> strtoupper($request->alamat),
                's_phone1'=>$request->noHp1,
                's_phone2'=> $request->noHp2,
                's_rekening'=> $request->rekening,
                's_bank'=> $request->methodBayar,
                's_fax'=>$request->email,
                's_note'=> strtoupper($request->keterangan),
                's_top'=> $tglTop,
                's_limit'=>str_replace(',', '', $request->limit),
                's_update'=>$tanggal
            ]);
        
            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master Supplier Berhasil Diupdate'
            ]);
        } 
        catch (\Exception $e) 
        {
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
          ]);
        }  
    }

    public function suplier_hapus(Request $request)
    {
      $type = DB::Table('m_supplier')->where('s_id','=',$request->id)->delete();
      return response()->json([
                'status' => 'sukses',
                'pesan' => 'Data Suppler Berhasil Dihapus'
            ]);
    } 

    public function find_m_suplier(Request $req) {
      // Keyword yang diberikan oleh user
      $keyword = $req->keyword;  
      $keyword = $keyword != null ? $keyword : '';

      if($keyword == '') {
          $data = new m_supplier();
      }
      else {
          $data = m_supplier::where('s_company', 'LIKE', "%$keyword%");
      }

      $data = $data->select('s_id', 's_company', 's_name', 's_npwp', 's_address', 's_phone', 's_phone1', 's_phone2', 's_rekening', 's_bank', 's_fax', 's_note', 's_top', 's_deposit', 's_limit', 's_hutang', DB::raw('s_id AS id'), DB::raw('s_company AS text'))->get();
      $res = array('data' => $data);

      return response()->json($res);
    }

    public function ubahStatus(Request $request)
    {
      $type = DB::Table('m_supplier')->where('s_id','=',$request->id)
        ->first();
      // dd($type->s_active);
      if ($type->s_active == 'Y') {
        DB::Table('m_supplier')->where('s_id','=',$request->id)->update([
          's_active' => 'N'
        ]);
      }else{
        DB::Table('m_supplier')->where('s_id','=',$request->id)->update([
          's_active' => 'Y'
        ]);
      }
      return response()->json([
                'status' => 'sukses',
                'pesan' => 'Data Suppler Berhasil Dihapus'
            ]);
    } 
 
}
