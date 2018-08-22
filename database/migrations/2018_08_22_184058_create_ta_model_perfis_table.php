<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaModelPerfisTable extends Migration {

	public function up()
	{
		Schema::create('ta_model_perfis', function(Blueprint $table) {
			$table->integer('co_perfil')->unsigned();
			$table->string('model_type');
			$table->integer('co_usuario')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('ta_model_perfis');
	}
}