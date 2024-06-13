<?php

namespace App\Http\Controllers\ProyectosSAP;

use App\Http\Controllers\Controller;
use App\Models\proyectosSAP\proyecto;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProyectosSAPController extends Controller
{
    
    public function ImportarProjectSAP(Request $request)
    {
        try {
            $query = $request->input('cliente');
        
            $client = new Client();
        
            // Realizar la solicitud de inicio de sesión
            $loginUrl = env('URI') . '/Login';
            $loginBody = [
                'CompanyDB' => env('APP_ENV') === 'production' ? env('COMPANYDB_PROD') : env('COMPANYDB_DEV'),
                'Password' => env('PASSWORD'),
                'UserName' => env('USER'),
            ];
        
            $response = $client->post($loginUrl, [
                'json' => $loginBody,
            ]);
        
            $data = json_decode($response->getBody(), true);
            $sessionId = $data['SessionId'];
        
            // Construir el encabezado de la cookie
            $cookie = 'B1SESSION=' . $sessionId . '; ROUTEID=.node4';
        
            // Realizar la consulta de projects
            $businessPartnersUrl = env('URI') . '/Projects';
         
            $response = $client->get($businessPartnersUrl, [
                'headers' => [
                    'Cookie' => $cookie,
                    'Content-Type' => 'application/json',
                    'Expect' => '',
                ],
            ]);
            
            $body = $response->getBody();
            $data = json_decode($body, true);
        
            // Iterar sobre cada proyecto
            foreach ($data['value'] as $project) {
                // Verificar si el proyecto ya existe en la base de datos
                $proyectoSAP = Proyecto::where('Code', $project['Code'])->first();
        
                if ($proyectoSAP) {
                    // El proyecto ya existe, actualizar los datos
                    $proyectoSAP->update([
                        'Name' => $project['Name'],
                        'ValidFrom' => $project['ValidFrom'],
                        'ValidTo' => $project['ValidTo'],
                        'Active' => $project['Active'],
                        'U_DOB_Tipo' => $project['U_DOB_Tipo'],
                    ]);
                } else {
                    // El proyecto no existe, crear uno nuevo
                    Proyecto::create([
                        'Code' => $project['Code'],
                        'Name' => $project['Name'],
                        'ValidFrom' => $project['ValidFrom'],
                        'ValidTo' => $project['ValidTo'],
                        'Active' => $project['Active'],
                        'U_DOB_Tipo' => $project['U_DOB_Tipo'],
                    ]);
                }
            }
        
            return response()->json(['message' => 'Proyectos importados exitosamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
