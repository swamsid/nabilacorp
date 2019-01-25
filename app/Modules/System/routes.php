<?php

Route::group(['namespace' => 'App\Modules\System\Controllers', 'middleware'=>['web','auth']], function () {
	Route::get('/system/hakuser/index', 'hakuserController@index');
	Route::get('/system/hakuser/tambah', 'hakuserController@tambah');
	Route::get('/system/hakuser/simpan', 'hakuserController@simpan');
	Route::get('/system/hakuser/edit', 'hakuserController@edit');
	Route::get('/system/hakuser/update', 'hakuserController@update');
	Route::get('/system/hakuser/hapus', 'hakuserController@hapus');

	Route::get('/system/hakaksespengguna/akses', 'aksesUserController@index');
	Route::get('/system/hakaksespengguna/dataUsers', 'aksesUserController@dataUser');
	Route::post('/system/hakaksespengguna/dataUsers', 'aksesUserController@dataUser');
	Route::get('/system/hakaksespengguna/edit/{id}', 'aksesUserController@editUserAkses');
});
