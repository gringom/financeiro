<?php

namespace App\Http\Controllers;

use Auth;
use App\Account;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$accounts = Account::all();

    	return view('accounts.index', compact('accounts'));
    }

	public function show(Account $account)
	{
		return view('accounts.edit', compact('account'));
	}

	public function update(Request $request, Account $account)
	{
		$account->update($request->all());

		return redirect('/contas');
	}

	public function store(Request $request)
	{
		$account = new Account($request->all());
		$account->by(Auth::id());
		$account->save();
		return redirect('/contas');
	}

	public function destroy(Account $account)
	{
		$account->delete();
		return redirect('/contas');
	}
}
