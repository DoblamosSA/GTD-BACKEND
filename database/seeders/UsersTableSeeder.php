<?php

namespace Database\Seeders;

use App\Models\User;
use App\Utils\RolesNames;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as FacadesDB;

class UsersTableSeeder extends Seeder
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
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'Area' => 'Formaletas'
        ]);


        $user = User::where('email','admin@gmail.com')->get()->first();
        $user->assignRole(RolesNames::$administrador);

    


    }
}
