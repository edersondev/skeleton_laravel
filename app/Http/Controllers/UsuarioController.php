<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use App\Models\TbUsuario;
use App\Models\TbPerfil;
use Yajra\Datatables\Datatables;
use DB;

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

  public function jsonLista()
  {
    return Datatables::of(TbUsuario::query())->make(true);
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
    
    DB::beginTransaction();
    try {
      $user = TbUsuario::create($request->only('email', 'ds_nome', 'password'));
      $roles = $request['roles'];
      if (isset($roles)) {
        foreach ($roles as $role) {
          $role_r = TbPerfil::where('co_seq_perfil', '=', $role)->firstOrFail();
          $user->assignRole($role_r);
        }
      }

      DB::commit();

      return redirect()->route('usuarios.index')
      ->with('success', trans('messages.store'));
      
    } catch(CustomException $e) {
      DB::rollBack();
			return redirect()->back()
				->with($e->getTypeMessage(), $e->getMessage());
    }

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
    //dd($user);
		$roles = TbPerfil::get();
    $usuario_perfis = $user->roles()->pluck('co_perfil')->toarray();
		return view('usuarios.create', compact('user', 'roles','usuario_perfis'));
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
    $this->validateUsuario($request,true,$id);

    DB::beginTransaction();
    try {
      $user = TbUsuario::findOrFail($id);
      $input = $request->only(['ds_nome', 'email', 'password','st_ativo']);
      $input['st_ativo'] = ( isset($input['st_ativo']) && $input['st_ativo'] == 1 ? true : false );
      if(is_null($input['password'])){
        unset($input['password']);
      }
      $user->fill($input)->save();

      $roles = $request['roles'];
      if (isset($roles)) {
        $user->roles()->sync($roles);
      } else {
        $user->roles()->detach();
      }

      DB::commit();

      return redirect()->route('usuarios.index')
        ->with('success', trans('messages.update'));
      } catch(CustomException $e) {
        DB::rollBack();
        return redirect()->back()
          ->with($e->getTypeMessage(), $e->getMessage());
      }
		
	}

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    DB::beginTransaction();
    try {
      if(auth()->user()->co_seq_usuario == $id){
        throw new CustomException('Não é possível excluir usuário logado no sistema.',0,'warning');
      }
      $user = TbUsuario::findOrFail($id); 
      //$user->delete();
      $user->forceDelete();

      DB::commit();

      return redirect()->route('usuarios.index')
      ->with('success', trans('messages.destroy'));
      
    } catch(CustomException $e) {
      DB::rollBack();
			return redirect()->back()
				->with($e->getTypeMessage(), $e->getMessage());
    }
		
  }

	private function validateUsuario($request, $update = false, $id = null)
	{
		$rules = [
			'ds_nome'=>'required|max:120',
		  'email'=>'required|email|unique:tb_usuario'
    ];
    if(!empty($request['password'])){
      $rules['password'] = 'required|min:6|confirmed';
    }
		if($update){
			$rules['email'] = "required|email|unique:tb_usuario,email,{$id},co_seq_usuario";
		}
		$this->validate($request, $rules);
	}
}