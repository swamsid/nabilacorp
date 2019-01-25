<?php

namespace App\Modules\Master\Controllers;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use Datatables;
use URL;
use App\m_kpi;

// use App\mmember

class ScoreController extends Controller
{
    public function index()
    {
        $tab = view('Master::datascore.tab-index');
        return view('Master::datascore.index',compact('tab'));
    }

    public function tambah_score()
    {
        return view('Master::datascore.tambah');
    }

    public function get_datatable_index()
    {
        $data = m_kpi::join('m_pegawai_man', 'm_kpi.kpi_p_id', '=', 'm_pegawai_man.c_id')
                    ->join('m_divisi', 'm_kpi.kpi_div_id', '=', 'm_divisi.c_id')
                    ->join('m_jabatan', 'm_kpi.kpi_jabatan_id', '=', 'm_jabatan.c_id')
                    ->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($data) 
        {  
            return  '<button id="edit" onclick=edit("'.$data->kpi_id.'") class="btn btn-warning btn-sm" title="Edit">
                        <i class="fa fa-edit"></i>
                    </button>'.'
                    <button id="delete" onclick=hapus("'.$data->kpi_id.'") class="btn btn-danger btn-sm" title="Hapus">
                        <i class="fa fa-times-circle"></i>
                    </button>';
        })
        ->rawColumns(['action','opsi'])
        ->make(true);
    }

    public function lookup_jabatan(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $jabatan = DB::table('m_jabatan')->where('c_divisi_id', '=', $request->divisi)->orderBy('c_posisi', 'ASC')->limit(10)->get();
            foreach ($jabatan as $val) 
            {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_posisi];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $jabatan = DB::table('m_jabatan')->where('c_divisi_id', '=', $request->divisi)->where('c_posisi', 'LIKE', '%'.$term.'%')->orderBy('c_posisi', 'ASC')->limit(10)->get();
            foreach ($jabatan as $val) 
            {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_posisi];
            }

          return Response::json($formatted_tags);  
        }
    }

    public function lookup_pegawai(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $pegawai = DB::table('m_pegawai_man')->where('c_divisi_id', '=', $request->divisi)->where('c_jabatan_id', '=', $request->jabatan)->orderBy('c_nama', 'ASC')->limit(10)->get();
            foreach ($pegawai as $val) 
            {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_nama];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $pegawai = DB::table('m_sub_divisi')->where('c_divisi_id', '=', $request->divisi)->where('c_jabatan_id', '=', $request->jabatan)->where('c_nama', 'LIKE', '%'.$term.'%')->orderBy('c_nama', 'ASC')->limit(10)->get();
            foreach ($pegawai as $val) 
            {
            $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_nama];
            }

          return Response::json($formatted_tags);  
        }
    }

    public function simpan_score(Request $request)
    {
        DB::beginTransaction();
        try 
        {   
            $id = DB::table('m_kpi')->select('kpi_id')->max('kpi_id');
            if ($id == 0 || $id == '') { $id  = 1; } else { $id++; }

            $tanggal = date("Y-m-d h:i:s");
            $kpi = new m_kpi();
            $kpi->kpi_id = $id;
            $kpi->kpi_name = $request->nama_kpi;
            $kpi->kpi_p_id = $request->peg_kpi;
            $kpi->kpi_div_id = $request->div_kpi;
            $kpi->kpi_jabatan_id = $request->jbtn_kpi;
            $kpi->kpi_created = $tanggal;
            $kpi->save();

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master Scoreboard Berhasil Disimpan'
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

    public function edit_score(Request $request)
    {
        $data = m_kpi::join('m_pegawai_man', 'm_kpi.kpi_p_id', '=', 'm_pegawai_man.c_id')
                    ->join('m_divisi', 'm_kpi.kpi_div_id', '=', 'm_divisi.c_id')
                    ->join('m_jabatan', 'm_kpi.kpi_jabatan_id', '=', 'm_jabatan.c_id')
                    ->where('m_kpi.kpi_id', '=', $request->id)
                    ->first();
        return view('Master::datascore/edit', compact('data'));
    }

    public function update_score(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {   
            $tanggal = date("Y-m-d h:i:s");

            $kpi = m_kpi::find($request->kode_old);
            $kpi->kpi_name = $request->nama_kpi;
            $kpi->kpi_p_id = $request->peg_kpi;
            $kpi->kpi_div_id = $request->div_kpi;
            $kpi->kpi_jabatan_id = $request->jbtn_kpi;
            $kpi->kpi_updated = $tanggal;
            $kpi->save();

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master Scoreboard Berhasil Diupdate'
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

    public function delete_score(Request $request)
    {
        DB::beginTransaction();
        try 
        {   
            $kpi = m_kpi::find($request->id);
            $kpi->delete();

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master Scoreboard Berhasil Dihapus'
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

    function generateRandomString($length = 5) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    // ==================================================================================================================
}