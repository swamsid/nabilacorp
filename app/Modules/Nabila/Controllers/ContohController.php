<?php 
namespace App\Modules\Contoh\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\mMember;

class ContohController extends Controller {
	public function __construct(){
        $this->middleware('auth');
    }

	public function index()
	{
		return 'v';
		return view('Contoh::contoh');
	}

}