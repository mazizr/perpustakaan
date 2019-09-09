<?php

use App\Petugas;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Petugas::class, function (Faker $faker) {
    $gender = $faker->randomElements(['Laki - Laki', 'Perempuan'])[0];
    return [
        'kode_petugas' => $faker->numberBetween($min = 0000, $max = 9999),
        'nama' => $faker->name,
        'jk' => $gender,
        'jabatan' => $faker->jobTitle,  
        'telepon' => $faker->phoneNumber,  
        'alamat' => $faker->address
    ];
});
