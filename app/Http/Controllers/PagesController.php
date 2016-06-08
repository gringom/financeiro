<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Record;
use App\Account;
use App\Category;
use App\Person;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Requests;
use DateTime;
use DateInterval;
use DatePeriod;

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

		$rec = Record::query();
		$rec->selectRaw('accounts.title as tit, records.type as type, sum(records.value) as val');
		$rec->leftJoin('accounts', 'records.account_id', '=', 'accounts.id');
		list( $rec, $records ) = $this->queryExpiryDate($request, $rec, $records);
		$request->type ? $rec->whereIn('type', $request->type) : null;
		$request->categories_id ? $rec->whereIn('records.category_id', $request->categories_id) : null;
		$request->people_id ? $rec->whereIn('records.person_id', $request->people_id) : null;
		$request->project_id ? $rec->whereIn('records.project_id', $request->project_id) : null;
		$rec->groupBy('accounts.title')->groupBy('records.type');
		$rec = $this->querySortBy($rec, array( "accounts.title" => "desc", "records.type" => "desc" ));
		
		$records['all'] = $this->searchFillTheBlanks($rec->get(), $records, $request->type);
		$records['request'] = $request->all();

		return view('pages.search', compact('records'));
	}

	public function flow(Request $request)
	{
		$records['categories'] = $this->getAllCategoriesAsArray();
		$records['types'] = getTypes( true );
		$records['date'] = $request->date_venc ? $request->date_venc : date("d/m/Y", mktime(0,0,0, date("m")-3, 01, date("Y"))) . " - " . date("d/m/Y", mktime(0,0,0, date("m")+7, 0, date("Y")));

		$rec = Record::query();
		if ( getenv('APP_ENV') == "local"){
			$rec->selectRaw("category_id, strftime('%Y-%m',payment_date) as pay_date, sum(value) as sum_value");
			$rec->groupBy("pay_date")->groupBy("category_id");
		}
		else{
			$rec->selectRaw("category_id, DATE_FORMAT(payment_date, '%Y-%m') as pay_date, sum(value) as sum_value");
			$rec->groupBy("pay_date")->groupBy("category_id");
		}
		list( $rec, $records ) = $this->queryExpiryDate($request, $rec, $records);
		$rec = $this->querySortBy($rec, array( "category_id" => "asc", "payment_date" => "asc" ));
		list( $records['all'], $records['textual_dates'], $records['dates']) = $this->flowFillTheBlanks($rec->get(), $records, $request);

		return view('pages.flow', compact('records'));	
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

	public function queryExpiryDate(Request $request, $rec, $records)
	{
		$date = null;
		if( $request->date_venc ){
			$date = $request->date_venc;
		}
		elseif ( isset($records['date']) ) {
			$date = $records['date'];
		}

		if( $date ){
			preg_match('/(?P<date_venc_start>\d{2}\/\d{2}\/\d{4}) - (?P<date_venc_end>\d{2}\/\d{2}\/\d{4})/', $date, $matches);
			$start = DateTime::createFromFormat( "d/m/Y", $matches['date_venc_start'] );
			$end = DateTime::createFromFormat( "d/m/Y", $matches['date_venc_end'] );
			$rec->whereBetween('records.payment_date', array($start->format("Y-m-d"), $end->format("Y-m-d")));
			$records['request']['date_venc'] = $matches['date_venc_start'] . " - " . $matches['date_venc_end'];
			$records['request']['exp_date_start'] = $matches['date_venc_start'];
			$records['request']['exp_date_end'] = $matches['date_venc_end'];
		}
		return array( $rec, $records );
	}

	public function querySortBy($rec, $sort)
	{
		foreach ($sort as $key => $value) {
    		$rec->orderBy($key, $value);
		}
		return $rec;
	}

	public function searchFillTheBlanks($rec, $records, $req_types = null)
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
			$fill_arr[$r->type][$r->tit] = $r->val;
		}

		return $fill_arr;
	}

	public function flowFillTheBlanks($rec, $records, Request $request)
	{
		setlocale(LC_TIME, 'pt_BR');
		$fill_arr = array();
		if( preg_match('/(?P<payment_date_start>\d{2}\/\d{2}\/\d{4}) - (?P<payment_date_end>\d{2}\/\d{2}\/\d{4})/', $records['date'], $matches) ){
			$start = Carbon::createFromFormat('d/m/Y', $matches['payment_date_start']);
			$end = Carbon::createFromFormat('d/m/Y', $matches['payment_date_end']);
			$interval = DateInterval::createFromDateString('1 month');
			$period = new DatePeriod($start, $interval, $end);
			$dates = array();
			foreach ($period as $dt) {
			    $dates[] = $dt->format("Y-m") ;
			    $dates_title[] = $dt->formatLocalized("%b/%y");
			}

			$invert_cat = array();
			foreach( $records["categories"] as $main_category => $sub_categories ){
				foreach ($sub_categories as $id => $sub_category) {
					foreach ($dates as $date) {
						$fill_arr[$main_category][$id][$date] = 0;
						$invert_cat[$id] = $main_category;
					}
				}
			}
			foreach ($rec as $r) {
				$id = $r->category_id ;
				$fill_arr[$invert_cat[$id]][$id][$r->pay_date] = $r->sum_value;
			}
		}

		return array( $fill_arr, $dates_title , $dates);
	}
}