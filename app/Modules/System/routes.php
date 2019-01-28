<?php

Route::group(['namespace' => 'App\Modules\System\Controllers', 'middleware'=>['web','auth']], function () {
	Route::get('/system/hakuser/index', 'hakuserController@index');
	Route::get('/system/hakuser/tambah', 'hakuserController@tambah');
	Route::post('/system/hakuser/simpan', 'hakuserController@simpan');
	Route::get('/system/hakuser/edit-user-akses/{id}/edit', 'hakuserController@editUserAkses');
	Route::get('/system/hakuser/tableuser', 'hakuserController@tableUser');
	Route::get('/system/hakuser/autocomplete-pegawai', 'hakuserController@autocompletePegawai');
	Route::post('/system/hakuser/perbarui-user/{id}', 'hakuserController@perbaruiUser');
	Route::post('/system/hakuser/hapus-user', 'hakuserController@hapusUser');
	
	Route::get('/system/hakaksespengguna/akses', 'aksesUserController@index');
	Route::get('/system/hakaksespengguna/dataUsers', 'aksesUserController@dataUser');
	Route::post('/system/hakaksespengguna/dataUsers', 'aksesUserController@dataUser');
	Route::get('/system/hakaksespengguna/edit/{id}', 'aksesUserController@editUserAkses');
});
