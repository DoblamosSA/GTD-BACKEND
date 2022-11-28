<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\RolesNames;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PageController extends Controller
{
    public function list_users()
    {

        $user = auth()->user();

        // get all users with all roles
        $users = User::with('roles')->orderBy('id', 'desc')
            ->withTrashed()->get()->where('id', '!=', $user->id);

        $data = [
            'users'  => $users,
        ];

        return view("admin.list_users", compact('data'));
    }

    public function edit_user($id)
    {
        $user = User::withTrashed()->find($id);
        $roles = Role::all();

        $data = [
            'user'  => $user,
            'roles'  => $roles,
        ];

        return view('admin.edit_user', compact('data'));
    }

    public function create_user()
    {
        $roles = Role::all();

        $data = [
            'roles'  => $roles,
        ];

        return view('admin.create_user',  compact('data'));
    }

    public function update_user(Request $request, $id)
    {
        $input = $request->all();
        $user = User::withTrashed()->find($id);

        // $requestEmail = $input['email'];

        // if ($requestEmail != $user->email) {
        //     $request->validate([
        //         'email' => 'required|email|unique:users'
        //     ]);
        // }

        $user->syncRoles($input['role']);
        $user->update($input);

        return redirect('admin/list_users')->with('success', 'Datos guardados!');
    }

    public function edit_password($id)
    {
        $user = User::withTrashed()->find($id);
        $roles = Role::all();

        $data = [
            'user'  => $user,
        ];

        return view('admin.edit_password', compact('data'));
    }

    public function change_password(Request $request, $id)
    {
        $input = $request->all();
        $user = User::withTrashed()->find($id);

        $request->validate([
            'password' => 'required|min:5|confirmed',
        ]);

        $user->password = bcrypt($input['password']);
        $user->save();

        return redirect('admin/list_users')->with('success', 'Datos guardados!');
    }

    public function store_user(Request $request)
    {
        $request->validate([
            'password' => 'required|min:5|confirmed',
            // 'email' => 'required|email|unique:users'
        ]);

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $user->assignRole(RolesNames::$administrador);

        return redirect('admin/list_users')->with('success', 'Datos guardados!');
    }

    public function disable_user(Request $request, $id)
    {

        $datos = User::find($id);
        $datos->delete();

        return redirect('admin/list_users')->with('success', 'Datos guardados!');
    }

    public function enable_user(Request $request, $id)
    {
        //$datos = User::find($id);
        $datos = User::withTrashed()->find($id);
        $datos->restore();

        return redirect('admin/list_users')->with('success', 'Datos guardados!');
    }

    public function delete_user($id)
    {
        try {
            $datos = User::withTrashed()->find($id);
            $datos->forceDelete();
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() == "23000") { //23000 is sql code for integrity constraint violation
                $errors = array();
                array_push($errors, 'No se puede borrar el registro. Esta siendo usado en la base de datos');

                return redirect()->route('admin.list_users')
                    ->with('errors', $errors);
            }
        }

        return redirect()->route('admin.list_users')
            ->with('success', 'Registro borrado exitosamente');
    }
}
