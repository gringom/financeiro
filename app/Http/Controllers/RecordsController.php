<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Record;
use App\Account;
use App\Category;
use App\Person;
use App\Project;
use DateTime;
use Illuminate\Http\Request;

class RecordsController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	$records = $this->getAllAsArray();
    	$records['form_request'] = $request->all();
    	if( $request->exists('s') ) {
    		$rec = Record::query();

			list( $rec, $records ) = $this->queryValue($request, $rec, $records);
			list( $rec, $records ) = $this->queryExpiryDate($request, $rec, $records);
			list( $rec, $records ) = $this->queryPaidDate($request, $rec, $records);

			$request->type ? $rec->whereIn('type', $request->type) : null;
    		$request->account ? $rec->whereIn('account_id', $request->account) : null;
    		$request->category ? $rec->whereIn('category_id', $request->category) : null;
    		$request->person ? $rec->whereIn('person_id', $request->person) : null;
    		$request->project ? $rec->whereIn('project_id', $request->project) : null;
    		$records['all'] = $rec->orderBy('created_at', 'desc')->get();
    	}
    	else {
    		$rec = Record::orderBy('created_at', 'desc')->get();
    		$records['all'] = $rec->load('account','category','person','project');
    	}

    	$records['types'] = array('entrada' => 'Entrada', 'saida' => 'Saída', 'a_receber' => 'A Receber', 'a_pagar' => 'A Pagar');
    	$records = $this->getValueLimits($records);

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
		$records['payment_date'] = DateTime::createFromFormat('Y-m-d', $record->payment_date);
		$records['paid_date'] = DateTime::createFromFormat('Y-m-d', $record->paid_date);

		return view('records.edit', compact('records'));
	}

	public function update(Request $request, Record $record)
	{
		$this->validateForm($request);

		$request = $this->validateDates($request);

		$record->update($request->all());
		flash('Registro atualizado.', 'success');

		return redirect('/bd');
	}

	public function store(Request $request)
	{
		$this->validateForm($request);
		$request = $this->validateDates($request);

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
			'value' => 'numeric',
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

	public function validateDates(Request $request)
	{
		$payment_date = DateTime::createFromFormat('d/m/Y', $request->get('payment_date'));
		$request['payment_date'] = $payment_date->format('Y-m-d');

		if( strlen($request->get('paid_date')) > 0 ){
			$paid_date = DateTime::createFromFormat('d/m/Y', $request->get('paid_date'));
			$request['paid_date'] = $paid_date->format('Y-m-d');			
		}
		else{
			$request['paid_date'] = false;
		}
		return $request;
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

	public function getValueLimits($records)
	{
    	$records['form_request']['min_value_limit'] = floor(DB::table('records')->min('value'));
    	$records['form_request']['max_value_limit'] = ceil(DB::table('records')->max('value'));
		
		return $records;
	}

	public function queryExpiryDate(Request $request, $rec, $records)
	{
		if( $request->data_venc ){
			preg_match('/(?P<date_venc_start>\d{2}\/\d{2}\/\d{4}) - (?P<date_venc_end>\d{2}\/\d{2}\/\d{4})/', $request->data_venc, $matches);
			$start = DateTime::createFromFormat( "d/m/Y", $matches['date_venc_start'] );
			$end = DateTime::createFromFormat( "d/m/Y", $matches['date_venc_end'] );
			$rec->whereBetween('payment_date', array($start->format("Y-m-d"), $end->format("Y-m-d")));
			$records['form_request']['exp_date'] = $matches['date_venc_start'] . " - " . $matches['date_venc_end'];
			$records['form_request']['exp_date_start'] = $matches['date_venc_start'];
			$records['form_request']['exp_date_end'] = $matches['date_venc_end'];
		}
		return array( $rec, $records );
	}

	public function queryPaidDate(Request $request, $rec, $records)
	{
		if( $request->data_pag ){
			preg_match('/(?P<date_paid_start>\d{2}\/\d{2}\/\d{4}) - (?P<date_paid_end>\d{2}\/\d{2}\/\d{4})/', $request->data_pag, $matches);
			$start = DateTime::createFromFormat( "d/m/Y", $matches['date_paid_start'] );
			$end = DateTime::createFromFormat( "d/m/Y", $matches['date_paid_end'] );
			$rec->whereBetween('paid_date', array($start->format("Y-m-d"), $end->format("Y-m-d")));
			$records['form_request']['paid_date'] = $matches['date_paid_start'] . " - " . $matches['date_paid_end'];
			$records['form_request']['paid_date_start'] = $matches['date_paid_start'];
			$records['form_request']['paid_date_end'] = $matches['date_paid_end'];
		}
		return array( $rec, $records );
	}

	public function queryValue(Request $request, $rec, $records)
	{
		if( $request->value && preg_match('/((?:\d{1,3}[,\.]?)+\d*)\,((?:\d{1,3}[,\.]?)+\d*)/', $request->value, $matches) ){
			$rec->whereBetween('value', array($matches[1], $matches[2]));
			$records['form_request']['min_selected_value'] = $matches[1];
			$records['form_request']['max_selected_value'] = $matches[2];
		}
		return array( $rec, $records );
	}
}