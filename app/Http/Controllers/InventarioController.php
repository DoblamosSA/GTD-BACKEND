<?php

namespace App\Http\Controllers\DepartamentoTI;

use App\Http\Controllers\Controller;
use App\Models\Areas\Areas;
use App\Models\EmpledoSAP;
use App\Models\InventarioEquipos\Inventarioequipo;
use App\Models\InventarioLiencias\Licencias;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Node\FunctionNode;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $licenciasdoblamos = Licencias::all();
        $empleados = EmpledoSAP::all();
        $areas = Areas::all();
        $inventario = Inventarioequipo::all();
        return view('DepartamentoTI.InventarioTI.inventario', compact('licenciasdoblamos', 'areas', 'empleados', 'inventario'));
    }




    public function AlmacenarDispositivo(Request $request)
    {
        try {
            $dispositivo = $request->validate(
                [
                    'nombre_equipo' => 'required',
                    'modelo' => 'required',
                    'marca' => 'required',
                    'estado' => 'required',
                    'serial' => 'required',
                    'sistema_operativo' => 'required',
                    'procesador' => 'required',
                    'memoria_ram' => 'required',
                    'hdd' => 'required',
                    'sede' => 'required',
                    'piso' => 'required',
                    'area' => 'required',
                    'fecha_garantia' => 'required',
                    'fecha_compra' => 'required',
                    'numero_facturasap' => 'required',
                    'codigo_Activosap' => 'required',
                    'codigoactivoSaG' => 'required',
                    'Asignado_A' => 'required'
                ],


            );

            // Crear una nueva instancia del modelo Inventarioequipo
            $almacenarbd = new Inventarioequipo;

            // Asignar los valores validados del dispositivo al modelo
            $almacenarbd->nombre_equipo = $dispositivo['nombre_equipo'];
            $almacenarbd->modelo = $dispositivo['modelo'];
            $almacenarbd->marca = $dispositivo['marca'];
            $almacenarbd->estado = $dispositivo['estado'];
            $almacenarbd->serial = $dispositivo['serial'];
            $almacenarbd->sistema_operativo = $dispositivo['sistema_operativo'];
            $almacenarbd->procesador = $dispositivo['procesador'];
            $almacenarbd->memoria_ram = $dispositivo['memoria_ram'];
            $almacenarbd->hdd = $dispositivo['hdd'];
            $almacenarbd->sede = $dispositivo['sede'];
            $almacenarbd->piso = $dispositivo['piso'];
            $almacenarbd->area = $dispositivo['area'];
            $almacenarbd->fecha_garantia = $dispositivo['fecha_garantia'];
            $almacenarbd->fecha_compra = $dispositivo['fecha_compra'];
            $almacenarbd->numero_facturasap = $dispositivo['numero_facturasap'];
            $almacenarbd->codigo_Activosap = $dispositivo['codigo_Activosap'];
            $almacenarbd->codigoactivoSaG = $dispositivo['codigoactivoSaG'];
            $almacenarbd->Asignado_A = $dispositivo['Asignado_A'];

            // Guardar el dispositivo en la base de datos
            $almacenarbd->save();

            return response()->json(['message' => 'Dispositivo almacenado correctamente'], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            $errors = $validationException->errors();
            return response()->json(['error' => 'Error de validación', 'errors' => $errors], 422);
        }
    }
}
