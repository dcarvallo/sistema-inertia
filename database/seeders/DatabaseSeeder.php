<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->call([
        UsuariosSeeder::class,
        PermisosTableSeeder::class,
        RoleSeederTable::class,
        ModelHasRolesTable::class,
        EmpresaSeeder::class,
        DepartamentosSeeder::class,
        AreasSeeder::class,
        CargosSeeder::class,
      ]);    
      // \App\Models\User::factory(10)->create();
    }
}
