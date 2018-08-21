<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('ta_papel_permissao', function(Blueprint $table) {
			$table->foreign('co_permissao')->references('co_seq_permissao')->on('tb_permissao')
						->onDelete('cascade')
						->onUpdate('no action');
		});
		Schema::table('ta_papel_permissao', function(Blueprint $table) {
			$table->foreign('co_papel')->references('co_seq_papel')->on('tb_papel')
						->onDelete('cascade')
						->onUpdate('no action');
		});
		Schema::table('ta_model_papeis', function(Blueprint $table) {
			$table->foreign('co_papel')->references('co_seq_papel')->on('tb_papel')
						->onDelete('cascade')
						->onUpdate('no action');
		});
		Schema::table('ta_model_papeis', function(Blueprint $table) {
			$table->foreign('co_usuario')->references('co_seq_usuario')->on('tb_usuario')
						->onDelete('cascade')
						->onUpdate('no action');
		});
		Schema::table('ta_model_permissoes', function(Blueprint $table) {
			$table->foreign('co_permissao')->references('co_seq_permissao')->on('tb_permissao')
						->onDelete('cascade')
						->onUpdate('no action');
		});
		Schema::table('ta_model_permissoes', function(Blueprint $table) {
			$table->foreign('co_usuario')->references('co_seq_usuario')->on('tb_usuario')
						->onDelete('cascade')
						->onUpdate('no action');
		});
	}

	public function down()
	{
		Schema::table('ta_papel_permissao', function(Blueprint $table) {
			$table->dropForeign('ta_papel_permissao_co_permissao_foreign');
		});
		Schema::table('ta_papel_permissao', function(Blueprint $table) {
			$table->dropForeign('ta_papel_permissao_co_papel_foreign');
		});
		Schema::table('ta_model_papeis', function(Blueprint $table) {
			$table->dropForeign('ta_model_papeis_co_papel_foreign');
		});
		Schema::table('ta_model_papeis', function(Blueprint $table) {
			$table->dropForeign('ta_model_papeis_co_usuario_foreign');
		});
		Schema::table('ta_model_permissoes', function(Blueprint $table) {
			$table->dropForeign('ta_model_permissoes_co_permissao_foreign');
		});
		Schema::table('ta_model_permissoes', function(Blueprint $table) {
			$table->dropForeign('ta_model_permissoes_co_usuario_foreign');
		});
	}
}