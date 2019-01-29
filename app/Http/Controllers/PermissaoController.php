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
		$perfis = TbPerfil::pluck('ds_nome','co_seq_perfil');
		return view('permissoes.index',compact('perfis'));
	}

	public function jsonLista()
  {
		$objPermissao = TbPermissao::query()->with('roles');
    return Datatables::of($objPermissao)->make(true);
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
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$objPermissao = TbPermissao::findOrFail($id);
		return response()->json(['permissao' => $objPermissao, 'perfis' => $objPermissao->roles()->pluck('co_perfil')]);
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

	public function destroyList(Request $request)
	{
		$request->validate([
      'co_permissao' => 'required|array',
      'co_permissao.*' => 'integer'
		]);

		DB::beginTransaction();
    try {
			$affects = 0;
			foreach($request->co_permissao as $co_permissao){
				$objPermissao = TbPermissao::findOrFail($co_permissao);
				$objPermissao->delete();
				$affects++;
			}
			DB::commit();
			return redirect()->route('permissoes.index')
				->with('success', trans_choice('messages.destroy_list',$affects));
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