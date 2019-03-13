<?php

namespace App\Modules\Master\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\m_consigner;
use Carbon\Carbon;
use DB;
use Response;
use Datatables;
use Illuminate\Support\Facades\Hash;

class MasterConsignerController extends Controller
{
   public function index()
   {

   	return view('Master::MasterConsigner.index');
   }

   public function tambahData()
   {

   	return view('Master::MasterConsigner.tambah');
   }

   public function simpanData(Request $request)
   {
   	DB::beginTransaction();
        try {
   	//code
   	$c_id = m_consigner::select('c_id')->max('c_id')+1;
   	$year = carbon::now()->format('y');
      $month = carbon::now()->format('m');
      $date = carbon::now()->format('d');
   	$code = 'CON' . $month . $year . $c_id;
   	//end code
   	m_consigner::insert([
   		'c_id' => $c_id,
   		'c_code' => $code,
			'c_name' => $request->c_name,
			'c_company' => $request->c_company,
			'c_hp1' => $request->c_hp1,
			'c_hp2' => $request->c_hp2,
			'c_fax' => $request->c_fax,
			'c_address' => $request->c_address,
			'c_info' => $request->c_info,
			'c_created' => Carbon::now()
   	]);

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

   public function tableConsigner()
   {
   	$cons = m_consigner::all();

      return Datatables::of($cons)
      ->addIndexColumn()
      ->editColumn('c_hp', function ($data) {
        if ($data->c_hp2 != null) 
        {
          	return $data->c_hp1.' | '.$data->c_hp2;
        }
        else 
        {
          	return $data->c_hp1;
        }
      })

      ->addColumn('aksi', function ($data) {
        if ($data->c_isactive == 'Y') {
          	return  '<div class="text-center">'.
                    '<button onclick=editConsigne("'.base64_encode($data->c_id).'")
                        class="btn btn-warning btn-sm" 
                        title="edit">'.
                        '<label class="fa fa-pencil"></label>
                    </button>'.'
                    <button onclick=ubahStatus("'.$data->c_id.'") 
                        class="btn btn-primary btn-sm" 
                        title="Aktif">'.
                        '<label class="fa fa-check-square"></label>
                    </button>'.
                  '</div>';
        }else{
          	return  '<div class="text-center">'.
                   '<button onclick=ubahStatus("'.$data->c_id.'") 
                   		class="btn btn-danger btn-sm" 
                   		title="Tidak Aktif">'.
                   		'<label class="fa fa-minus-square"></label>
                   </button>'.
                  '</div>';
        }
      })

      ->rawColumns(['aksi', 'limit', 'hutang'])
      ->make(true);
   }

   public function editConsigner(Request $request)
   {
   	$data = m_consigner::where('c_id',base64_decode($request->id))
   		->first();

   	return view('Master::MasterConsigner.edit',compact('data'));
   }

   public function updateConsigner(Request $request, $id)
   {
   	DB::beginTransaction();
        	try {
	   	m_consigner::where('c_id',$id)
	   		->update([
					'c_name' => $request->c_name,
					'c_company' => $request->c_company,
					'c_hp1' => $request->c_hp1,
					'c_hp2' => $request->c_hp2,
					'c_fax' => $request->c_fax,
					'c_address' => $request->c_address,
					'c_info' => $request->c_info
	   		]);
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

   public function statusConsigner(Request $request)
   {
   	DB::beginTransaction();
        	try {
   	$type = DB::Table('m_consigner')->where('c_id','=',$request->id)
        ->first();
      // dd($type->s_active);
      if ($type->c_isactive == 'Y') {
        	DB::Table('m_consigner')->where('c_id','=',$request->id)
        		->update([
          		'c_isactive' => 'N'
        		]);
      }else{
        	DB::Table('m_consigner')->where('c_id','=',$request->id)
        		->update([
          		'c_isactive' => 'Y'
        		]);
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
}
