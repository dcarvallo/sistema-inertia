<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CargosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //cargos
      DB::table('cargos')->insert([
        'nombre'            => 'Gerente General',
        'descripcion'       => 'Gerente de la empresa',
        'nivel'             => 1,
        'dependiente'       => 1,
        'area_id'           => 1
      ]);

      DB::table('cargos')->insert([
        'nombre'            => 'Enc. Sistemas',
        'descripcion'       => 'Personal encargado de Dpto. de Sistemas',
        'nivel'             => 3,
        'dependiente'       => 1,
        'area_id'           => 2
      ]);

    }
}
