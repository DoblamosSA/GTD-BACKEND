<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{


    
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|unique:roles,name',
            'permisos' => 'required|array',
            'permisos.*' => 'exists:permissions,id',
        ]);
    
        try {
            $nuevoRol = Role::create([
                'name' => $request->nombre,
                'guard_name' => 'web', // Asegúrate de ajustar esto según tu configuración
            ]);
    
            $permissions = Permission::whereIn('id', $request->permisos)->get();
            $nuevoRol->syncPermissions($permissions); // Usar syncPermissions() para sincronizar permisos
    
            return response()->json(['message' => 'Rol creado con éxito'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el rol', 'error' => $e->getMessage()], 401);
        }
    }
    
        public function update(Request $request, $id)
        {
            $request->validate([
                'nombre' => 'required|string|unique:roles,name,' . $id, // Permite que el nombre sea único excepto para el rol actual
                'permisos' => 'required|array',
                'permisos.*' => 'exists:permissions,id',
            ]);
        
            try {
                $rol = Role::findOrFail($id);
                $rol->name = $request->nombre;
                $rol->save();
        
                $permissions = Permission::whereIn('id', $request->permisos)->get();
                $rol->syncPermissions($permissions);
        
                return response()->json(['message' => 'Rol actualizado con éxito'], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error al actualizar el rol', 'error' => $e->getMessage()], 401);
            }
        }
        
    
        public function destroy($id)
        {
            try {
                $rol = Role::findOrFail($id);
                $rol->delete();
        
                return response()->json(['message' => 'Rol eliminado con éxito']);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error al eliminar el rol', 'error' => $e->getMessage()], 500);
            }
        }
        
    
}
