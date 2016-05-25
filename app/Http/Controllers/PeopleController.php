<?php

namespace App\Http\Controllers;

use Auth;
use App\Person;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$people = Person::all();

    	return view('people.index', compact('people'));
    }

	public function show(Person $person)
	{
		return view('people.edit', compact('person'));
	}

	public function update(Request $request, Person $person)
	{
		$this->validateForm($request, $person);

		$person->update($request->all());
		flash('Cliente/Fornecedor atualizado.', 'success');

		return redirect('/clientes_fornecedores');
	}

	public function store(Request $request)
	{
		$this->validateForm($request);

		$person = new Person($request->all());
		$person->by(Auth::id());
		$person->save();
		flash('Cliente/Fornecedor criado.', 'success');
		return redirect('/clientes_fornecedores');
	}

	public function destroy(Person $person)
	{
		$person->delete();
		flash('Cliente/Fornecedor removido.', 'success');
		return redirect('/clientes_fornecedores');
	}

	public function validateForm(Request $request, $person = null)
	{
		$per_id = null;
		if( isset( $person->id ) )
		{
			$per_id = $person->id;
		}

		$this->validate($request, [
			'title' => 'required|unique:people,title,'.$per_id.'|max:50',
		],[
			'title.required' => 'O campo Nome do Cliente/Fornecedor é obrigatório',
			'title.unique' => 'Já tem um Cliente/Fornecedor cadastrado com o mesmo nome',
			'title.max' => 'O campo Nome do Cliente/Fornecedor não pode ter mais que 50 caracteres',
		]);
	}
}
