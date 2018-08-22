<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('ta_perfil_permissao', function(Blueprint $table) {
			$table->foreign('co_permissao')->references('co_seq_permissao')->on('tb_permissao')
						->onDelete('cascade')
						->onUpdate('no action');
		});
		Schema::table('ta_perfil_permissao', function(Blueprint $table) {
			$table->foreign('co_perfil')->references('co_seq_perfil')->on('tb_perfil')
						->onDelete('cascade')
						->onUpdate('no action');
		});
		Schema::table('ta_model_perfis', function(Blueprint $table) {
			$table->foreign('co_perfil')->references('co_seq_perfil')->on('tb_perfil')
						->onDelete('cascade')
						->onUpdate('no action');
		});
		Schema::table('ta_model_perfis', function(Blueprint $table) {
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
		Schema::table('ta_perfil_permissao', function(Blueprint $table) {
			$table->dropForeign('ta_perfil_permissao_co_permissao_foreign');
		});
		Schema::table('ta_perfil_permissao', function(Blueprint $table) {
			$table->dropForeign('ta_perfil_permissao_co_perfil_foreign');
		});
		Schema::table('ta_model_perfis', function(Blueprint $table) {
			$table->dropForeign('ta_model_perfis_co_perfil_foreign');
		});
		Schema::table('ta_model_perfis', function(Blueprint $table) {
			$table->dropForeign('ta_model_perfis_co_usuario_foreign');
		});
		Schema::table('ta_model_permissoes', function(Blueprint $table) {
			$table->dropForeign('ta_model_permissoes_co_permissao_foreign');
		});
		Schema::table('ta_model_permissoes', function(Blueprint $table) {
			$table->dropForeign('ta_model_permissoes_co_usuario_foreign');
		});
	}
}