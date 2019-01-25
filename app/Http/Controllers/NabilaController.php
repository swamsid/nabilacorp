<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NabilaController extends Controller
{
    public function member()
    {
    	return view('nabila/member/member');
    }
    public function belanja()
    {
    	return view('nabila/belanjakaryawan/belanja');
    }
    public function voucher()
    {
    	return view('nabila/voucherbelanja/voucher');
    }
    public function reseller()
    {
    	return view('nabila/reseller/reseller');
    }
    public function marketer()
    {
    	return view('nabila/marketer/marketer');
    }
    public function return()
    {
    	return view('nabila/return/return');
    }
    public function purchasing()
    {
    	return view('nabila/purchasing/purchasing');
    }
}
