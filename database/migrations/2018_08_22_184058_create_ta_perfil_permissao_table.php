<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaPerfilPermissaoTable extends Migration {

	public function up()
	{
		Schema::create('ta_perfil_permissao', function(Blueprint $table) {
			$table->integer('co_permissao')->unsigned();
			$table->integer('co_perfil')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('ta_perfil_permissao');
	}
}