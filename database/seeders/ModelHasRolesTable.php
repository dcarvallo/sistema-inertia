<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ModelHasRolesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('model_has_roles')->insert([
        'role_id'     => 1,
        'model_type'  => 'App\Models\User',
        'model_id'    => 1,
      ]);

      for($i=1; $i<=49;$i++){
        DB::table('role_has_permissions')->insert([
          'permission_id'     => $i,
          'role_id'    => 1,
        ]);
      };
      

    }
}
