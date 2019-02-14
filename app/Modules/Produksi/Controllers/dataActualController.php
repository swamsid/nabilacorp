<?php

namespace App\Modules\Produksi\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Auth;
use Response;
use Datatables;
use App\Http\Requests;
use App\spk_actual;

class dataActualController extends Controller
{
    public function tableActual(Request $request, $tgl1, $tgl2)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7, -5);
        $d = substr($tgl1, 0, 2);
        $tanggal1 = $y . '-' . $m . '-' . $d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7, -5);
        $d2 = substr($tgl2, 0, 2);
        $tanggal2 = $y2 . '-' . $m2 . '-' . $d2;

        $data = spk_actual::select('spk_date',
            'spk_code',
            'i_name',
            'ac_adonan',
            'ac_sampah',
            'ac_kriwilan',
            's_name')
            ->join('d_spk', 'spk_id', '=', 'ac_spk')
            ->join('m_item', 'i_id', '=', 'spk_item')
            ->join('m_satuan', 's_id', '=', 'ac_adonan_scale')
            ->where('spk_date', '>=', $tanggal1)
            ->where('spk_date', '<=', $tanggal2)
            ->get();

        return DataTables::of($data)
            ->editColumn('spk_date', function ($user) {
                return $user->spk_date ? with(new Carbon($user->spk_date))->format('d M Y') : '';
            })
            ->rawColumns(['spk_date'
            ])
            ->make(true);
    }
}
