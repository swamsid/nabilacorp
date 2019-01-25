<?php

namespace App\Http\Controllers\modul_keuangan\laporan\laba_rugi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Export\excel\exporter as exporter;
use App\Model\modul_keuangan\dk_akun_group_subclass as subclass;

use DB;
use Excel;
use PDF;

class laporan_laba_rugi_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.laporan.laba_rugi.index');
    }

    public function dataResource(Request $request){
        
        $d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';

        $kelompok = DB::table('dk_akun as a')
        				->join('dk_akun as b', 'a.ak_kelompok', '=', 'b.ak_id')
        				->where('a.ak_type', 'detail')
        				->distinct('a.ak_kelompok')
        				->select('a.ak_kelompok', 'b.ak_nama')
        				->groupBy('a.ak_kelompok', 'b.ak_nama')
        				->get();


        $res = subclass::where('gs_type', 'LR')
        				->with([
    						'group' => function($query) use ($d1){
    							$query->select('ag_id', 'ag_subclass', 'ag_nama', 'ag_kelompok')
    									->with([
											'lr' => function($query) use ($d1){
												$query->select(DB::raw('distinct(ak_kelompok)'), 'ak_group_lr')
														->with([
															'fromKelompok' => function($query) use ($d1){
																$query->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
																		->where('as_periode', $d1)
																		->select(
																			'ak_id',
																			'ak_kelompok',
																			'ak_nama',
																			'ak_posisi',
																			DB::raw('coalesce(sum(as_saldo_awal), 2) as saldo_awal'),
																			DB::raw('coalesce(sum(as_mut_kas_debet), 2) as kas_debet'),
																			DB::raw('coalesce(sum(as_mut_kas_kredit), 2) as kas_kredit'),
																			DB::raw('coalesce(sum(as_mut_bank_debet), 2) as bank_debet'),
																			DB::raw('coalesce(sum(as_mut_bank_kredit), 2) as bank_kredit'),
																			DB::raw('coalesce(sum(as_mut_memorial_debet), 2) as memorial_debet'),
																			DB::raw('coalesce(sum(as_mut_memorial_kredit), 2) as memorial_kredit')
																)
																->groupBy('ak_id', 'ak_kelompok', 'ak_nama', 'ak_posisi');
															}
														])
														->groupBy('ak_kelompok', 'ak_group_lr');
											}
    									])
    									->where('ag_isactive', '1');
    						}
        				])
        				->where('gs_status', '1')
        				->select('gs_id', 'gs_nama', 'gs_kelompok')
        				->get();

        // return json_encode($res);

    	return json_encode([
    		"data"	        => $res,
    		"kelompok"		=> $kelompok
    	]);
    }

    public function print(Request $request){
        $d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';

        $kelompok = DB::table('dk_akun as a')
        				->join('dk_akun as b', 'a.ak_kelompok', '=', 'b.ak_id')
        				->where('a.ak_type', 'detail')
        				->distinct('a.ak_kelompok')
        				->select('a.ak_kelompok', 'b.ak_nama')
        				->groupBy('a.ak_kelompok', 'b.ak_nama')
        				->get();


        $res = subclass::where('gs_type', 'LR')
        				->with([
    						'group' => function($query) use ($d1){
    							$query->select('ag_id', 'ag_subclass', 'ag_nama', 'ag_kelompok')
    									->with([
											'lr' => function($query) use ($d1){
												$query->select(DB::raw('distinct(ak_kelompok)'), 'ak_group_lr')
														->with([
															'fromKelompok' => function($query) use ($d1){
																$query->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
																		->where('as_periode', $d1)
																		->select(
																			'ak_id',
																			'ak_kelompok',
																			'ak_nama',
																			'ak_posisi',
																			DB::raw('coalesce(sum(as_saldo_awal), 2) as saldo_awal'),
																			DB::raw('coalesce(sum(as_mut_kas_debet), 2) as kas_debet'),
																			DB::raw('coalesce(sum(as_mut_kas_kredit), 2) as kas_kredit'),
																			DB::raw('coalesce(sum(as_mut_bank_debet), 2) as bank_debet'),
																			DB::raw('coalesce(sum(as_mut_bank_kredit), 2) as bank_kredit'),
																			DB::raw('coalesce(sum(as_mut_memorial_debet), 2) as memorial_debet'),
																			DB::raw('coalesce(sum(as_mut_memorial_kredit), 2) as memorial_kredit')
																)
																->groupBy('ak_id', 'ak_kelompok', 'ak_nama', 'ak_posisi');
															}
														])
														->groupBy('ak_kelompok', 'ak_group_lr');
											}
    									])
    									->where('ag_isactive', '1');
    						}
        				])
        				->where('gs_status', '1')
        				->select('gs_id', 'gs_nama', 'gs_kelompok')
        				->get();

        // return json_encode($res);

        $data = [
            "data"       => $res,
            "kelompok"   => $kelompok,
        ];

        return view('modul_keuangan.laporan.laba_rugi.print.index', compact('data'));
    }

    public function pdf(Request $request){
        $d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';

        $kelompok = DB::table('dk_akun as a')
        				->join('dk_akun as b', 'a.ak_kelompok', '=', 'b.ak_id')
        				->where('a.ak_type', 'detail')
        				->distinct('a.ak_kelompok')
        				->select('a.ak_kelompok', 'b.ak_nama')
        				->groupBy('a.ak_kelompok', 'b.ak_nama')
        				->get();


        $res = subclass::where('gs_type', 'LR')
        				->with([
    						'group' => function($query) use ($d1){
    							$query->select('ag_id', 'ag_subclass', 'ag_nama', 'ag_kelompok')
    									->with([
											'lr' => function($query) use ($d1){
												$query->select(DB::raw('distinct(ak_kelompok)'), 'ak_group_lr')
														->with([
															'fromKelompok' => function($query) use ($d1){
																$query->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
																		->where('as_periode', $d1)
																		->select(
																			'ak_id',
																			'ak_kelompok',
																			'ak_nama',
																			'ak_posisi',
																			DB::raw('coalesce(sum(as_saldo_awal), 2) as saldo_awal'),
																			DB::raw('coalesce(sum(as_mut_kas_debet), 2) as kas_debet'),
																			DB::raw('coalesce(sum(as_mut_kas_kredit), 2) as kas_kredit'),
																			DB::raw('coalesce(sum(as_mut_bank_debet), 2) as bank_debet'),
																			DB::raw('coalesce(sum(as_mut_bank_kredit), 2) as bank_kredit'),
																			DB::raw('coalesce(sum(as_mut_memorial_debet), 2) as memorial_debet'),
																			DB::raw('coalesce(sum(as_mut_memorial_kredit), 2) as memorial_kredit')
																)
																->groupBy('ak_id', 'ak_kelompok', 'ak_nama', 'ak_posisi');
															}
														])
														->groupBy('ak_kelompok', 'ak_group_lr');
											}
    									])
    									->where('ag_isactive', '1');
    						}
        				])
        				->where('gs_status', '1')
        				->select('gs_id', 'gs_nama', 'gs_kelompok')
        				->get();

        // return json_encode($res[0]->group[0]->akun[0]->fromKelompok);

        $data = [
            "data"       => $res,
            "kelompok"   => $kelompok,
        ];

        // return view('modul_keuangan.laporan.jurnal.print.pdf', compact('data'));

        $title = "Laporan_Laba_Rugi_".$d1.".pdf";

        $pdf = PDF::loadView('modul_keuangan.laporan.laba_rugi.print.pdf', compact('data'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download($title);
    }

    public function excel(Request $request){

        $d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';

        $kelompok = DB::table('dk_akun as a')
        				->join('dk_akun as b', 'a.ak_kelompok', '=', 'b.ak_id')
        				->where('a.ak_type', 'detail')
        				->distinct('a.ak_kelompok')
        				->select('a.ak_kelompok', 'b.ak_nama')
        				->groupBy('a.ak_kelompok', 'b.ak_nama')
        				->get();


        $res = subclass::where('gs_type', 'LR')
        				->with([
    						'group' => function($query) use ($d1){
    							$query->select('ag_id', 'ag_subclass', 'ag_nama', 'ag_kelompok')
    									->with([
											'lr' => function($query) use ($d1){
												$query->select(DB::raw('distinct(ak_kelompok)'), 'ak_group_lr')
														->with([
															'fromKelompok' => function($query) use ($d1){
																$query->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
																		->where('as_periode', $d1)
																		->select(
																			'ak_id',
																			'ak_kelompok',
																			'ak_nama',
																			'ak_posisi',
																			DB::raw('coalesce(sum(as_saldo_awal), 2) as saldo_awal'),
																			DB::raw('coalesce(sum(as_mut_kas_debet), 2) as kas_debet'),
																			DB::raw('coalesce(sum(as_mut_kas_kredit), 2) as kas_kredit'),
																			DB::raw('coalesce(sum(as_mut_bank_debet), 2) as bank_debet'),
																			DB::raw('coalesce(sum(as_mut_bank_kredit), 2) as bank_kredit'),
																			DB::raw('coalesce(sum(as_mut_memorial_debet), 2) as memorial_debet'),
																			DB::raw('coalesce(sum(as_mut_memorial_kredit), 2) as memorial_kredit')
																)
																->groupBy('ak_id', 'ak_kelompok', 'ak_nama', 'ak_posisi');
															}
														])
														->groupBy('ak_kelompok', 'ak_group_lr');
											}
    									])
    									->where('ag_isactive', '1');
    						}
        				])
        				->where('gs_status', '1')
        				->select('gs_id', 'gs_nama', 'gs_kelompok')
        				->get();

        // return json_encode($res[0]->group[0]->akun[0]->fromKelompok);

        $data = [
            "data"      => $res,
            "kelompok"   => $kelompok,
        ];

        // return json_encode($data);

        $title = "Laporan_Laba_Rugi_".$d1.".xlsx";

        // return view('modul_keuangan.laporan.jurnal.print.excel', compact('data'));

        return Excel::download(new exporter('modul_keuangan.laporan.laba_rugi.print.excel', $data), $title);
    }
}
