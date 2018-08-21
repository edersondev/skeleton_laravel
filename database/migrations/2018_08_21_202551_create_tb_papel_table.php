<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbPapelTable extends Migration {

	public function up()
	{
		Schema::create('tb_papel', function(Blueprint $table) {
			$table->increments('co_seq_papel');
			$table->string('ds_nome');
			$table->string('ds_nome_guard');
			$table->timestamp('dt_inclusao')->nullable();
			$table->timestamp('dt_atualizacao')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('tb_papel');
	}
}