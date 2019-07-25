<?php

namespace App\Modules\Master\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use Datatables;
use Illuminate\Support\Facades\Hash;
use App\m_comp;

class MasterOutletController extends Controller
{
	public function index()
	{

		return view('Master::MasterOutlet.index');
	}

	public function tableOutlet()
	{
		$outlet = m_comp::all();
		return Datatables::of($outlet)

      ->addColumn('aksi', function ($data) {
			if ($data->c_isactive == 'Y') 
			{
				if ($data->c_name == 'PUSAT') 
				{
					return '';
				}
				else
				{
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
				}
			}
			else
			{
				if ($data->c_name == 'PUSAT') 
				{
					return '';
				}
				else
				{
				 	return  '<div class="text-center">'.
				          '<button onclick=ubahStatus("'.$data->c_id.'") 
				          		class="btn btn-danger btn-sm" 
				          		title="Tidak Aktif">'.
				          		'<label class="fa fa-minus-square"></label>
				          </button>'.
				         '</div>';
				}
			}

      })

      ->rawColumns(['aksi', 'limit', 'hutang'])
      ->make(true);
	}

	public function tambahData()
	{
		return view('Master::MasterOutlet.tambah');
	}

	public function simpan(Request $request){

		DB::beginTransaction();
		
		try {
			
			// return json_encode($request->all());

			$id = DB::table('m_comp')->max('c_id') + 1;

			DB::table('m_comp')->insert([
				'c_id'		=> $id,
				'c_code'	=> 'A0'.$id,
				'c_name'	=> $request->c_company,
				'c_owner'	=> $request->c_name,
				'c_address'	=> $request->c_address
			]);

		    DB::commit();
		
		    return Response::json([
		        'status' => 'sukses',
		        'message' => ''
		    ]);
		
		} catch (Exception $e) {
		
		    DB::rollBack();
		    
		    return Response::json([
		        'status' => 'gagal',
		        'message' => $e->getMessage()
		    ]);
		
		}

	}
}
