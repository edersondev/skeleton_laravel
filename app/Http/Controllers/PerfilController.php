<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TbPerfil;
use App\Models\TbPermissao;
use DB;

class PerfilController extends Controller {

	public function __construct() {
		$this->middleware([
			//'auth', 
			//'isAdmin'
		]);//isAdmin middleware lets only users with a //specific permission permission to access these resources
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$roles = TbPerfil::all();
		return view('perfis.index')->with('roles', $roles);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$permissions = TbPermissao::all();
		return view('perfis.create', ['permissions'=>$permissions]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
	
		$this->validate($request, [
			'ds_nome'=>'required|unique:tb_perfil|max:10',
			'permissions' =>'required',
			]
		);

		DB::beginTransaction();
		try{
			$role = new TbPerfil();
			$role->ds_nome = $request['ds_nome'];
			$role->save();

			$permissions = $request['permissions'];
			foreach ($permissions as $permission) {
				$p = TbPermissao::where('co_seq_permissao', '=', $permission)->firstOrFail(); 
				$role = TbPerfil::where('ds_nome', '=', $request['ds_nome'])->first(); 
				$role->givePermissionTo($p);
			}
			DB::commit();
			return redirect()->route('perfis.index')->with('success',trans('messages.store'));
		} catch(\Exception $e) {
			DB::rollBack();
			$message = ( env('APP_DEBUG') === true ? $e->getMessage() : trans('messages.error_exception') );
			return redirect()->back()
				->with('danger',$message)
				->withInput();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		return redirect('perfis');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$role = TbPerfil::findOrFail($id);
		$permissions = TbPermissao::all();
		$perfil_permissoes = $role->permissions()->pluck('co_permissao')->toarray();
		return view('perfis.create', compact('role', 'permissions','perfil_permissoes'));
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
		$this->validate($request, [
			"ds_nome'=>'required|max:10|unique:tb_perfil,ds_nome,{$id},co_seq_perfil",
			'permissions' =>'required',
		]);

		DB::beginTransaction();
		try{
			$role = TbPerfil::findOrFail($id);
			$input = $request->except(['permissions']);
			$role->fill($input)->save();

			$p_all = TbPermissao::all();
			foreach ($p_all as $p) {
				$role->revokePermissionTo($p);
			}
			$permissions = $request['permissions'];
			foreach ($permissions as $permission) {
				$p = TbPermissao::where('co_seq_permissao', '=', $permission)->firstOrFail();
				$role->givePermissionTo($p);
			}
			DB::commit();
			return redirect()->route('perfis.index')->with('success',trans('messages.update'));
		} catch(\Exception $e) {
			DB::rollBack();
			$message = ( env('APP_DEBUG') === true ? $e->getMessage() : trans('messages.error_exception') );
			return redirect()->back()
				->with('danger',$message)
				->withInput();
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
			$role->delete();
			DB::commit();
			return redirect()->route('perfis.index')->with('success',trans('messages.destroy'));
		} catch(\Exception $e) {
			DB::rollBack();
			$message = ( env('APP_DEBUG') === true ? $e->getMessage() : trans('messages.error_exception') );
			return redirect()->back()
				->with('danger',$message)
				->withInput();
		}
	}
}