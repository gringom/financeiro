<?php

namespace App\Http\Controllers;

use Auth;
use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$projects = Project::all();

    	return view('projects.index', compact('projects'));
    }

	public function show(Project $project)
	{
		return view('projects.edit', compact('project'));
	}

	public function update(Request $request, Project $project)
	{
		$this->validateForm($request);

		$project->update($request->all());
		flash('Projeto atualizado.', 'success');

		return redirect('/projetos');
	}

	public function store(Request $request)
	{
		$this->validateForm($request);

		$project = new Project($request->all());
		$project->by(Auth::id());
		$project->save();
		flash('Projeto criado.', 'success');

		return redirect('/projetos');
	}

	public function destroy(Project $project)
	{
		$project->delete();
		flash('Projeto removido.', 'success');

		return redirect('/projetos');
	}

	public function validateForm(Request $request)
	{
		$this->validate($request, [
			'title' => 'required|max:30',
			'year' => 'required',
		],[
			'title.required' => 'O campo Nome do Projeto é obrigatório',
			'title.max' => 'O campo Nome do Projeto não pode ter mais que 30 caracteres',
			'year.required' => 'O campo Ano do Projeto é obrigatório',
		]);
	}
}
