<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\TbPerfil;

abstract class TestCase extends BaseTestCase
{
  use CreatesApplication;

  public $userAdmin;
  public $coPerfilAdmin;

  protected function setUp()
  {
    parent::setUp();
    $this->user = factory('App\Models\TbUsuario')->create();
    $this->userAdmin = factory('App\Models\TbUsuario')->create();
    $this->userAdmin->assignRole($this->createPerfil());
    //$this->withoutExceptionHandling();
  }

  public function createPerfil()
  {
    $objPerfil = new TbPerfil();
		$objPerfil->ds_nome = 'Administrador';
    $objPerfil->save();
    $this->coPerfilAdmin = $objPerfil->co_seq_perfil;
    return $objPerfil->co_seq_perfil;
  }
}
