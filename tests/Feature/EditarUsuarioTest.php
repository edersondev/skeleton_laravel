<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditarUsuarioTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function nao_autenticado_editar_usuario()
  {
    $this->get(route('usuarios.edit',$this->user->co_seq_usuario))
      ->assertStatus(302)
      ->assertRedirect(route('login'));

    $this->put(route('usuarios.update',$this->user->co_seq_usuario),[])
      ->assertStatus(302)
      ->assertRedirect(route('login'));
  }

  /** @test */
  public function autenticado_com_permissao_editar_usuario()
  {
    $arrUsuario = factory('App\Models\TbUsuario')->create()->toarray();
    $this->actingAs($this->userAdmin)
      ->get(route('usuarios.edit',$arrUsuario['co_seq_usuario']))
      ->assertOk();

    $arrUsuario['ds_nome'] = 'Nome editado';
    $this->actingAs($this->userAdmin)
      ->put(route('usuarios.update',$arrUsuario['co_seq_usuario']),$arrUsuario)
      ->assertSessionHasNoErrors()
      ->assertRedirect(route('usuarios.edit',$arrUsuario['co_seq_usuario']));
    
    $this->assertEquals('Nome editado',$arrUsuario['ds_nome']);
  }

  /** @test */
  public function autenticado_sem_permissao_editar_usuario()
  {
    $this->actingAs($this->user)
      ->get(route('usuarios.edit',$this->user->co_seq_usuario))
      ->assertForbidden();
    
    $this->actingAs($this->user)
      ->put(route('usuarios.update',$this->user->co_seq_usuario),[])
      ->assertForbidden();
  }
}
