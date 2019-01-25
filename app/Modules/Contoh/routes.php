<?php

Route::group(['namespace' => 'App\Modules\Contoh\Controllers', 'middleware'=>['web','auth']], function () {
	Route::get('/contoh', 'ContohController@index');
});

