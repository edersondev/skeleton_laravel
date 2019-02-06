<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\TbUsuario;

class AutenticacaoTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function redirecionamento_login_area_restrita()
  {
    $response = $this->get(route('default'));
    $response->assertStatus(302);
  }

  /** @test */
  public function usuario_visualizar_form_login()
  {
    $response = $this->get(route('login'))
      ->assertSuccessful()
      ->assertViewIs('auth.login');
  }

  /** @test */
  public function check_login()
  {
    $this->post(route('login'),['email'=>$this->user->email,'password'=>'123456'])
      ->assertSessionHasNoErrors()
      ->assertRedirect(route('default'));
  }

  /** @test */
  public function falha_no_login()
  {
    $this->post(route('login'),['email' => 'email@qualquer.com.br','password' => '123456'])
      ->assertSessionHasErrors();
  }
}
