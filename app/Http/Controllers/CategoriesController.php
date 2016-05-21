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
		$category->update($request->all());

		return redirect('/categorias');
	}

	public function store(Request $request)
	{
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
}
