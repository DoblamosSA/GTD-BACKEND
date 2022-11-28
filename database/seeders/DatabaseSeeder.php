<?php

namespace Database\Seeders;
use App\Models\CotizacionEstructuras;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Utils\RolesNames;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
              // \App\Models\User::factory(10)->create();
              $this->call([
                PermissionsTableSeeder::class,
                UsersTableSeeder::class,          
            ]);

           
    }
}
