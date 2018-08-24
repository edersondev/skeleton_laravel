<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaModelPermissoesTable extends Migration {

	public function up()
	{
		Schema::create('ta_model_permissoes', function(Blueprint $table) {
			$table->integer('co_permissao')->unsigned();
			$table->string('model_type');
			$table->integer('model_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('ta_model_permissoes');
	}
}