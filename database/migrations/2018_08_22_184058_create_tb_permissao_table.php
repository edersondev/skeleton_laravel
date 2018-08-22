<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbPermissaoTable extends Migration {

	public function up()
	{
		Schema::create('tb_permissao', function(Blueprint $table) {
			$table->increments('co_seq_permissao');
			$table->string('ds_nome');
			$table->string('ds_nome_guard');
			$table->timestamp('dt_inclusao')->nullable();
			$table->timestamp('dt_atualizacao')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('tb_permissao');
	}
}