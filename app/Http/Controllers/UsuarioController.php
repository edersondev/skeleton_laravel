<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use App\Models\TbUsuario;
use App\Models\TbPerfil;
use Yajra\Datatables\Datatables;
use App\Http\Requests\UsuarioRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use DB;

class UsuarioController extends Controller
{

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $arrPerfil = TbPerfil::pluck('ds_nome','co_seq_perfil')->toarray();
		return view('usuarios.index',compact('arrPerfil'));
  }

  public function jsonLista(Request $request)
  {
    $searchInput = [];
    if ( $request->has('search') && !is_null($request->search['value']) ) {
      parse_str($request->search['value'], $searchInput);
    }
    $objUsuario = TbUsuario::query()->with('roles');
    return Datatables::of($objUsuario)
      ->filter(function($query) use ($searchInput){
        if(!empty($searchInput['ds_nome'])){
          $query->where('tb_usuario.ds_nome','ilike',"%{$searchInput['ds_nome']}%");
        }
        if(!empty($searchInput['email'])){
          $query->where('tb_usuario.email',$searchInput['email']);
        }
        if(!empty($searchInput['st_ativo'])){
          $st_ativo = ( $searchInput['st_ativo'] == 1 ? true : false );
          $query->where('tb_usuario.st_ativo',$st_ativo);
        }
        if(!empty($searchInput['dt_inclusao'])){
          $query->where('tb_usuario.dt_inclusao','>=',convertDate($searchInput['dt_inclusao'],'Y-m-d') . ' 00:00:00');
          $query->where('tb_usuario.dt_inclusao','<=',convertDate($searchInput['dt_inclusao'],'Y-m-d') . ' 23:59:59');
        }
        if(!empty($searchInput['co_perfil'])){
          $query->join('ta_model_perfis as mp','tb_usuario.co_seq_usuario','=','mp.model_id');
          $query->where('mp.co_perfil',$searchInput['co_perfil']);
        }
      })
      ->make(true);
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
  public function store(UsuarioRequest $request)
  { 
    DB::beginTransaction();
    try {
      $input = $request->only((new TbUsuario)->getFillable());
      $user = TbUsuario::create($input);
      $roles = $request['roles'];
      if (isset($roles)) {
        foreach ($roles as $role) {
          $role_r = TbPerfil::where('co_seq_perfil', '=', $role)->firstOrFail();
          $user->assignRole($role_r);
        }
      }

      $this->storeImage($request, $user->co_seq_usuario);

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
  public function update(UsuarioRequest $request, $id)
  {
    DB::beginTransaction();
    try {
      $user = TbUsuario::findOrFail($id);
      $input = $request->only((new TbUsuario)->getFillable());
      $user->fill($input)->save();

      $roles = $request['roles'];
      if (isset($roles)) {
        $user->roles()->sync($roles);
      } else {
        $user->roles()->detach();
      }

      $this->storeImage($request, $id);

      DB::commit();

      return redirect()->route('usuarios.edit',$id)
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

  public function destroyList(Request $request)
  {
    $request->validate([
      'co_usuario' => 'required|array',
      'co_usuario.*' => 'integer'
    ]);

    DB::beginTransaction();
    try {
      $affects = 0;
      foreach($request->co_usuario as $co_usuario){
        if($this->destroyUser($co_usuario)){
          $affects++;
        }
      }
      DB::commit();
      if($affects > 0){
        $request->session()->flash('success',trans_choice('messages.destroy_list',$affects));
      }
      return redirect()->route('usuarios.index');
    } catch(CustomException $e) {
      DB::rollBack();
			return redirect()->back()
				->with($e->getTypeMessage(), $e->getMessage());
    }
  }

  private function destroyUser($co_usuario)
  {
    $objUsuario = TbUsuario::findOrFail($co_usuario);
    if(auth()->user()->co_seq_usuario == $co_usuario){
      request()->session()->flash('warning', "Não é possível excluir o usuário '{$objUsuario->ds_nome}', pois o mesmo está logado no sistema.");
      return false;
    }
    return $objUsuario->forceDelete(); // Or ->delete() for the softdelete
  }

  public function destroyImg($id)
  {
    $objUsuario = TbUsuario::findOrFail($id);
    Storage::delete($objUsuario->img_profile);
    $objUsuario->fill(['img_profile'=>null])->save();
    return redirect()->route('usuarios.edit',$id)
      ->with('success', trans('messages.destroy_image'));
  }

  private function storeImage($request, $id)
  {
    $objUsuario = TbUsuario::findOrFail($id);
    if( $request->img_profile ) {
      if($objUsuario->img_profile){
        Storage::delete($objUsuario->img_profile);
      }
      $file = $request->img_profile->store('public/img_profile');
      $this->resizeImage($file);
      $arrData = ['img_profile' => $file];
      $objUsuario->fill($arrData)->save();
    }
  }

  private function resizeImage($image)
  {
    $fullPath = storage_path("app/{$image}");
    $newSize = 250;
    
    $img = Image::make($fullPath);
    $img->resize(null, $newSize, function ($constraint) {
      $constraint->aspectRatio();
    });
    $background = Image::canvas($newSize, $newSize);
    $image_resized = $img->resize($newSize, $newSize, function ($c) {
      $c->aspectRatio();
      $c->upsize();
    });
    $background->insert($image_resized, 'center');
    $background->save($fullPath);
  }
}