<?php

namespace App\Http\Controllers;

use Auth;
use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$categories = Category::all();

    	return view('categories.index', compact('categories'));
    }

	public function show(Category $category)
	{
		return view('categories.edit', compact('category'));
	}

	public function update(Request $request, Category $category)
	{
		$this->validateForm($request, $category);

		$category->update($request->all());
		flash('Categoria atualizada.', 'success');

		return redirect('/categorias');
	}

	public function store(Request $request)
	{
		$this->validateForm($request);

		$category = new Category($request->all());
		$category->by(Auth::id());
		$category->save();
		flash('Categoria criada.', 'success');

		return redirect('/categorias');
	}

	public function destroy(Category $category)
	{
		$category->delete();
		flash('Categoria removida.', 'success');
		return redirect('/categorias');
	}

	public function validateForm(Request $request, $category = null)
	{
		$cat_id = null;
		if( isset( $category->id ) )
		{
			$cat_id = $category->id;
		}

		$this->validate($request, [
			'title' => 'required|unique:categories,title,'.$cat_id.'|max:20',
			'type' => 'required',
		],[
			'title.required' => 'O campo nome da categoria é obrigatório',
			'title.unique' => 'Já tem uma categoria cadastrada com o mesmo nome',
			'title.max' => 'O campo nome da categoria não pode ter mais que 20 caracteres',
			'type.required' => 'O campo tipo de categoria é obrigatório',
		]);
	}
}
