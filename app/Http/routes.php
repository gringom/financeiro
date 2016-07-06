<?php

Route::auth();
$user = Auth::user();

Route::get('/', 'PagesController@home');

Route::group(['middleware' => ['permission:view-reports']], function() {
	Route::get('/sobre', 'PagesController@about');
	Route::get('/fluxo', 'PagesController@flow');
	Route::get('/busca', 'PagesController@search');
});

Route::group(['middleware' => ['permission:edit-records']], function() {
	// cadastro no banco de dados
	Route::get('/bd/exportar', 'RecordsController@csvExport');
	Route::get('/bd/limpar-busca', 'RecordsController@clearSearchSession');
	Route::get('/bd/criar', 'RecordsController@new_record');
	Route::post('/bd/criar', 'RecordsController@store');
	Route::get('/bd', 'RecordsController@index');
	Route::get('/bd/{record}', 'RecordsController@show');
	Route::patch('/bd/{record}', 'RecordsController@update');
	Route::get('/bd/{record}/delete', 'RecordsController@destroy');
	Route::get('/bd/{record}/duplicar', 'RecordsController@duplicate');

	// cadastro de projetos
	Route::get('/projetos/criar', function(){
		return view('projects.new');
	});
	Route::post('/projetos/criar', 'ProjectsController@store');
	Route::get('/projetos', 'ProjectsController@index');
	Route::get('/projetos/{project}', 'ProjectsController@show');
	Route::patch('/projetos/{project}', 'ProjectsController@update');
	Route::get('/projetos/{project}/delete', 'ProjectsController@destroy');

	// cadastro de clientes e fornecedores
	Route::get('/clientes_fornecedores/criar', function(){
		return view('people.new');
	});
	Route::post('/clientes_fornecedores/criar', 'PeopleController@store');
	Route::get('/clientes_fornecedores', 'PeopleController@index');
	Route::get('/clientes_fornecedores/{person}', 'PeopleController@show');
	Route::patch('/clientes_fornecedores/{person}', 'PeopleController@update');
	Route::get('/clientes_fornecedores/{person}/delete', 'PeopleController@destroy');
});

Route::group(['middleware' => ['role:admin']], function() {
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

	// usuários
	Route::get('/usuarios', 'UsersController@index');
	Route::get('/usuarios/{user}', 'UsersController@show');
	Route::patch('/usuarios/{user}', 'UsersController@update');
	Route::get('/usuarios/{user}/delete', 'UsersController@removeAccess');
});
