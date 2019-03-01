<?php

namespace App\Http\Controllers\modul_keuangan\laporan\jurnal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Export\excel\exporter as exporter;
use App\Model\modul_keuangan\dk_jurnal as jurnal;

use DB;
use Excel;
use PDF;

class laporan_jurnal_controller extends Controller
{
    public function index(Request $request){

        $cabang = '';

        if(modulSetting()['support_cabang']){
            $cabang = DB::table(tabel()->cabang->nama)
                                ->where(tabel()->cabang->kolom->id, $request->cab)
                                ->select(tabel()->cabang->kolom->nama.' as nama')
                                ->first()->nama;
        }

    	return view('modul_keuangan.laporan.jurnal.index', compact('cabang'));
    }

    public function dataResource(Request $request){

    	$d1 = explode('/', $request->d1)[2]."-".explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0];
    	$d2 = explode('/', $request->d2)[2]."-".explode('/', $request->d2)[1].'-'.explode('/', $request->d2)[0];
    	$type = $request->type;
    	$nama = $request->nama;
        $cabang = [];

        // Mengambil Cabang

            if(modulSetting()['support_cabang']){
                $cabang = DB::table(tabel()->cabang->nama)
                                ->select(tabel()->cabang->kolom->id.' as id', tabel()->cabang->kolom->nama.' as text');

                if(modulSetting()['onLogin'] == modulSetting()['id_pusat'])
                    $cabang = $cabang->get();
                else
                    $cabang = $cabang->where(tabel()->cabang->kolom->id, modulSetting()['onLogin'])->get();
            }

        // Selesai Mengambil Cabang
        
        $data = jurnal::where(DB::raw('SUBSTR(jr_type, 1, 1)'), $type)
                            ->with([
                                    'detail' => function($query){
                                        $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_value', 'jrdt_dk', 'ak_nama', 'ak_nomor')
                                                ->join('dk_akun', 'dk_akun.ak_id', '=', 'dk_jurnal_detail.jrdt_akun')
                                                ->get();
                                    }
                            ])
                            ->where('jr_tanggal_trans', ">=", $d1)
                            ->where('jr_tanggal_trans', "<=", $d2);

        // ketika support cabang

            if(modulSetting()['support_cabang']){
                $data = $data->where('jr_comp', $request->cab)
                                ->select('jr_id', 'jr_ref', 'jr_tanggal_trans', 'jr_keterangan', 'jr_type')
                                ->orderBy('jr_tanggal_trans', 'asc')
                                ->get();
            }else{
                $data = $data->select('jr_id', 'jr_ref', 'jr_tanggal_trans', 'jr_keterangan', 'jr_type')
                                ->orderBy('jr_tanggal_trans', 'asc')
                                ->get();
            }

        // selesai

        // return $data;

    	return json_encode([
    		"data"	=> $data,
    		"requestNama" => $request->nama,
            "cabang"      => $cabang
    	]);
    }

    public function excel(Request $request){

        $d1 = explode('/', $request->d1)[2]."-".explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0];
        $d2 = explode('/', $request->d2)[2]."-".explode('/', $request->d2)[1].'-'.explode('/', $request->d2)[0];
        $type = $request->type;
        $t = "Kas";

        // Mengambil Cabang

            $namaCabang = '';

            if(modulSetting()['support_cabang']){
                $namaCabang = DB::table(tabel()->cabang->nama)
                                    ->where(tabel()->cabang->kolom->id, $request->cab)
                                    ->select(tabel()->cabang->kolom->nama.' as nama')
                                    ->first()->nama;
            }

        // Selesai Mengambil Cabang
        
        $res = jurnal::where(DB::raw('SUBSTR(jr_type, 1, 1)'), $type)
                            ->with([
                                    'detail' => function($query){
                                        $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_value', 'jrdt_dk', 'ak_nama', 'ak_nomor')
                                                ->join('dk_akun', 'dk_akun.ak_id', '=', 'dk_jurnal_detail.jrdt_akun')
                                                ->get();
                                    }
                            ])
                            ->where('jr_tanggal_trans', ">=", $d1)
                            ->where('jr_tanggal_trans', "<=", $d2);

        // ketika support cabang

            if(modulSetting()['support_cabang']){
                $res = $res->where('jr_comp', $request->cab)
                                ->select('jr_id', 'jr_ref', 'jr_tanggal_trans', 'jr_keterangan', 'jr_type')
                                ->orderBy('jr_tanggal_trans', 'asc')
                                ->get();
            }else{
                $res = $res->select('jr_id', 'jr_ref', 'jr_tanggal_trans', 'jr_keterangan', 'jr_type')
                                ->orderBy('jr_tanggal_trans', 'asc')
                                ->get();
            }

        // selesai

        $data = [
            "data"      => $res,
            "request"   => $request->all(),
            "namaCabang"    => $namaCabang
        ];

        // return json_encode($data);

        if($type == 'B')
            $t = 'Bank';
        else if($type == 'M')
            $t = 'Memorial';

        $title = "Laporan_Jurnal_".$t."j".$namaCabang."_".$d1."_-_".$d2.".xlsx";

        // return view('modul_keuangan.laporan.jurnal.print.excel', compact('data'));

        return Excel::download(new exporter('modul_keuangan.laporan.jurnal.print.excel', $data), $title);
    }

    public function pdf(Request $request){
        $d1 = explode('/', $request->d1)[2]."-".explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0];
        $d2 = explode('/', $request->d2)[2]."-".explode('/', $request->d2)[1].'-'.explode('/', $request->d2)[0];
        $type = $request->type;
        $t = "Kas";

        if($type == 'B')
            $t = 'Bank';
        else if($type == 'M')
            $t = 'Memorial';

        // Mengambil Cabang

            $namaCabang = '';

            if(modulSetting()['support_cabang']){
                $namaCabang = DB::table(tabel()->cabang->nama)
                                    ->where(tabel()->cabang->kolom->id, $request->cab)
                                    ->select(tabel()->cabang->kolom->nama.' as nama')
                                    ->first()->nama;
            }

        // Selesai Mengambil Cabang

        $res = jurnal::where(DB::raw('SUBSTR(jr_type, 1, 1)'), $type)
                            ->with([
                                    'detail' => function($query){
                                        $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_value', 'jrdt_dk', 'ak_nama', 'ak_nomor')
                                                ->join('dk_akun', 'dk_akun.ak_id', '=', 'dk_jurnal_detail.jrdt_akun')
                                                ->get();
                                    }
                            ])
                            ->where('jr_tanggal_trans', ">=", $d1)
                            ->where('jr_tanggal_trans', "<=", $d2);

        // ketika support cabang

            if(modulSetting()['support_cabang']){
                $res = $res->where('jr_comp', $request->cab)
                                ->select('jr_id', 'jr_ref', 'jr_tanggal_trans', 'jr_keterangan', 'jr_type')
                                ->orderBy('jr_tanggal_trans', 'asc')
                                ->get();
            }else{
                $res = $res->select('jr_id', 'jr_ref', 'jr_tanggal_trans', 'jr_keterangan', 'jr_type')
                                ->orderBy('jr_tanggal_trans', 'asc')
                                ->get();
            }

        // selesai

        $data = [
            "data"      => $res,
            "request"   => $request->all(),
            "namaCabang"    => $namaCabang
        ];

        // return view('modul_keuangan.laporan.jurnal.print.pdf', compact('data'));

        $title = "Laporan_Jurnal_".$t."_".$d1."__".$d2.".pdf";

        $pdf = PDF::loadView('modul_keuangan.laporan.jurnal.print.pdf', compact('data'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download($title);
    }

    public function print(Request $request){
        $d1 = explode('/', $request->d1)[2]."-".explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0];
        $d2 = explode('/', $request->d2)[2]."-".explode('/', $request->d2)[1].'-'.explode('/', $request->d2)[0];
        $type = $request->type;
        $t = "Kas";

        $res = jurnal::where(DB::raw('SUBSTR(jr_type, 1, 1)'), $type)
                            ->with([
                                    'detail' => function($query){
                                        $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_value', 'jrdt_dk', 'ak_nama', 'ak_nomor')
                                                ->join('dk_akun', 'dk_akun.ak_id', '=', 'dk_jurnal_detail.jrdt_akun')
                                                ->get();
                                    }
                            ])
                            ->where('jr_tanggal_trans', ">=", $d1)
                            ->where('jr_tanggal_trans', "<=", $d2);

        // ketika support cabang

            if(modulSetting()['support_cabang']){
                $res = $res->where('jr_comp', $request->cab)
                                ->select('jr_id', 'jr_ref', 'jr_tanggal_trans', 'jr_keterangan', 'jr_type')
                                ->orderBy('jr_tanggal_trans', 'asc')
                                ->get();
            }else{
                $res = $res->select('jr_id', 'jr_ref', 'jr_tanggal_trans', 'jr_keterangan', 'jr_type')
                                ->orderBy('jr_tanggal_trans', 'asc')
                                ->get();
            }

        // selesai

        if($type == 'B')
            $t = 'Bank';
        else if($type == 'M')
            $t = 'Memorial';

        $data = [
            "data"      => $res,
            "request"   => $request->all(),
        ];

        return view('modul_keuangan.laporan.jurnal.print.index', compact('data'));
    }

    public function generateRandomString($length = 10) {

    	for ($i=0; $i < 1000; $i++) { 
    		array_push($data, ["id" => $this->generateRandomString(), "name" => 'Dirga Ambara - '.($i+1)]);
    	}

	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
}
