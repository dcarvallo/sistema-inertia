<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //crear empresa
      DB::table('empresas')->insert([
        'nombre'            => 'Sistema Base',
        'descripcion'       => 'Descripcion empresa',
        'rubro'             => 'Tecnologia',
        'nit'               => 159753456,
        'propietario'       => 'Juan Perez',
        'mision'            => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ad aliquid accusamus saepe earum temporibus nobis ipsum minus voluptas quam accusantium quaerat, eos, pariatur eveniet cumque! Aspernatur rerum nesciunt blanditiis architecto.',
        'vision'            => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor quis quasi veniam perferendis sint doloremque impedit sunt dignissimos explicabo quam!',
        'direccion'         => 'calle falsa 1234',
        'email'             => 'empresa@erp.com',
        'telefono'          => '64-12345',
        'fecha_creacion'    => now()
      ]);

      //crear ubicacion
      DB::table('ubicaciones')->insert([
        'nombre'            => 'Ubicacion 1',
        'descripcion'       => 'Descripcion de ubicacion 1',
        'locacion'          => 'calle falsa 123',
        'empresa_id'    => 1
      ]);

      
    }
}
