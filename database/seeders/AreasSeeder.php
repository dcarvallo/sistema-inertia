<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //crear area
      DB::table('areas')->insert([
        'nombre'            => 'Gerencia General',
        'descripcion'       => 'Área de Gerencia General',
        'encargado'         => 'Gerente general',
        'departamento_id'   => 1
      ]);

      DB::table('areas')->insert([
        'nombre'            => 'Sistemas',
        'descripcion'       => 'Área de Sistemas',
        'encargado'         => 'Enc. Sistemas',
        'departamento_id'   => 2
      ]);

    }
}
