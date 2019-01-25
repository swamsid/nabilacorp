<?php
namespace App\Modules\Inventory\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\mMember;
use DB;
use Carbon\Carbon;
use DateTime;
use Yajra\Datatables\Datatables;
use Session;
use App\Lib\mutasi;

class penerimaanController extends Controller {
	public function __construct(){
        $this->middleware('auth');
    }

	public function index()
	{
		$data = DB::table('d_pengiriman')
							->where('p_status_diterima', 'Y')
							->select('p_code', 'p_id')
							->get();

		return view('Inventory::penerimaan.index', compact('data'));
	}

	public function getdata(Request $request){		
			$data = DB::table('d_pengiriman')
							->join('d_pengiriman_dt', 'pd_pengiriman', '=', 'p_id')
							->join('m_item', 'i_id', '=', 'pd_item')
							->where('p_id', $request->id)
							->get();

			for ($i=0; $i < count($data); $i++) {
				if ($data[$i]->pd_penerima == null) {
					$data[$i]->pd_penerima = '-';
				}
			}

			return response()->json($data);
	}

	public function terima(Request $request){
		DB::beginTransaction();
		try {

			DB::table('d_pengiriman_dt')
					->where('pd_pengiriman', $request->id)
					->update([						
						'pd_penerima' => Session::get('user_comp'),
						'pd_status_diterima' => 'Y',
					]);


			DB::table('d_pengiriman')
					->where('p_id', $request->id)
					->update([			
						'p_status_diterima' => 'T',
					]);

			$p_code=DB::table('d_pengiriman')
					->where('p_id', $request->id)
					->select('p_code')
					->first();


			$getPengiriman=DB::table('d_pengiriman_dt')
						   ->where('pd_pengiriman', $request->id)->get();

			$date=date('Y-m-d');
			foreach ($getPengiriman as $data) {
				$simpanMutasi=mutasi::simpanTranferMutasi($data->pd_item,$data->pd_qty,$data->pd_comp,$data->pd_position,$flag='Penerimaan',$p_code->p_code,$ket='e',$date,$data->pd_comp,$data->pd_comp,1,'Penerimaan Penjualan');
			}


			
						


			DB::commit();
			return response()->json([
				'status' => 'berhasil'
			]);
		} catch (\Exception $e) {

			DB::rollback();
			return response()->json([
				'status' => 'gagal'
			]);
		}

	}

}
