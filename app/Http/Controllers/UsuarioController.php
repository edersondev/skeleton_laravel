<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use App\Models\TbUsuario;
use App\Models\TbPerfil;
use Yajra\Datatables\Datatables;
use App\Http\Requests\UsuarioRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
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
      $arrData = ['img_profile' => $request->file('img_profile')->store('public/img_profile')];
      $objUsuario->fill($arrData)->save();
    }
  }

  private function resizeImage($image)
  {
    $fullPath = storage_path("app/{$image}");
    $newSize = 200;
    
    $img = ImageManager::make($fullPath);
    $img->resize(null, $newSize, function ($constraint) {
      $constraint->aspectRatio();
    });
    $background = ImageManager::canvas($newSize, $newSize);
    $image_resized = $img->resize($newSize, $newSize, function ($c) {
      $c->aspectRatio();
      $c->upsize();
    });
    $background->insert($image_resized, 'center');
    $background->save($fullPath);
  }
}