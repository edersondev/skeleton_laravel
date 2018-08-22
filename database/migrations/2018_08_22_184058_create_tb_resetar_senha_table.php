<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbResetarSenhaTable extends Migration {

	public function up()
	{
		Schema::create('tb_resetar_senha', function(Blueprint $table) {
			$table->string('ds_email');
			$table->string('ds_token');
			$table->timestamp('dt_inclusao')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('tb_resetar_senha');
	}
}