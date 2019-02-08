<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditarPerfilTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function usuario_nao_autenticado()
  {
    $objPerfil = factory('App\Models\TbPerfil')->create();
    $this->get(route('perfis.index'))
      ->assertRedirect(route('login'));
    $this->put(route('perfis.update',$objPerfil->co_seq_perfil))
      ->assertRedirect(route('login'));
  }

  /** @test */
  public function usuario_autenticado_sem_permissao()
  {
    $this->actingAs($this->user)
      ->get(route('perfis.index'))
      ->assertForbidden();
    
    $objPerfil = factory('App\Models\TbPerfil')->create();
    $this->actingAs($this->user)
      ->get(route('perfis.edit',$objPerfil->co_seq_perfil))
      ->assertForbidden();
    
    $this->actingAs($this->user)
      ->put(route('perfis.update',$objPerfil->co_seq_perfil),[])
      ->assertForbidden();
  }

  /** @test */
  public function usuario_autenticado_com_permissao()
  {
    $this->actingAs($this->userAdmin)
      ->get(route('perfis.index'))
      ->assertOk();
    
    $objPerfil = factory('App\Models\TbPerfil')->create();
    $this->actingAs($this->userAdmin)
      ->get(route('perfis.edit',$objPerfil->co_seq_perfil))
      ->assertOk();
    
    $new_name = $objPerfil->ds_nome . '_editado';
    $this->actingAs($this->userAdmin)
      ->put(route('perfis.update',$objPerfil->co_seq_perfil),['ds_nome' => $new_name])
      ->assertSessionHasNoErrors()
      ->assertRedirect(route('perfis.index'));
    $objPerfil->refresh();
    $this->assertEquals($new_name,$objPerfil->ds_nome);
  }

  /** @test */
  public function usuario_autenticado_com_permissao_perfil_existente()
  {
    $objPerfil = factory('App\Models\TbPerfil')->create();
    $this->actingAs($this->userAdmin)
      ->put(route('perfis.update',$objPerfil->co_seq_perfil),['ds_nome' => 'Administrador'])
      ->assertSessionHasErrors();
  }
}
