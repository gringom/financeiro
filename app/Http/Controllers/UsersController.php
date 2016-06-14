<?php

namespace App\Http\Controllers;

use Auth;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$users = User::all();

    	return view('users.index', compact('users'));
    }

	public function show(User $user)
	{
    	$user['all_roles'] = $this->getAllRolesAsArray();

		return view('users.edit', compact('user'));
	}

	public function update(Request $request, User $user)
	{
		$user->detachRoles($user->roles);
		$role_id = $request->get('role_id');
		$role = Role::findOrFail( $role_id );
		$user->attachRole($role);

		flash('Conta de usuário atualizada.', 'success');

		return redirect('/usuarios');
	}

	public function removeAccess(User $user)
	{
		$user->detachRoles($user->roles);
		flash('Acessos de usuário removidos.', 'success');

		return redirect('/usuarios');
	}

	public function getAllRolesAsArray()
	{
		$roles_info = Role::all() ;
    	$roles = array();
    	foreach( $roles_info as $role ){
    		$roles[$role->id] = $role->display_name;
    	}

    	return $roles;
	}

	// public function validateForm(Request $request, $account = null)
	// {
	// 	$acc_id = null;
	// 	if( isset( $account->id ) )
	// 	{
	// 		$acc_id = $account->id;
	// 	}

	// 	$this->validate($request, [
	// 		'title' => 'required|unique:accounts,title,'.$acc_id.'|max:15',
	// 	],[
	// 		'title.required' => 'O campo nome da conta é obrigatório',
	// 		'title.unique' => 'Já tem uma conta cadastrada com o mesmo nome',
	// 		'title.max' => 'O campo nome da categoria não pode ter mais que 15 caracteres',
	// 	]);
	// }
}
