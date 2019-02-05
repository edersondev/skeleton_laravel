<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Password;

class ResetarSenhaTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function esqueceu_senha()
  {
    $response = $this->get(route('password.request'));
    $response->assertOk();
  }

  /** @test */
  public function enviar_link_resetar_senha()
  {
    $this->post(route('password.email'),['email' => $this->user->email])
      ->assertSessionHasNoErrors();
  }

  /** @test */
  public function form_resetar_senha()
  {
    $token = Password::broker()->createToken($this->user);
    $response = $this->get(route('password.reset',$token));
    $response->assertOK();
  }

  /** @test */
  public function post_form_resetar_senha()
  {
    $token = Password::broker()->createToken($this->user);
    $postData = [
      'email' => $this->user->email,
      'password' => '123456789',
      'password_confirmation' => '123456789',
      'token' => $token
    ];
    $this->post(route('password.update'),$postData)
      ->assertSessionHasNoErrors();
  }
}
