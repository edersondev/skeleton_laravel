<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CadastrarPerfilTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function usuario_nao_autenticado()
  {
    $this->get(route('perfis.create'))
      ->assertRedirect(route('login'));
  }

  /** @test */
  public function usuario_autenticado_sem_permissao()
  {
    $this->actingAs($this->user)
      ->get(route('perfis.index'))
      ->assertForbidden();
    $this->actingAs($this->user)
      ->post(route('perfis.store'),[])
      ->assertForbidden();
  }

  /** @test */
  public function usuario_autenticado_com_permissao()
  {
    $this->actingAs($this->userAdmin)
      ->get(route('perfis.index'))
      ->assertOk();
    
    $this->actingAs($this->userAdmin)
      ->post(route('perfis.store'),['ds_nome' => 'PerfilTeste'])
      ->assertSessionHasNoErrors()
      ->assertRedirect(route('perfis.index'));
  }

  /** @test */
  public function usuario_autenticado_com_permissao_perfil_existente()
  {
    $this->actingAs($this->userAdmin)
      ->post(route('perfis.store'),['ds_nome' => 'Administrador'])
      ->assertSessionHasErrors();
  }
}
