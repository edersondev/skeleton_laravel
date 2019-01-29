<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\CustomException;

use App\Models\TbPerfil;
use App\Models\TbPermissao;
use Yajra\Datatables\Datatables;
use App\Http\Requests\PerfilRequest;
use DB;

class PerfilController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$permissions = TbPermissao::pluck('ds_nome','co_seq_permissao');
		return view('perfis.index',compact('permissions'));
	}

	public function jsonLista()
  {
		$objPerfil = TbPerfil::query()->with('permissions');
    return Datatables::of($objPerfil)->make(true);
  }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(PerfilRequest $request)
	{
		DB::beginTransaction();
		try{
			$role = new TbPerfil();
			$role->ds_nome = $request['ds_nome'];
			$role->save();

			$permissions = $request['permissions'];
			if($permissions){
				foreach ($permissions as $permission) {
					$p = TbPermissao::where('co_seq_permissao', '=', $permission)->firstOrFail(); 
					$role = TbPerfil::where('ds_nome', '=', $request['ds_nome'])->first(); 
					$role->givePermissionTo($p);
				}
			}
			DB::commit();
			return redirect()->route('perfis.index')->with('success',trans('messages.store'));
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
		$objPerfil = TbPerfil::findOrFail($id);
		return response()->json(['perfil' => $objPerfil, 'permissoes' => $objPerfil->permissions()->pluck('co_permissao')]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(PerfilRequest $request, $id)
	{
		DB::beginTransaction();
		try{
			$role = TbPerfil::findOrFail($id);
			if($role->ds_nome === 'Administrador'){
				throw new CustomException("O perfil 'Administrador' não pode ser editado.",0,'warning');
			}
			$input = $request->except(['permissions']);
			$role->fill($input)->save();

			$p_all = TbPermissao::all();
			foreach ($p_all as $p) {
				$role->revokePermissionTo($p);
			}
			$permissions = $request['permissions'];
			if($permissions){
				foreach ($permissions as $permission) {
					$p = TbPermissao::where('co_seq_permissao', '=', $permission)->firstOrFail();
					$role->givePermissionTo($p);
				}
			}
			DB::commit();
			return redirect()->route('perfis.index')->with('success',trans('messages.update'));
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
			$role = TbPerfil::findOrFail($id);
			if($role->ds_nome === 'Administrador'){
				throw new CustomException("O perfil 'Administrador' não pode ser excluido.",0,'warning');
			}
			$role->delete();
			DB::commit();
			return redirect()->route('perfis.index')->with('success',trans('messages.destroy'));
		} catch(CustomException $e) {
			DB::rollBack();
			return redirect()->back()
				->with($e->getTypeMessage(), $e->getMessage())
				->withInput();
		}
	}

	public function destroyList(Request $request)
	{
		$request->validate([
      'co_perfil' => 'required|array',
      'co_perfil.*' => 'integer'
		]);
		DB::beginTransaction();
    try {
			$affects = 0;
			foreach($request->co_perfil as $co_perfil){
				if($this->destroyRole($co_perfil)){
          $affects++;
        }
			}
			DB::commit();
			if($affects > 0){
        $request->session()->flash('success',trans_choice('messages.destroy_list',$affects));
      }
			return redirect()->route('perfis.index');
		} catch(CustomException $e) {
      DB::rollBack();
			return redirect()->back()
				->with($e->getTypeMessage(), $e->getMessage());
    }
	}

	public function destroyRole($co_perfil)
	{
		$objPerfil = TbPerfil::findOrFail($co_perfil);
		if($objPerfil->ds_nome === 'Administrador'){
			request()->session()->flash('warning', "O perfil 'Administrador' não pode ser excluido.");
      return false;
		}
		return $objPerfil->delete();
	}
}