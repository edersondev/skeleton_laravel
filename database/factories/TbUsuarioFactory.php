<?php

use Faker\Generator as Faker;

$factory->define(App\Models\TbUsuario::class, function (Faker $faker) {
  return [
    'ds_nome' => $faker->name,
    'email' => $faker->unique()->safeEmail,
    'password' => '123456',
    'st_ativo' => true,
    'ds_relembrar_token' => str_random(10),
  ];
});
