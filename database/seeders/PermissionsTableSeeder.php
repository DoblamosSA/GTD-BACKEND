<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
  /**
     * Run the database seeds.
     *
     * @return void
     */

     
    public function run()
    {
        $admin_sistema = Role::create(['name' => 'administrador']);
        $Calidad= Role::create(['name' => 'Calidad']);
        $vortex = Role::create(['name' => 'vortex']);
        $Formaletas = Role::create(['name' => 'Formaletas']);
        $EstruMetalicas = Role::create(['name' => 'Estructuras_Metalicas']);
      


        $admin_sistema->save();
        $Calidad->save();
        $Formaletas->save();
        $vortex->save();
        $Formaletas->save();
        $EstruMetalicas->save();


// Estos son los permisos de la vista modulo ingenieria ingenieria 
        Permission::create(['name' => 'cotizacion.index'])->syncRoles([$Formaletas,$admin_sistema]);
        Permission::create(['name' => 'cotizacion.create'])->syncRoles([$Formaletas,$admin_sistema]);;
        Permission::create(['name' => 'cotizacion.edit'])->syncRoles([$Formaletas,$admin_sistema]);;
        Permission::create(['name' => 'cotizacion.destroy'])->syncRoles([$Formaletas,$admin_sistema]);;


//Esta es la vista de permisos modulo calidad

        Permission::create(['name' => 'informe-partes-magneticas.index'])->syncRoles([$Calidad,$admin_sistema]);
        Permission::create(['name' => 'informe-liquidos-penetrante.index'])->syncRoles([$Calidad,$admin_sistema]);
        Permission::create(['name' => 'informe-ultrasonido.index'])->syncRoles([$Calidad,$admin_sistema]);
        Permission::create(['name' => 'informe-vert-metalica.index'])->syncRoles([$Calidad,$admin_sistema]);


//permisos modulo administrador
        Permission::create(['name' => 'admin.list_users'])->syncRoles([$Calidad,$admin_sistema]);


//permisos vortex
Permission::create(['name' => 'vortexDoblamos.index'])->syncRoles([$vortex,$admin_sistema]);

//estructuras Metalicas

Permission::create(['name' => 'estructurasMetalicas.index'])->syncRoles([$EstruMetalicas,$admin_sistema]);





   
  


    }
}
