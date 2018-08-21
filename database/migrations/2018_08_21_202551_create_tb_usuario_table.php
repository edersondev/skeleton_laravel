<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbUsuarioTable extends Migration {

	public function up()
	{
		Schema::create('tb_usuario', function(Blueprint $table) {
			$table->increments('co_seq_usuario');
			$table->string('ds_nome');
			$table->string('ds_email')->unique();
			$table->string('ds_senha');
			$table->boolean('st_ativo');
			$table->string('ds_relembrar_token', 100)->nullable();
			$table->timestamp('dt_inclusao')->nullable();
			$table->timestamp('dt_atualizacao')->nullable();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('tb_usuario');
	}
}