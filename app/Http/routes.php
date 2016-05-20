<?php

Route::group(['middleware' => ['web']], function(){

	Route::auth();

	Route::get('/', 'PagesController@home');
	Route::get('/sobre', 'PagesController@about');

	Route::get('/contas/criar', function(){
		return view('accounts.new');
	});
	Route::post('/contas/criar', 'AccountsController@store');
	Route::get('/contas', 'AccountsController@index');
	Route::get('/contas/{account}', 'AccountsController@show');
	Route::patch('/contas/{account}', 'AccountsController@update');
	Route::get('/contas/{account}/delete', 'AccountsController@destroy');

});
