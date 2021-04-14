<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //Departamentos
      DB::table('departamentos')->insert([
        'nombre'            => 'Gerencia General',
        'descripcion'       => 'Departamento de Gerencia general',
        'encargado'         => 'Gerente general',
        'ubicacion_id'      => 1
      ]);
      
      DB::table('departamentos')->insert([
        'nombre'            => 'Sistemas',
        'descripcion'       => 'Departamento de Sistemas',
        'encargado'         => 'Enc. Sistemas',
        'ubicacion_id'      => 1
      ]);
    }

}
