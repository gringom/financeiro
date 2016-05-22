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
		$this->validateForm($request);

		$account->update($request->all());

		return redirect('/contas');
	}

	public function store(Request $request)
	{
		$this->validateForm($request);

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

	public function validateForm(Request $request)
	{
		$this->validate($request, [
			'title' => 'required|max:15',
		],[
			'title.required' => 'O campo nome da conta é obrigatório',
			'title.max' => 'O campo nome da categoria não pode ter mais que 15 caracteres',
		]);
	}
}
