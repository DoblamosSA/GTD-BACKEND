<?php

namespace App\Http\Controllers;

use Dotenv\Exception\ValidationException;
use Spatie\Permission\Models\Permission;

use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class PermissionController extends Controller
{
    public function index()
    { 
        $permisos = Permission::all();
        return view('Administrador.Autenticacion.Permisos',compact('permisos'));
        
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:permissions,name',
                'guard_name' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['message' => 'Error de validación', 'errors' => $validator->errors()], 422);
            }
            
    
            $permiso = Permission::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ]);
    
            return response()->json(['success' => 'Permiso creado exitosamente']);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = 'Ocurrió un error al intentar guardar el permiso: ' . $e->getMessage();
            return response()->json(['message' => 'Error al guardar el permiso', 'error' => $errorMessage], 500);
        } catch (\Exception $e) {
            $errorMessage = 'Ocurrió un error inesperado: ' . $e->getMessage();
            return response()->json(['message' => 'Error al guardar el permiso', 'error' => $errorMessage], 500);
        }
        
}

    

public function update(Request $request, $id)
{
    try {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name,' . $id,
            'guard_name' => 'required',
        ], [
            'name.unique' => 'Ya existe un permiso con ese nombre.',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['message' => 'Error de validación', 'errors' => $validator->errors()], 422);
        }
        

        $permiso = Permission::find($id);

        if (!$permiso) {
            return response()->json(['message' => 'Permiso no encontrado'], 404);
        }

        $permiso->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
        ]);

        return response()->json(['success' => 'Permiso actualizado exitosamente']);
    } catch (\Illuminate\Database\QueryException $e) {
        $errorMessage = 'Ocurrió un error al intentar actualizar el permiso: ' . $e->getMessage();
        return response()->json(['message' => 'Error al actualizar el permiso', 'error' => $errorMessage], 500);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error al actualizar el permiso', 'error' => $e->getMessage()], 500);
    }
}


public function destroy($id)
{
    try {
        $permiso = Permission::findOrFail($id); // Busca el permiso por ID

        $permiso->delete(); // Elimina el permiso

        return response()->json([
            'success' => true,
            'message' => 'Permiso eliminado exitosamente.',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al eliminar el permiso.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
}
