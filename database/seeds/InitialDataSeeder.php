<?php

use Illuminate\Database\Seeder;
use App\Models\TbPerfil;
use App\Models\TbUsuario;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
}
