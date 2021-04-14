<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
        'name' => 'Administrador',
        'nombres' => 'Administrador',
        'username' => 'admin',
        'email' => 'admin@sistema.com',
        'password' => Hash::make('admin'),
        'activo' => 1,
        'fotografia' => 'usuariodef/avatar.png',
      ]);

      DB::table('users')->insert([
        'name' => 'Carlos Perez',
        'nombres' => 'Carlos ',
        'apellidos' => 'Perez',
        'username' => 'cperez',
        'email' => 'cperez@sistema.com',
        'password' => Hash::make('Passw0rd'),
        'activo' => 1,
        'fotografia' => 'usuariodef/avatar.png',
      ]);

      User::factory(40)->create();
    } 
}
