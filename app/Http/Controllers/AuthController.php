<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller


{


    //autenticacion login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }
    }


    //registro de usuarios
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'password' => 'required|min:8|confirmed',
                'Nombre_Empleado' => 'required',
                'role' => 'required',
            ], [
                'name.required' => 'El campo Usuario es obligatorio.',
                'password.required' => 'El campo Contraseña es obligatorio.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
                'Nombre_Empleado.required' => 'El campo Nombre completo empleado es obligatorio.',
                'role.required' => 'El campo Rol es obligatorio.',
            ]);
            
            if ($validatedData['password'] !== $request->input('password_confirmation')) {
                return response()->json(['message' => 'Las contraseñas no coinciden'], 422);
            }
            
            $user = User::where('name', $validatedData['name'])->first();
            if ($user) {
                return response()->json(['message' => 'Error, el usuario ya existe'], 422);
            }
    
            $user = User::create([
                'name' => $validatedData['name'],
                'password' => Hash::make($validatedData['password']),
                'Nombre_Empleado' => $validatedData['Nombre_Empleado'],
                'usersap' => $request->input('usersap'), // Agrega este campo
                'usersappassword' => $request->input('usersappassword'), // Agrega este campo
                'email' => $request->input('email'),
                'usuarioaprobador' => $request->input('usuarioaprobador')
            ]);
    
            $role = Role::where('name', $validatedData['role'])->first();
            if ($role) {
                $user->syncRoles([$role]);
            }
    
            return response()->json(['message' => 'Usuario registrado exitosamente'], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Maneja errores de validación
            $errors = $e->validator->errors();
            return response()->json(['errors' => $errors], 422);
        } catch (\Exception $e) {
            // Maneja otras excepciones
            return response()->json(['message' => 'Error al registrar el usuario: ' . $e->getMessage()], 500);
        }
    }

    
    

    
    //Cerrar sesion del aplicativo
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            // Revoke all user tokens
            $user->tokens()->delete();

            return response()->json(['message' => 'Sesión cerrada exitosamente'], 200);
        } else {
            return response()->json(['message' => 'No se encontró ningún usuario autenticado'], 401);
        }
    }

    public function assignRole(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($validatedData['user_id']);
        $role = Role::findOrFail($validatedData['role_id']);

        $user->assignRole($role);

        return response()->json(['message' => 'Rol asignado al usuario exitosamente']);
    }


    public function usuarios() {
        $users = User::all();
        $roles = Role::all();
        return view('Administrador.Autenticacion.usuarios', compact('users', 'roles'));
    }
    


        //vista para crear usuarios

            public function registrarusuarios(){
                $roles = Role::all();

                $data = [
                    'roles'  => $roles,
                ];
        
             
                return view('Administrador.Autenticacion.Registrar_usuarios',compact('data'));
                
            }

            public function Roles(){

                $roles = Role::with('permissions')->get();
                $permisos = Permission::all();
                return view('Administrador.Autenticacion.Roles',compact('permisos','roles'));
            }
        
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
  
    
            public function eliminarUsuario($id) {
                $user = User::find($id);
                
                if (!$user) {
                  return response()->json(['message' => 'Usuario no encontrado'], 404);
                }
              
                $user->delete();
              
                return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
              }
            


            
              public function actualizarUsuario(Request $request, $id)
              {
                  // Find the user by ID
                  $user = User::find($id);
              
                  if (!$user) {
                      return response()->json(['message' => 'Usuario no encontrado'], 404);
                  }
                  if ($user->name !== $request->name && User::where('name', $request->name)->exists()) {
                    return response()->json(['message' => ' No se puede actualizar el usuario. ya existe un usuario con el mismo nombre'], 422);
                }
                 
                  // Find the role
                  $role = Role::where('name', $request->role)->first();
              
                  if (!$role) {
                      return response()->json(['message' => 'Error, el rol especificado no existe'], 422);
                  }
              
                  // Update user information
                  $user->update([
                      'name' => $request->name,
                      'Nombre_Empleado' => $request->Nombre_Empleado,
                  ]);
              
                  // Sync user's roles
                  $user->syncRoles([$role->name]); // Note: Pass the role name instead of the role instance
              
                  return response()->json(['message' => 'Usuario actualizado correctamente'], 200);
              }




            public function listusers($id) {
                $user = User::findOrFail($id);
                    $roles = Role::all();
                    
                return response()->json([
                    'user' => $user,
                    'roles' => $roles
                ]);
            }


            public function editarusuarios($id){
                $roles = Role::all();
                $user = User::findOrFail($id); // Obtener el usuario específico por su ID
                return view('Administrador.Autenticacion.edit', compact('roles', 'user'));
            }
            
              
            
        public function resetUserPassword(Request $request, $id)
        {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }

            $validator = Validator::make($request->all(), [
                'password' => 'required|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Error de validación', 'errors' => $validator->errors()], 422);
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['success' => 'Contraseña actualizada correctamente'], 200);

        }
}