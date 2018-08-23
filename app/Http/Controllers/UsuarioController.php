<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TbUsuario;
use App\Models\TbPerfil;

class UsuarioController extends Controller
{
  public function __construct()
  {
		//$this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
		$users = TbUsuario::all(); 
		return view('usuarios.index')->with('users', $users);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
		$roles = TbPerfil::get();
		return view('usuarios.create', ['roles'=>$roles]);
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
	  $this->validateUsuario($request);

	  $user = TbUsuario::create($request->only('email', 'ds_nome', 'password'));

	  $roles = $request['roles'];
	  if (isset($roles)) {
		  foreach ($roles as $role) {
		  $role_r = TbPerfil::where('co_seq_perfil', '=', $role)->firstOrFail();            
		  $user->assignRole($role_r);
		  }
	  }
	  return redirect()->route('usuarios.index')
		  ->with('success', trans('messages.store'));
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
		return redirect('usuarios');
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
		$user = TbUsuario::findOrFail($id);
		$roles = TbPerfil::get();
		return view('usuarios.create', compact('user', 'roles'));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
		$user = TbUsuario::findOrFail($id);

		$this->validateUsuario($request,true,$id);

		$input = $request->only(['ds_nome', 'email', 'password']);
		$roles = $request['roles'];
		$user->fill($input)->save();

		if (isset($roles)) {
			$user->roles()->sync($roles);
		} else {
			$user->roles()->detach();
		}
		
		return redirect()->route('usuarios.index')
			->with('success', trans('messages.update'));
	}

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
		if(auth()->user()->co_seq_usuario == $id){
			return redirect()->route('usuarios.index')
				->with('warning', 'Não é possível excluir usuário logado no sistema.');
		}
	  $user = TbUsuario::findOrFail($id); 
	  $user->delete();

		return redirect()->route('usuarios.index')
			->with('success', trans('messages.destroy'));
  }

	private function validateUsuario($request, $update = false, $id = null)
	{
		$rules = [
			'ds_nome'=>'required|max:120',
		  'email'=>'required|email|unique:tb_usuario',
		  'password'=>'required|min:6|confirmed'
		];
		if($update){
			$rules['email'] = "required|email|unique:tb_usuario,email,{$id},co_seq_usuario";
		}
		$this->validate($request, $rules);
	}
}