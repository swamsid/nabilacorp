<?php

namespace App\Modules\Nabila\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use DB;
use Auth;

use App\Modules\Nabila\model\m_customer;

use Session;

class MemberController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }
  
    public function index() { 
           
        return view('Nabila::member/index');
    }

    public function form_insert() {
        return view('Nabila::member/form_insert'); 
    }

    public function form_alter($id) {
        $m_customer = m_customer::where('c_id', $id);
        $m_customer = $m_customer->select('c_id', 'c_name', 'c_birthday', 'c_hp', 'c_address', 'c_email', DB::raw('DATE_FORMAT(c_birthday, "%d-%m-%Y") AS c_birthday_label'))->first();
        $data = ['m_customer' => $m_customer];
        // print_r($c_member);
        // die('');
        return view('Nabila::member/form_alter', $data); 
    }
    public function preview($id) {
        $m_customer = m_customer::where('c_id', $id);
        $m_customer = $m_customer->select('c_id', 'c_name', 'c_birthday', 'c_hp', 'c_address', 'c_email', DB::raw('DATE_FORMAT(c_birthday, "%d-%m-%Y") AS c_birthday_label'))->first();
        $data = ['m_customer' => $m_customer];
        return view('Nabila::member/preview', $data); 
    }

    public function get_data_all()
    {
        $all = m_customer::orderBy('c_insert', 'desc')->get();

        $res = ['data' => $all];
        return response()->json($res);
    }

    public function detail($id)
    {

        

            
            $member = m_customer::where('c_id', $id)->first();
            $res = [
                'data' => $member,
            ];
            return view('Nabila::member/form_detail', $res);
        
    }

    public function getDataId()
    {
        $cek = DB::table('d_mem')
            ->select(DB::raw('max(right(c_id, 7)) as id'))
            ->get();

        foreach ($cek as $x) {
            $temp = ((int)$x->id + 1);
            $kode = sprintf("%07s", $temp);
        }

        $tempKode = 'MPF' . $kode;
        return $tempKode;
    }

    public function simpan_tambah(Request $request)
    {

                    $data = $request->all();
                    DB::beginTransaction();

                    try {

                      $data['c_birthday'] = preg_replace('/(\d+)[\/-](\d+)[\/-](\d+)/', '$3-$2-$1', $data['c_birthday']);
                      $c_date = date('my');
                      $c_code = DB::raw("(SELECT CONCAT('CUS$c_date/C001/', LPAD(MAX(c_id) + 1, 3, '0')) FROM m_customer C)");
                        m_customer::insert([
                            'c_code' => $c_code,
                            'c_name' => strtoupper($data['c_name']),
                            'c_hp' => $data['c_hp'],
                            'c_email' => $data['c_email'],
                            'c_address' => $data['c_address'],
                            'c_birthday' => $data['c_birthday']
                        ]);

                        DB::commit();
                        

                        return response()->json([
                            'status' => 'sukses',
                        ]);                            
                    } catch (\Exception $e) {

                        DB::rollback();

                        $message = 'Error. ' . $e;
                        // something went wrong
                        return response()->json([
                            'status' => 'gagal',
                            'msg' => $message
                        ]);

                    }
                
            
        
    }

    public function simpan_edit(Request $request, $id = null)
    {
         $data = $request->all();
                    DB::beginTransaction();

                    try {

                      $data['c_birthday'] = preg_replace('/(\d+)[\/-](\d+)[\/-](\d+)/', '$3-$2-$1', $data['c_birthday']);
                      $c_member = m_customer::where('c_id', $data['c_id']);
                      
                      $c_member->update([
                          "c_name" => $data['c_name'],
                          "c_birthday" => $data['c_birthday'],
                          "c_hp" => $data['c_hp'],
                          "c_address" => $data['c_address'],
                          "c_email" => $data['c_email']
                      ]);
     
                        DB::commit();
                        

                        return response()->json([
                            'status' => 'sukses'
                        ]);                            
                    } catch (\Exception $e) {

                        DB::rollback();

                        $message = 'Error. ' . $e;
                        // something went wrong
                        return response()->json([
                            'status' => 'gagal',
                            'msg' => $message
                        ]);

                    }   
    }

    

    public function delete($id)
    {
        
        

            DB::beginTransaction();

            try {
                if($id != '') {
                    $member = m_customer::where('c_id', $id);
                    $member->delete();

                    DB::commit();
                    return response()->json([
                        'status' => 'sukses'
                    ]);
                }
                else {
                    return response()->json([
                        'status' => 'gagal',
                        'msg' => 'Data kosong'
                    ]);  
                }
               
            } catch (\Exception $e) {

                DB::rollback();

                // something went wrong
                return response()->json([
                    'status' => 'gagal',
                    'msg' => $e
                ]);
            }
        
    }
   
}
