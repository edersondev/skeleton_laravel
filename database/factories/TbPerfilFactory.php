<?php

use Faker\Generator as Faker;

$factory->define(App\Models\TbPerfil::class, function (Faker $faker) {
  return [
    'ds_nome' => $faker->unique()->name
  ];
});
