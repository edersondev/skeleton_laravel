<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\TbUsuario;

class CadastrarUsuarioTest extends TestCase
{
  use RefreshDatabase;

  public $postData = [
    'ds_nome' => 'Usuário Teste',
    'email' => 'usuario@teste.com.br',
    'password' => '123456',
    'password_confirmation' => '123456',
    'st_ativo' => 1
  ];
  
  /** @test */
  public function usuario_pode_acessar_lista_usuarios()
  {
    $this->checar_acesso_usuario_rota('usuarios.index');
  }

  /** @test */
  public function usuario_pode_visualizar_form()
  {
    $this->checar_acesso_usuario_rota('usuarios.create');
  }

  /** @test */
  public function submit_form_usuario_sem_permissao()
  {
    $this->actingAs($this->user)
      ->post(route('usuarios.store'),[])
      ->assertForbidden();
  }

  /** @test */
  public function submit_form_criar_usuario_sem_perfil()
  {
    $this->actingAs($this->userAdmin)
      ->post(route('usuarios.store'),$this->postData)
      ->assertSessionHasNoErrors()
      ->assertRedirect(route('usuarios.index'));
  }

  /** @test */
  public function checar_email_unico()
  {
    $this->postData['email'] = $this->user->email;
    $this->actingAs($this->userAdmin)
      ->post(route('usuarios.store'),$this->postData)
      ->assertSessionHasErrors();
  }

  /** @test */
  public function submit_form_criar_usuario_com_perfil()
  {
    $this->postData['roles'] = [$this->coPerfilAdmin];
    $this->actingAs($this->userAdmin)
      ->post(route('usuarios.store'),$this->postData)
      ->assertSessionHasNoErrors()
      ->assertRedirect(route('usuarios.index'));
  }

  /** @test */
  public function submit_form_criar_usuario_com_imagem()
  {
    Storage::fake('public/img_profile');

    $file = UploadedFile::fake()->image('avatar_user.jpg', 1, 1);

    $this->postData['img_profile'] = $file;
    $this->actingAs($this->userAdmin)
      ->post(route('usuarios.store'),$this->postData)
      ->assertSessionHasNoErrors()
      ->assertRedirect(route('usuarios.index'));
    
    $objUsuario = TbUsuario::where('email',$this->postData['email'])->first();
    $pathImage = "public/img_profile/{$file->hashName()}";

    $this->assertEquals($pathImage, $objUsuario->img_profile);
    
    Storage::assertExists($pathImage);
  }

  public function checar_acesso_usuario_rota($nome_rota)
  {
    // usuário comum
    $response = $this->actingAs($this->user)
      ->get(route($nome_rota))
      ->assertForbidden();
    
    // usuário com perfil de administrador
    $responseAdmin = $this->actingAs($this->userAdmin)
      ->get(route($nome_rota))
      ->assertOk();
  }
}
