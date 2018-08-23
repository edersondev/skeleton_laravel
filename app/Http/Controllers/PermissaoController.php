<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TbPerfil;
use App\Models\TbPermissao;

use DB;

class PermissaoController extends Controller {

	public function __construct() {
		$this->middleware([
			//'auth', 
			//'isAdmin'
		]); //isAdmin middleware lets only users with a //specific permission permission to access these resources
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index() {
		$permissions = TbPermissao::all();
		return view('permissoes.index')->with('permissions', $permissions);
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create() {
		$roles = TbPerfil::get();
		return view('permissoes.create')->with('roles', $roles);
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request) {

		$this->validatePermissao($request);

		$result = DB::transaction(function () use ($request) {
			try{
				$permission = new TbPermissao();
				$permission->ds_nome = $request['ds_nome'];
				$permission->save();

				$roles = $request['roles'];
				if (!empty($request['roles'])) { //If one or more role is selected
					foreach ($roles as $role) {
						$r = TbPerfil::where('co_seq_perfil', '=', $role)->firstOrFail(); //Match input role to db record
						$permission = TbPermissao::where('ds_nome', '=', $request['ds_nome'])->first(); //Match input //permission to db record
						$r->givePermissionTo($permission);
					}
				}
				return redirect()->route('permissoes.index')
					->with('success', trans('messages.store'));
			} catch(\Exception $e) {
				return redirect()->back()
          ->withErrors(['danger' => $e->getMessage()]);
			}
		});

		return $result;
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id) {
		return redirect('permissoes');
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit($id) {
		$permission = TbPermissao::findOrFail($id);

		return view('permissoes.edit', compact('permission'));
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, $id) {
		$permission = Permission::findOrFail($id);

		$this->validatePermissao($request);
		
		$input = $request->all();
		$permission->fill($input)->save();

		return redirect()->route('permissions.index')
			->with('flash_message',
			 'Permission'. $permission->name.' updated!');

	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id) {
		$permission = TbPermissao::findOrFail($id);

		//Make it impossible to delete this specific permission 
		if ($permission->ds_nome == "Administer roles & permissions") {
			return redirect()->route('permissions.index')
			->with('flash_message',
			 'Cannot delete this Permission!');
		}

		$permission->delete();

		return redirect()->route('permissao.index')
			->with('success', trans('messages.destroy'));

	}

	private function validatePermissao($request)
	{
		$this->validate($request, [
			'ds_nome'=>'required|max:40',
		]);
	}
}