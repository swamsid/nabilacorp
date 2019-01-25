<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Customer;
use DB;
use Carbon\carbon;
use Session;
use Exception;
use Yajra\Datatables\Datatables;

use App\m_supplier;

class supplierController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function datasupplier(Request $request)
    {
        return m_supplier::seachSupplier($request);
    }

   
}
