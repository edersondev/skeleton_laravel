<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Models\TbUsuario;
use App\Models\TbPerfil;

class CreateTbUsuarioTable extends Migration {

	public function up()
	{
		Schema::create('tb_usuario', function(Blueprint $table) {
			$table->increments('co_seq_usuario');
			$table->string('ds_nome');
			$table->string('email')->unique();
			$table->string('password');
			$table->boolean('st_ativo')->default(false);
			$table->string('ds_relembrar_token', 100)->nullable();
			$table->timestamp('dt_inclusao')->nullable();
			$table->timestamp('dt_atualizacao')->nullable();
			$table->timestamp('dt_exclusao')->nullable();
		});

		$objPerfil = new TbPerfil();
		$objPerfil->ds_nome = 'Administrador';
		$objPerfil->save();

		$objUsuario = TbUsuario::create([
			'ds_nome' => 'Beltrano da Silva',
			'email' => 'admin@teste.com.br',
			'password' => '123456',
			'st_ativo' => true
		]);

		$objUsuario->assignRole($objPerfil->co_seq_perfil);
	}

	public function down()
	{
		Schema::drop('tb_usuario');
	}
}