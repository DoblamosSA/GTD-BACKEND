<?php

namespace App\Http\Controllers\DepartamentoTI\Licencias;

use App\Http\Controllers\Controller;
use App\Models\InventarioLiencias\Licencias;
use Illuminate\Http\Request;

class LicenciasController extends Controller
{
    public function index()
    {

        $licencias = Licencias::all();
        return view('DepartamentoTI.Licencias.index', compact('licencias'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate(
                [
                    'Tipo_licencia' => 'required|string',
                    'correo_asociado' => 'required|email',
                    'key' => 'nullable|string',
                    'Estado' => 'required|in:Libre,Ocupada',
                ],
                [
                    'Tipo_licencia.required' => 'El campo Tipo de Licencia es obligatorio.',
                    'correo_asociado.required' => 'El campo Correo Asociado es obligatorio.',
                    'correo_asociado.email' => 'El campo Correo Asociado debe ser una dirección de correo electrónico válida.',
                    'Estado.required' => 'El campo Estado es obligatorio.',
                    'Estado.in' => 'El campo Estado debe ser "Libre" o "Ocupada".',
                ]
            );

            //verifiquemos si la key ya existe.

            $existelicencia = Licencias::where('key', $data['key'])->first();
            if ($existelicencia) {
                return response()->json(['error', 'Ya existe una licencia con la misma Key']);
            }

            $licencias = new Licencias;
            $licencias->fill($data);
            $licencias->save();

            return response()->json(['message' => 'Licencia creada correctamente']);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            $errors = $validationException->errors();
            return response()->json(['error' => 'Error de validación', 'errors' => $errors], 422);
        }
    }



    public function actualizarLicencia(Request $request, $id)
    {
        try {
            // Validar los datos del formulario de edición
            $data = $request->validate([
                'Tipo_licencia' => 'required|string',
                'correo_asociado' => 'required|email',
                'key' => 'nullable|string',
                'Estado' => 'required|in:Libre,Ocupada',
            ], [
                'Tipo_licencia.required' => 'El campo Tipo de Licencia es obligatorio.',
                'correo_asociado.required' => 'El campo Correo Asociado es obligatorio.',
                'correo_asociado.email' => 'El campo Correo Asociado debe ser una dirección de correo electrónico válida.',
                'Estado.required' => 'El campo Estado es obligatorio.',
                'Estado.in' => 'El campo Estado debe ser "Libre" o "Ocupada".',
            ]);

            // Buscar la licencia por ID
            $licencia = Licencias::findOrFail($id);

            // Verificar si la key ya existe para otra licencia
            if ($data['key'] !== $licencia->key) {
                $existelicencia = Licencias::where('key', $data['key'])->first();
                if ($existelicencia) {
                    return response()->json(['error' => 'Ya existe una licencia con la misma Key'], 422);
                }
            }

            // Actualizar los datos de la licencia
            $licencia->update($data);

            return response()->json(['message' => 'Licencia actualizada correctamente']);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            $errors = $validationException->errors();



            return response()->json(['error' => 'Error de validación', 'errors' => $errors], 422);
        }
    }



    public function eliminarLicencia($id)
    {
        try {
            // Buscar la licencia por ID
            $licencia = Licencias::findOrFail($id);

            // Eliminar la licencia
            $licencia->delete();

            return response()->json(['message' => 'Licencia eliminada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar la licencia', 'message' => $e->getMessage()], 500);
        }
    }
}
