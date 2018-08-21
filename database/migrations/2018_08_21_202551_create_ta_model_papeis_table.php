<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaModelPapeisTable extends Migration {

	public function up()
	{
		Schema::create('ta_model_papeis', function(Blueprint $table) {
			$table->integer('co_papel')->unsigned();
			$table->string('ds_tipo_model');
			$table->integer('co_usuario')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('ta_model_papeis');
	}
}