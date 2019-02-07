<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeletarUsuarioTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function usuario_nao_autenticado()
  {
    $this->delete(route('usuarios.destroy',$this->user->co_seq_usuario))
      ->assertRedirect(route('login'));
  }

  /** @test */
  public function usuario_autenticado_sem_permissao()
  {
    $novo_usuario = factory('App\Models\TbUsuario')->create();
    $this->actingAs($this->user)
      ->delete(route('usuarios.destroy',$novo_usuario->co_seq_usuario))
      ->assertForbidden();
  }

  /** @test */
  public function usuario_autenticado_com_permissao()
  {
    $novo_usuario = factory('App\Models\TbUsuario')->create();
    $this->actingAs($this->userAdmin)
      ->delete(route('usuarios.destroy', $novo_usuario->co_seq_usuario))
      ->assertSessionHasNoErrors()
      ->assertRedirect(route('usuarios.index'));
  }

  /** @test */
  public function autenticado_sem_permissao_lista_deletar()
  {
    $usuario = factory('App\Models\TbUsuario')->create();
    $this->actingAs($this->user)
      ->post(route('usuarios.destroy-list'),['co_usuario' => $usuario->co_seq_usuario])
      ->assertForbidden();
  }

  /** @test */
  public function autenticado_com_permissao_lista_deletar()
  {
    $usuario = factory('App\Models\TbUsuario')->create();
    $this->actingAs($this->userAdmin)
      ->get(route('usuarios.index'));
    $this->actingAs($this->userAdmin)
      ->post(route('usuarios.destroy-list'),['co_usuario' => [$usuario->co_seq_usuario]])
      ->assertSessionHasNoErrors()
      ->assertRedirect(route('usuarios.index'));
  }

  /** @test */
  public function autenticado_com_permissao_usuario_logado()
  {
    $this->actingAs($this->userAdmin)
      ->get(route('usuarios.index'));
    
    $this->actingAs($this->userAdmin)
      ->delete(route('usuarios.destroy',$this->userAdmin->co_seq_usuario))
      ->assertSessionHas('warning','Não é possível excluir usuário logado no sistema.')
      ->assertRedirect(route('usuarios.index'));
  }
}
