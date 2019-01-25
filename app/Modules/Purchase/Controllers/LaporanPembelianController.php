<?php

namespace App\Modules\Purchase\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use DB;
use Datatables;
use Auth;

use App\m_divisi;
use App\m_item;
use App\Modules\Purchase\model\d_purchasingharian;
use App\Modules\Purchase\model\d_purchasingharian_dt;

use Session;

class LaporanPembelianController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

     
    
    
    public function index() { 
           
        return view('Purchase::laporanpembelian/index');
    }

}
