<?php

Route::group(['middleware' => ['web']], function(){

	Route::auth();

	Route::get('/', 'PagesController@home');
	Route::get('/sobre', 'PagesController@about');

	// cadastro de categorias
	Route::get('/categorias/criar', function(){
		return view('categories.new');
	});
	Route::post('/categorias/criar', 'CategoriesController@store');
	Route::get('/categorias', 'CategoriesController@index');
	Route::get('/categorias/{category}', 'CategoriesController@show');
	Route::patch('/categorias/{category}', 'CategoriesController@update');
	Route::get('/categorias/{category}/delete', 'CategoriesController@destroy');

	// cadastro de contas
	Route::get('/contas/criar', function(){
		return view('accounts.new');
	});
	Route::post('/contas/criar', 'AccountsController@store');
	Route::get('/contas', 'AccountsController@index');
	Route::get('/contas/{account}', 'AccountsController@show');
	Route::patch('/contas/{account}', 'AccountsController@update');
	Route::get('/contas/{account}/delete', 'AccountsController@destroy');

});
