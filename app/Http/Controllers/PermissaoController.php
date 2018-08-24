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

		DB::beginTransaction();
		try{
			$permission = new TbPermissao();
			$permission->ds_nome = $request['ds_nome'];
			$permission->save();

			$roles = $request['roles'];
			if (!empty($request['roles'])) {
				foreach ($roles as $role) {
					$r = TbPerfil::where('co_seq_perfil', '=', $role)->firstOrFail();
					$permission = TbPermissao::where('ds_nome', '=', $request['ds_nome'])->first();
					$r->givePermissionTo($permission);
				}
			}
			DB::commit();
			return redirect()->route('permissoes.index')
				->with('success', trans('messages.store'));
		} catch(\Exception $e) {
			DB::rollBack();
			$message = ( env('APP_DEBUG') === true ? $e->getMessage() : trans('messages.error_exception') );
			return redirect()->back()
				->withErrors(['danger' => $message]);
		}
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
		$roles = TbPerfil::get();
		return view('permissoes.create', compact('permission','roles'));
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
		$this->validatePermissao($request);

		DB::beginTransaction();
		try{
			$permission = TbPermissao::findOrFail($id);
			$input = $request->all();
			$permission->fill($input)->save();
			DB::commit();
			return redirect()->route('permissoes.index')
				->with('success', trans('messages.update'));
		} catch(\Exception $e) {
			DB::rollBack();
			$message = ( env('APP_DEBUG') === true ? $e->getMessage() : trans('messages.error_exception') );
			return redirect()->back()
				->withErrors(['danger' => $message]);
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
		try{
			$permission = TbPermissao::findOrFail($id);
			//Make it impossible to delete this specific permission 
			if ($permission->ds_nome == "Administer roles & permissions") {
				return redirect()->route('permissoes.index')
				->with('flash_message',
				'Cannot delete this Permission!');
			}
			$permission->delete();
			DB::commit();
			return redirect()->route('permissoes.index')
				->with('success', trans('messages.destroy'));
		} catch(\Exception $e) {
			DB::rollBack();
			$message = ( env('APP_DEBUG') === true ? $e->getMessage() : trans('messages.error_exception') );
			return redirect()->back()
				->withErrors(['danger' => $message]);
		}
		
	}

	private function validatePermissao($request)
	{
		$this->validate($request, [
			'ds_nome'=>'required|max:40',
		]);
	}
}