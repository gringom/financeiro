<?php

namespace App\Http\Controllers;

use Auth;
use App\Record;
use App\Account;
use App\Category;
use App\Person;
use App\Project;
use Illuminate\Http\Request;

class RecordsController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$rec = Record::orderBy('created_at', 'desc')->get();
    	$records['all'] = $rec->load('account','category','person','project');
    	$records['types'] = array('entrada' => 'Entrada', 'saida' => 'Saída', 'a_receber' => 'A Receber', 'a_pagar' => 'A Pagar');

    	return view('records.index', compact('records'));
    }

    public function new_record()
    {
    	$records = $this->getAllAsArray();
		return view('records.new', compact('records'));
    }

	public function show(Record $record)
	{
		$records = $this->getAllAsArray();
		$records['this'] = $record ;

		return view('records.edit', compact('records'));
	}

	public function update(Request $request, Record $record)
	{
		$this->validateForm($request);

		$record->update($request->all());
		flash('Registro atualizado.', 'success');

		return redirect('/bd');
	}

	public function store(Request $request)
	{
		$this->validateForm($request);

		$record = new Record($request->all());
		$record->by(Auth::id());
		$record->save();
		flash('Registro criado.', 'success');

		return redirect('/bd');
	}

	public function duplicate(Record $record)
	{
		$new_record = $record->replicate() ;
		$new_record->id = Record::orderBy('created_at', 'desc')->pluck('id')->first() + 1;
		$new_record->save();
		flash('Registro duplicado.', 'warning');

		return redirect('/bd/' . $new_record->id );
	}

	public function destroy(Record $record)
	{
		$record->delete();
		flash('Registro removido.', 'warning');

		return redirect('/bd');
	}

	public function validateForm(Request $request)
	{
		$this->validate($request, [
			'type' => 'required',
			'account_id' => 'required',
			'category_id' => 'required',
			'person_id' => 'required',
			'value' => 'required|numeric',
			'payment_date' => 'required|date_format:"d/m/Y"',
			'paid_date' => 'date_format:"d/m/Y"',
		],[
			'type.required' => 'É obrigatório informar o Tipo do registro',
			'account_id.required' => 'É obrigatório informar a Conta',
			'category_id.required' => 'É obrigatório informar a Categoria',
			'person_id.required' => 'É obrigatório informar o Cliente/Fornecedor',
			'value.required' => 'É obrigatório informar o Valor',
			'value.numeric' => 'É necessário informar o Valor como um número (ex: 2500 ou 2450.00)',
			'payment_date.required' => 'É obrigatório informar a Data do Vencimento',
			'payment_date.date_format' => 'É necessário informar a Data do Vencimento no formato dd/mm/aaaa (ex: 02/09/2016)',
			'paid_date.date_format' => 'É necessário informar a Data do Pagamento no formato dd/mm/aaaa (ex: 02/09/2016)',
		]);
	}

	public function getAllAccountsAsArray()
	{
		$accounts_info = Account::all() ;
    	$accounts = array();
    	foreach( $accounts_info as $account ){
    		$accounts[$account->id] = $account->title;
    	}

    	return $accounts;
	}

	public function getAllCategoriesAsArray()
	{
		$categories_info = Category::all() ;
    	$categories = array();
    	foreach( $categories_info as $category ){
    		$categories[$category->type][$category->id] = $category->title;
    	}

    	return $categories;
	}

	public function getAllPeopleAsArray()
	{
		$people_info = Person::all() ;
    	$people = array();
    	foreach( $people_info as $person ){
    		$people[$person->id] = $person->title;
    	}

    	return $people;
	}

	public function getAllProjectsAsArray()
	{
		$projects_info = Project::orderBy('year','desc')->get();
    	$projects = array();
    	foreach( $projects_info as $project ){
    		$projects[$project->id] = $project->title . "(" . $project->year . ")";
    	}

    	return $projects;
	}

	public function getAllAsArray()
	{
		$records = array();
		$records['types'] = array('entrada' => 'Entrada', 'saida' => 'Saída', 'a_receber' => 'A Receber', 'a_pagar' => 'A Pagar');
		$records['accounts'] = $this->getAllAccountsAsArray();
    	$records['categories'] = $this->getAllCategoriesAsArray();
    	$records['people'] = $this->getAllPeopleAsArray();
    	$records['projects'] = $this->getAllProjectsAsArray();

    	return $records;
	}
}
