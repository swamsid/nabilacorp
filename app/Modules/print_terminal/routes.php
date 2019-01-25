<?php

Route::group(['namespace' => 'App\Modules\print_terminal\Controllers', 'middleware'=>['web']], function () {
	
	Route::get('/print_terminal', 'printTerminalController@index');
});


