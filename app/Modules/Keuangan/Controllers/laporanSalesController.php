<?php 
namespace App\Modules\Keuangan\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use App\mMember;

class laporanSalesController extends Controller {
	public function __construct(){
        $this->middleware('auth');
    }

	public function index()
	{
		// return 'v';
		Mail::send('offerMail', $offer, function($message) use ($offer) {
		    $message->to('denypas@email.com');
		    $message->subject('Offer No.' . $offer['code']);
		});

		return view('Contoh::laporan_sales');
	}

}