<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaPapelPermissaoTable extends Migration {

	public function up()
	{
		Schema::create('ta_papel_permissao', function(Blueprint $table) {
			$table->integer('co_permissao')->unsigned();
			$table->integer('co_papel')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('ta_papel_permissao');
	}
}