<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use App\Models\TbPerfil;
use App\Models\TbPermissao;
use Yajra\Datatables\Datatables;
use DB;

class PermissaoController extends Controller
{

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index() {
		$permissions = TbPermissao::all();
		return view('permissoes.index')->with('permissions', $permissions);
	}

	public function jsonLista()
  {
    return Datatables::of(TbPermissao::query())->make(true);
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
		$permissoes_perfil = $permission->roles()->pluck('co_perfil')->toarray();
		return view('permissoes.create', compact('permission','roles','permissoes_perfil'));
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
			$permission->ds_nome = $request['ds_nome'];
			$permission->save();

			$r_all = TbPerfil::all();
			foreach ($r_all as $r) {
				$permission->removeRole($r);
			}

			if (!empty($request['roles'])) {
				foreach ($request['roles'] as $role) {
					$r = TbPerfil::where('co_seq_perfil', '=', $role)->firstOrFail();
					$permission = TbPermissao::where('ds_nome', '=', $request['ds_nome'])->first();
					$r->givePermissionTo($permission);
				}
			}

			DB::commit();
			return redirect()->route('permissoes.index')
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
		try{
			$permission = TbPermissao::findOrFail($id);
			$permission->delete();
			DB::commit();
			return redirect()->route('permissoes.index')
				->with('success', trans('messages.destroy'));
			} catch(CustomException $e) {
				DB::rollBack();
				return redirect()->back()
					->with($e->getTypeMessage(), $e->getMessage());
			}
		
	}

	private function validatePermissao($request)
	{
		$this->validate($request, [
			'ds_nome'=>'required|max:40',
		]);
	}
}