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
		$this->validateForm($request);

		$category->update($request->all());

		return redirect('/categorias');
	}

	public function store(Request $request)
	{
		$this->validateForm($request);

		$category = new Category($request->all());
		$category->by(Auth::id());
		$category->save();

		return redirect('/categorias');
	}

	public function destroy(Category $category)
	{
		$category->delete();
		return redirect('/categorias');
	}

	public function validateForm(Request $request)
	{
		$this->validate($request, [
			'title' => 'required|max:20',
			'type' => 'required',
		],[
			'title.required' => 'O campo nome da categoria é obrigatório',
			'title.max' => 'O campo nome da categoria não pode ter mais que 20 caracteres',
			'type.required' => 'O campo tipo de categoria é obrigatório',
		]);
	}
}
