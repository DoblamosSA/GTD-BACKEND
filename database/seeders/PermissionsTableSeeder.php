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
        $EstruMetalicas = Role::create(['name' => 'Estructuras Metalicas']);
        $Costosnocalidad = Role::create(['name'=>'Costos No calidad']);
        $Servicios      =Role::create(['Servicios']);


        $admin_sistema->save();
        $Calidad->save();
        $Formaletas->save();
        $vortex->save();
        $Formaletas->save();
        $EstruMetalicas->save();
        $Costosnocalidad->save();
     	$Servicios->save();


// Estos son los permisos de la vista modulo ingenieria Formaletas
        Permission::create(['name' => 'cotizacion.index'])->syncRoles([$Formaletas,$admin_sistema]);
        Permission::create(['name' => 'cotizacion.create'])->syncRoles([$Formaletas,$admin_sistema]);
        Permission::create(['name' => 'cotizacion.edit'])->syncRoles([$Formaletas,$admin_sistema]);
        Permission::create(['name' => 'cotizacion.destroy'])->syncRoles([$Formaletas,$admin_sistema]);
        Permission::create(['name' => 'export.export'])->syncRoles([$Formaletas,$admin_sistema]); 

//Estos son los permisos de vista vortex
        Permission::create(['name' => 'vortexDoblamos.index'])->syncRoles([$vortex,$admin_sistema]);
        Permission::create(['name' => 'vortexDoblamos.create'])->syncRoles([$vortex,$admin_sistema]);
        Permission::create(['name' => 'vortexDoblamos.edit'])->syncRoles([$vortex,$admin_sistema]);
        Permission::create(['name' => 'vortex.destroy'])->syncRoles([$vortex,$admin_sistema]); 
        Permission::create(['name' => 'vortex.export'])->syncRoles([$vortex,$admin_sistema]); 
     


//Estos son los permisos de Estructuras Metalicas
        Permission::create(['name' => 'estructurasMetalicas.index'])->syncRoles([$EstruMetalicas,$admin_sistema]);
        Permission::create(['name' => 'estructurasMetalicas.create'])->syncRoles([$EstruMetalicas,$admin_sistema]);
        Permission::create(['name' => 'estructurasMetalicas.edit'])->syncRoles([$EstruMetalicas,$admin_sistema]);
        Permission::create(['name' => 'estructurasMetalicas.destroy'])->syncRoles([$EstruMetalicas,$admin_sistema]); 
        Permission::create(['name' => 'estructurasMetalicas.export'])->syncRoles([$EstruMetalicas,$admin_sistema]); 
    




//Esta es la vista de permisos modulo calidad

        Permission::create(['name' => 'informe-partes-magneticas.index'])->syncRoles([$Calidad,$admin_sistema,$Costosnocalidad]);
        Permission::create(['name' => 'informe-partes-magneticas.edit'])->syncRoles([$Calidad,$admin_sistema,$Costosnocalidad]);
        Permission::create(['name' => 'informe-partes-magneticas.show'])->syncRoles([$Calidad,$admin_sistema,$Costosnocalidad]);
        Permission::create(['name' => 'informe-partes-magneticas.create'])->syncRoles([$Calidad,$admin_sistema,$Costosnocalidad]);
        Permission::create(['name' => 'informe-partes-magneticas.destroy'])->syncRoles([$Calidad,$admin_sistema,$Costosnocalidad]);

        //ultra sonido
        Permission::create(['name' => 'informe-liquidos-penetrante.index'])->syncRoles([$Calidad,$admin_sistema,$Costosnocalidad]);
        Permission::create(['name' => 'informe-ultrasonido.index'])->syncRoles([$Calidad,$admin_sistema,$Costosnocalidad]);
        Permission::create(['name' => 'informe-vert-metalica.index'])->syncRoles([$Calidad,$admin_sistema,$Costosnocalidad]);

        //Esta es la vista de costos de no calidad
        Permission::create(['name' => 'Costo-No-Calidad.index'])->syncRoles([$Costosnocalidad,$admin_sistema]);
        Permission::create(['name' => 'Costo-No-Calidad.store'])->syncRoles([$Costosnocalidad,$admin_sistema]);
        Permission::create(['name' => 'Coso-No-Calidad.create'])->syncRoles([$Costosnocalidad,$admin_sistema]);
        Permission::create(['name' => 'Costo-No-Calidad.edit'])->syncRoles([$Costosnocalidad,$admin_sistema]);
        Permission::create(['name' => 'Costo-No-Calidad.update'])->syncRoles([$Costosnocalidad,$admin_sistema]);
        Permission::create(['name' => 'Costo-No-Calidad.destroy'])->syncRoles([$admin_sistema,$Costosnocalidad]);
        Permission::create(['name' => 'Costo-No-Calidad.export'])->syncRoles([$Costosnocalidad,$admin_sistema]);
        Permission::create(['name' => 'Costo-No-Calidad.Informecnc'])->syncRoles([$Costosnocalidad,$admin_sistema]);

        //permisos modulo administrador
        Permission::create(['name' => 'admin.list_users'])->syncRoles([$admin_sistema,$Costosnocalidad]);
        Permission::create(['name' => 'ClientesSap.index'])->syncRoles([$admin_sistema,$EstruMetalicas,$vortex,$Formaletas]);





   
  


    }
}
