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
		$this->validateForm($request, $account);

		$account->update($request->all());
		flash('Conta atualizada.', 'success');

		return redirect('/contas');
	}

	public function store(Request $request)
	{
		$this->validateForm($request);

		$account = new Account($request->all());
		$account->by(Auth::id());
		$account->save();
		flash('Conta criada.', 'success');

		return redirect('/contas');
	}

	public function destroy(Account $account)
	{
		$account->delete();
		flash('Conta removida.', 'success');

		return redirect('/contas');
	}

	public function validateForm(Request $request, $account = null)
	{
		$acc_id = null;
		if( isset( $account->id ) )
		{
			$acc_id = $account->id;
		}

		$this->validate($request, [
			'title' => 'required|unique:accounts,title,'.$acc_id.'|max:15',
		],[
			'title.required' => 'O campo nome da conta é obrigatório',
			'title.unique' => 'Já tem uma conta cadastrada com o mesmo nome',
			'title.max' => 'O campo nome da categoria não pode ter mais que 15 caracteres',
		]);
	}
}
