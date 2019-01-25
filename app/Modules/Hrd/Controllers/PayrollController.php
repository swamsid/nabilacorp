<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use Request;
use DB;
use DataTables;
use Illuminate\Support\Facades\Input;

class PayrollController extends Controller
{
    public function payrollData(){
        $list = DB::table('payroll_man')
                ->get();
        $data = collect($list);
        return Datatables::of($data)           
                ->addColumn('action', function ($data) {
                         return  '<button id="edit" onclick="editPro('.$data->c_id.')" class="btn btn-warning btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>'.'
                                        <button id="delete" onclick="view('.$data->c_id.')" class="btn btn-primary btn-sm" title="Hapus"><i class="fa fa-eye"></i></button>';
                })
                ->addColumn('status', function ($data) {
                    if($data->status == 1){
                        $status = '<span class="label label-info">Waiting</span>';
                    }else{
                        $status = '<span class="label label-success">Done</span>';
                    }
                    return  $status;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
    }
    public function pegawai($id){
        $list = DB::table('m_pegawai_man')
                ->select('m_pegawai_man.c_id', 'm_pegawai_man.c_nama', DB::raw('SUM(payroll_detail_man.c_jumlah) as gaji'), 'payroll_detail_man.c_payroll_id')
                ->leftJoin('payroll_detail_man', function($join)
                         {
                             $id = Request::segment(4);
                             $join->on('m_pegawai_man.c_id', '=', 'payroll_detail_man.c_pegawai_man_id');
                             $join->where('payroll_detail_man.c_payroll_id', $id);
                         })
                ->groupBy(DB::raw("m_pegawai_man.c_nama"))
                ->get();
        $list1 = DB::table('m_pegawai_man')
                ->select('m_pegawai_man.c_id', 'm_pegawai_man.c_nama', DB::raw('SUM(payroll_detail_pot.c_jumlah) as potongan'), 'payroll_detail_pot.c_payroll_id')
                ->leftJoin('payroll_detail_pot', function($join)
                         {
                             $id = Request::segment(4);
                             $join->on('m_pegawai_man.c_id', '=', 'payroll_detail_pot.c_pegawai_man_id');
                             $join->where('payroll_detail_pot.c_payroll_id', $id);
                         })
                ->groupBy(DB::raw("m_pegawai_man.c_nama"))
                ->get();
        $data = collect([$list, $list1]);
        $data2 = collect($list1);
        // dd($data2);
        return Datatables::of($data)           
                ->addColumn('action', function ($data) {
                    if($data[0]->gaji == null){
                        return  '<button onclick="bayar('.$data[0]->c_id.')" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button>';
                    }else{
                        return  '<button onclick="lihat('.$data[0]->c_id.')" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></button>';
                    }
                })
                ->addColumn('gaji', function ($data) {
                    if($data[0]->gaji == null){
                        $jum = '<div>Rp.
                        <span class="pull-right">
                          '.number_format( 0 ,2,',','.').'
                        </span>
                      </div>';
                    }else{
                        $jum = '<div>Rp.
                        <span class="pull-right">
                          '.number_format( $data[0]->gaji ,2,',','.').'
                        </span>
                      </div>';
                    }
                        return  $jum;
                })
                ->rawColumns(['action', 'jumlah', 'gaji', 'potongan'])
                ->make(true);
    }
    public function payroll(){
        return view('hrd/payroll/payroll');
    }
    public function viewPayroll($id){
        // dd(Request::segment(4));
        return view('hrd/payroll/view_payroll');
    }
    public function bayar($id, $peg){
        $pegawai = DB::table('m_pegawai_man')
                ->where('c_id', $peg)
                ->first();
        $jabatan = DB::table('m_jabatan')
                ->where('c_id', $pegawai->c_jabatan_id)
                ->first();
        $jab = $jabatan->c_sub_divisi_id;
        if($jab == 1){
            $select = 'c_leader AS gaji';
        }else{
            $select = 'c_staf AS gaji';
        }
        if($pegawai->c_pendidikan == "SMK"){
            $pegawai->c_pendidikan = "SMA";
        }
        $bayaran = DB::table('m_gaji_man')
                ->select('nm_gaji', 'c_id', 'is_harian', $select)
                ->where('c_jenjang', $pegawai->c_pendidikan)
                ->get();
        // dd($bayaran);
        $potongan = DB::table('m_potongan')->get();
        return view('hrd/payroll/tambah_payroll',['bayaran' => $bayaran, 'potongan' => $potongan]);
    }
    public function simpanDetail(Request $request){
        $input = Request::except('_token');
        // dd($input['c_payroll_id'][0]);
        $load = $input['c_payroll_id'][0];
        $count = count($input['c_payroll_id']);
        for($i = 0; $i < $count; $i++){
            // echo $i;
            $det['c_payroll_id'] = $input['c_payroll_id'][$i];
            $det['c_pegawai_man_id'] = $input['c_pegawai_man_id'][$i];
            $det['c_gaji_man_id'] = $input['c_gaji_man_id'][$i];
            $det['c_jumlah'] = $input['c_jumlah'][$i] * $input['c_keterangan'][$i];
            $det['c_keterangan'] = $input['c_keterangan'][$i];
            // print_r($in);
            DB::table('payroll_detail_man')->insert([$det]);
            
            // $pot['c_payroll_id'] = $input['c_payroll_id'][$i];
            // $pot['c_pegawai_man_id'] = $input['c_pegawai_man_id'][$i];
            // $pot['c_potongan_id'] = $input['c_potongan_id'][$i];
            // $pot['c_jumlah'] = $input['potongan'][$i];
            // // print_r($in);
            // DB::table('payroll_detail_pot')->insert([$pot]);
        }
        return redirect('hrd/payroll/view/'.$load);
    }
}
