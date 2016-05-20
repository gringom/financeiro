<?php

namespace App\Http\Controllers;

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
}