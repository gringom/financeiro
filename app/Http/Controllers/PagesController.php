<?php

namespace App\Http\Controllers;

use App\Record;
use App\Account;
use App\Category;
use App\Person;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Requests;

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

	public function search()
	{
		$records = $this->getAllAsArray();

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
}