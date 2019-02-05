<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FrontCadastrarUsuarioTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function visualizar_form_cadastro()
  {
    $response = $this->get(route('register'));
    $response->assertOK();
  }

  /** @test */
  public function cadastro_usuario()
  {
    $postData = [
      'ds_nome' => 'Cicrano da Silva Sauro',
      'email' => 'cicranoou@teste.com.br',
      'password' => '123456',
      'password_confirmation' => '123456'
    ];

    $this->post(route('register'),$postData)
      ->assertSessionHasNoErrors();
  }
}
