<?php

namespace App\Http\Controllers;

use App\Record;
use App\Account;
use App\Category;
use App\Person;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Requests;
use DateTime;

class PagesController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

	public function home()
	{
		return view('pages.welcome');
	}

	public function about()
	{
		return view('pages.about');
	}

	public function search(Request $request)
	{
		$records = $this->getAllAsArray();
		$records['types'] = array('entrada' => 'Entrada', 'saida' => 'Saída', 'a_receber' => 'A Receber', 'a_pagar' => 'A Pagar');

// \DB::enableQueryLog();
		$rec = Record::query();
		$rec->selectRaw('accounts.title as tit, records.type as typ, sum(records.value) as val');
		$rec->leftJoin('accounts', 'records.account_id', '=', 'accounts.id');
		list( $rec, $records ) = $this->queryExpiryDate($request, $rec, $records);
		$request->type ? $rec->whereIn('typ', $request->type) : null;
		$request->categories_id ? $rec->whereIn('records.category_id', $request->categories_id) : null;
		$request->people_id ? $rec->whereIn('records.person_id', $request->people_id) : null;
		$request->project_id ? $rec->whereIn('records.project_id', $request->project_id) : null;
		$rec->groupBy('accounts.title')->groupBy('records.type');
		$sort = array( "accounts.title" => "desc", "records.type" => "desc" );
		foreach ($sort as $key => $value) {
    		$rec->orderBy($key, $value);
		}
		$records['all'] = $this->fillTheBlanks($rec->get(), $records, $request->type);
		$records['request'] = $request->all();
// print_pre(\DB::getQueryLog());
		return view('pages.search', compact('records'));
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
		$records['accounts'] = $this->getAllAccountsAsArray();
    	$records['categories'] = $this->getAllCategoriesAsArray();
    	$records['people'] = $this->getAllPeopleAsArray();
    	$records['projects'] = $this->getAllProjectsAsArray();

    	return $records;
	}

	public function fillTheBlanks($rec, $records, $req_types = null)
	{
		$keys = $req_types ? $req_types : array_keys($records["types"]);
		$types = array_fill_keys( $keys, 0 );
		$fill_arr = array();
		foreach( $types as $key_type => $value_type ){
			foreach ($records["accounts"] as $account) {
				$fill_arr[$key_type][$account] = 0;
			}
		}

		foreach ($rec as $r) {
			$fill_arr[$r->typ][$r->tit] = $r->val;
		}

		return $fill_arr;
	}

	public function queryExpiryDate(Request $request, $rec, $records)
	{
		if( $request->date_venc ){
			preg_match('/(?P<date_venc_start>\d{2}\/\d{2}\/\d{4}) - (?P<date_venc_end>\d{2}\/\d{2}\/\d{4})/', $request->date_venc, $matches);
			$start = DateTime::createFromFormat( "d/m/Y", $matches['date_venc_start'] );
			$end = DateTime::createFromFormat( "d/m/Y", $matches['date_venc_end'] );
			$rec->whereBetween('records.payment_date', array($start->format("Y-m-d"), $end->format("Y-m-d")));
			$records['request']['date_venc'] = $matches['date_venc_start'] . " - " . $matches['date_venc_end'];
			$records['request']['exp_date_start'] = $matches['date_venc_start'];
			$records['request']['exp_date_end'] = $matches['date_venc_end'];
		}
		return array( $rec, $records );
	}
}