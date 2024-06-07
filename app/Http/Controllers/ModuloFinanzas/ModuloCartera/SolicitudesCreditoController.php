<?php

namespace App\Http\Controllers\ModuloFinanzas\ModuloCartera;

use App\Http\Controllers\Controller;
use App\Models\CarteraDoblamos\Creditos\Solicitudes_Credito;
use App\Events\NuevaSolicitudCreditoEvent;
use App\Mail\AprobacionCarterafMail;
use App\Mail\AprobacionCreditoBeratungfMail;
use App\Mail\AprobacionsagrilafMail;
use App\Mail\CorreoPrueba;
use App\Mail\DocumentosAdjuntosMail;
use App\Mail\EstadosSolicitudCreditoMail;
use App\Mail\NotificacionSoliCreditoapMauroMail;
use App\Mail\NotificacionSoliCreditoaprobadaasesorMail;
use App\Mail\NotificacionSoliCreditoaprobadapersoGerenciaMail;
use App\Mail\NotificacionSoliCreditoAsesorMail;
use App\Mail\NotificacionSoliCreditonuevacarteraMail;
use App\Mail\NotificacionSoliCreditorechazadaberatungMail;
use App\Mail\NotificacionSoliCreditorechazadaporcarteraMail;
use App\Mail\NotificacionSoliCreditoreGerenciarechazadaMail;
use App\Models\CarteraDoblamos\GestionCartera\Cuentasporpagar;
use App\Mail\SolicitudCreditoRechazadoMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SolicitudCreditoMail;
use App\Models\Asesores;
use App\Models\CarteraDoblamos\Creditos\ComentariosSolicitudesCredito;
use Illuminate\Support\Facades\Storage;
use App\Models\ComentarioSolicitudCredito;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class SolicitudesCreditoController extends Controller
{


    //esto retorna la vista del modulo de cartera

    public function index()
    {
		$cuentasporpa = Cuentasporpagar::all();
        return view('ModuloFinanzas.ModuloCartera.index',compact('cuentasporpa'));
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////



    public function solicitudesCreditoaprobadas()
    {
        $soliAprobadas = Solicitudes_Credito::where('Estado_Final', 'Aprobado')->get();
        return view('ModuloFinanzas.ModuloCartera.Solicitudes-credito-aprobadas', compact('soliAprobadas'));
    }

    public function Solicitudesrechazadas()
    {
        $soliRechazadas = Solicitudes_Credito::where('Estado_Final', 'Rechazado')->get();
        return view('ModuloFinanzas.ModuloCartera.Solicitudes-credito-rechazadas', compact('soliRechazadas'));
    }


    public function solicitudesCreditoNuevas()
    {

        $solid = Solicitudes_Credito::where('Estado_Final', 'En proceso')->get();
        return view('ModuloFinanzas.ModuloCartera.Solicitudes-credito', compact('solid'));
    }




    //este metodo guarda la informacion enviada por el cliente desde el portal de solicitudes.
    public function SolicitudesCreditostore(Request $request)
    {
        try {
            $this->validateRequest($request);
    
            // Validar la presencia de todos los documentos
            $requiredDocuments = [
                'Documento_Consentimiento_inf' => 'Consentimiento Informado',
                'Documento_Certificado_Bancario' => 'Certificado Bancario',
                'Documento_Referencia_Comercial' => 'Referencia Comercial',
                'Documento_Cedula' => 'Documento Cedula',
                'Documento_Rut' => 'Documento Rut',
                'Documento_Camara_Comercio' => 'Camara de comercio',
                'Documento_Declaracion_Renta' => 'Documento declaración de renta',
                'Documento_pagare' => 'Documento Pagare'
            ];
            
            foreach ($requiredDocuments as $documentKey => $documentName) {
                if (!$request->hasFile($documentKey)) {
                    return $this->errorResponse("El documento $documentName es obligatorio", 400);
                }
            }
    
            // Subir los documentos y obtener las rutas
            $documentos = [];
    
            // Validar y procesar cada documento
            foreach ($requiredDocuments as $documentKey => $documentName) {
                $uploadedDocument = $request->file($documentKey);
                if (!$uploadedDocument || $uploadedDocument->getClientOriginalExtension() !== 'pdf') {
                    return $this->errorResponse("El documento $documentName no es un PDF o no se proporcionó", 400);
                }
    
                $documentos[$documentKey] = $uploadedDocument->store('public/documentos');
            }
    
            // Solo si todos los documentos son PDF, creamos y guardamos el modelo
            $radicado = Str::random(27);
            $solicitudCredito = $this->createSolicitudCredito($request, $radicado, $documentos);
    
            // Disparar el evento a Pusher para visualizar en tiempo real
            event(new NuevaSolicitudCreditoEvent($solicitudCredito));
    
            // Obtener el ID del asesor de la solicitud recién creada
            $asesorId = $solicitudCredito->asesor_id;
    
            // Recuperar el modelo del asesor
            $asesor = Asesores::find($asesorId);
            $correoAsesor = $asesor->correo_asesor;
    
            // Enviar notificaciones de la nueva solicitud
            $envioCarteraSagri = ['analista.cartera@doblamos.com', 'elkin.gutierrez@doblamos.com', 'oficial.cumplimiento@doblamos.com', $correoAsesor];
    
            Mail::to($request->input('correo'))->send(new SolicitudCreditoMail(
                $request->input('Nombre_Empresa_Persona'),
                $request->input('Nit'),
                $request->input('correo'),
                $request->input('Monto_Solicitado'),
                $request->input('Plazo_Credito_Meses'),
                $request->input('Aceptacion_Politica_Datos_Personales'),
                $radicado,
            ));
    
            Mail::to($envioCarteraSagri)->send(new NotificacionSoliCreditonuevacarteraMail(
                $request->input('Nombre_Empresa_Persona'),
                $request->input('Nit'),
                $request->input('Monto_Solicitado'),
                $request->input('Plazo_Credito_Meses'),
                $request->input('Aceptacion_Politica_Datos_Personales'),
                $radicado,
            ));
    
            // Guardar el radicado en un archivo
            $filename = 'radicado-doblamos-credito.txt';
            Storage::put($filename, $radicado);
    
            // Continuar con la respuesta al usuario
            return $this->successResponse($solicitudCredito, $radicado, $filename);
        } catch (QueryException $ex) {
            // Manejar el error de la base de datos
            return $this->errorResponse('Error en la base de datos', 500, $ex->getMessage());
        } catch (\Exception $ex) {
            // Manejar otros errores internos
            return $this->errorResponse('Error interno del servidor', 500, $ex->getMessage());
        }
    }
    



    private function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Nombre_Empresa_Persona' => ['required', 'string'],
            'Nit' => ['required', 'string'],
            'correo' => ['required', 'email'],
            'Monto_Solicitado' => ['required', 'numeric'],
            'Plazo_Credito_Meses' => ['required', 'string'],
            'Aceptacion_Politica_Datos_Personales' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validación fallida');
        }
    }


    private function createSolicitudCredito(Request $request, $radicado, $documentos)
    {
        $solicitudCredito = new Solicitudes_Credito();
        $solicitudCredito->fill([
            'Nombre_Empresa_Persona' => $request->input('Nombre_Empresa_Persona'),
            'Nit' => $request->input('Nit'),
            'correo' => $request->input('correo'),
            'Monto_Solicitado' => $request->input('Monto_Solicitado'),
            'Plazo_Credito_Meses' => $request->input('Plazo_Credito_Meses'),
            'Aceptacion_Politica_Datos_Personales' => $request->input('Aceptacion_Politica_Datos_Personales'),
            'Estado_Final' => 'En proceso',
            'radicado' => $radicado,
            'asesor_id' => $request->input('asesor_id')
        ]);

        // Asignar las rutas de documentos al modelo
        $solicitudCredito->fill($documentos);

        // Guardar el modelo en la base de datos
        $solicitudCredito->save();

        return $solicitudCredito;
    }

    private function successResponse($solicitudCredito, $radicado, $filename)
    {
        return response()->json([
            'message' => 'Solicitud de crédito creada con éxito.',
            'solicitudCredito' => $solicitudCredito,
            'radicado' => $radicado,
        ], 201)->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function errorResponse($message, $statusCode, $errorDetails = null)
    {
        $response = [
            'message' => $message,
            'status' => $statusCode,
        ];

        if ($errorDetails !== null) {
            $response['error_details'] = $errorDetails;
        }

        return response()->json($response, $statusCode);
    }




    public function consultaEstadoSolicitud(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'radicado' => [
                    'required',
                    'string',
                    Rule::exists('solicitudes__creditos', 'radicado'),
                ],
                'Nit' => ['required', 'string'],
            ], [
                'radicado.exists' => 'El radicado es inválido.',
                'Nit.exists' => 'El NIT es inválido.',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $radicado = $request->input('radicado');
            $nit = $request->input('Nit');

            // Validar que el radicado existe
            $solicitudCredito = Solicitudes_Credito::where('radicado', $radicado)->first();

            if (!$solicitudCredito) {
                return response()->json(['error' => 'Solicitud no encontrada'], 404);
            }

            // Validar que el NIT coincida con la solicitud
            if ($solicitudCredito->Nit !== $nit) {
                return response()->json(['errors' => ['Nit' => ['El Nit no coincide con la solicitud']]], 400);
            }

            return response()->json([
                'message' => 'Estado de la solicitud de crédito',
                'solicitudCredito' => $solicitudCredito,
            ], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['error' => 'Error en la base de datos: ' . $ex->getMessage()], 500);
        }
    }





    public function aprobarSagrilaft($id)
    {
        // Lógica para aprobar en Sagrilaft
        $solicitud = Solicitudes_Credito::findOrFail($id);

        if ($solicitud->Estado_Sagrilaft === 'Pendiente') {
            $solicitud->Estado_Sagrilaft = 'Aprobado';
            $solicitud->usuario_AprobadorSagrilaft_id = auth()->user()->id;
            $solicitud->save();

            $nombreSolicitante = $solicitud->Nombre_Empresa_Persona;
            $numeroRadicado = $solicitud->radicado;

            // Enviar la notificación de aprobación en Sagrilaft usando colas
            $destinatarios = ['analista.cartera@doblamos.com', 'elkin.gutierrez@doblamos.com'];

            Mail::to($destinatarios)->send(new AprobacionsagrilafMail(
                $nombreSolicitante,
                $numeroRadicado
            ));

            return response()->json(['message' => 'Solicitud aprobada en Sagrilaft']);
        }

        return response()->json(['error' => 'La solicitud ya ha sido aprobada o rechazada en Sagrilaft'], 400);
    }

    public function aprobarCartera($id)
    {
        // Encuentra la solicitud de crédito por su ID
        $solicitud = Solicitudes_Credito::findOrFail($id);

        // Verificar si Beratung ya ha aprobado
        if ($solicitud->Estado_Sagrilaft !== 'Aprobado') {
            return response()->json(['error' => 'No puedes aprobar en cartera hasta que sagrilaft haya aprobado.'], 400);
        }

        // Verifica que el estado de Cartera esté pendiente
        if ($solicitud->Estado_Cartera === 'Pendiente') {
            // Actualiza el estado de Cartera a Aprobado
            $solicitud->Estado_Cartera = 'Aprobado';

            // Asigna el ID del usuario que aprueba en Cartera
            $solicitud->usuario_AprobadorCartera_id = auth()->user()->id;

            // Guarda los cambios en la base de datos
            $solicitud->save();
            $nombreSolicitante = $solicitud->Nombre_Empresa_Persona;
            $numeroRadicado = $solicitud->radicado;

            //se envia notificacion a beretung de que cartera ya aprobo
            $destinatarios = ['daniel.pemberthy@doblamos.com'];

            Mail::to($destinatarios)->send(new AprobacionCarterafMail(
                $nombreSolicitante,
                $numeroRadicado
            ));

            return response()->json(['message' => 'Solicitud aprobada en Cartera']);
        }

        // Si el estado no estaba pendiente, muestra un mensaje de error
        return response()->json(['error' => 'La solicitud ya ha sido aprobada o rechazada en Cartera']);
    }




    public function aprobarBeratung($id)
    {
        try {
            // Recuperar la solicitud de crédito desde la base de datos
            $solicitudCredito = Solicitudes_Credito::findOrFail($id);

            // Verificar si Cartera ya aprobó
            if ($solicitudCredito->Estado_Cartera !== 'Aprobado') {
                return response()->json(['error' => 'No puedes enviar documentos por correo hasta que Cartera haya aprobado.'], 400);
            }

            if ($solicitudCredito->Estado_Beratung === 'Pendiente') {
                $solicitudCredito->Estado_Beratung = 'Aprobado';
                $solicitudCredito->usuario_Aprobadorberatung_id = auth()->user()->id;
                $solicitudCredito->save();

                // Obtener el nombre del solicitante desde la base de datos
                $nombreSolicitante = $solicitudCredito->Nombre_Empresa_Persona;
                // Obtener el número de radicado desde la base de datos
                $numeroRadicado = $solicitudCredito->radicado;
                $montosolicitado = $solicitudCredito->Monto_Solicitado;
                $montoaprobado = $solicitudCredito->Monto_Aprobado;
                $plazo = $solicitudCredito->Plazo_Credito_Meses;
                $id = $solicitudCredito->id;
                $id_usuarioMauro = 74;
                $id_usuarioLuisochoa = 75;

                // Obtener el comentario del usuario que aprobó
                $comentarioAprobador = $solicitudCredito->comentarios()
                    ->where('user_id', auth()->user()->id)
                    ->latest()
                    ->value('comentario');

                // Obtener el último comentario sin crear uno nuevo
                $ultimoComentario = $solicitudCredito->comentarios()
                    ->latest()
                    ->first();

                // Agregar el comentario a la solicitud de crédito solo si existe
                if ($ultimoComentario) {
                    $comentarioAprobador = $ultimoComentario->comentario;
                }

                // Obtener las rutas de los documentos directamente desde el modelo
                $documentos = [
                   
                    'Documento_Certificado_Bancario',
                    'Documento_Referencia_Comercial',
                    'Documento_Declaracion_Renta',
                ];
                // Construir las rutas completas de los documentos
                $documentAttachments = [];
                foreach ($documentos as $documento) {
                    $documentAttachments[$documento] = storage_path("app/public/{$solicitudCredito->{$documento}}");
                }

                // Corregir las rutas para eliminar la duplicación de "public"
                $documentAttachments = array_map(function ($ruta) {
                    return str_replace('/public/public/', '/public/', $ruta);
                }, $documentAttachments);

              
                $correogerencialuis = ['gerenciasabaneta@doblamos.com','david.ochoa@doblamos.com'];
                // Enviar correo con documentos adjuntos
                Mail::to($correogerencialuis)->send(new DocumentosAdjuntosMail(
                    $documentAttachments,
                    $nombreSolicitante,
                    $numeroRadicado,
                    $montoaprobado,
                    $montosolicitado,
                    $plazo,
                    $id,
                    $id_usuarioLuisochoa,
                    $comentarioAprobador
                ));

                return response()->json(['message' => 'Aprobado en beratung, Documentos enviados a gerencia correo con éxito.']);
            }

            return response()->json(['error' => 'La solicitud ya ha sido aprobada o rechazada en Beratung'], 400);
        } catch (\Exception $ex) {
            // Manejar errores
            return response()->json(['error' => 'Error interno del servidor', 'details' => $ex->getMessage()], 500);
        }
    }



    public function aprobarGerencia($id)
    {
        try {
            // Lógica para aprobar en Gerencia
            $solicitud = Solicitudes_Credito::findOrFail($id);

            // Verificar si Beratung ya ha aprobado
            if ($solicitud->Estado_Beratung !== 'Aprobado') {
                throw new \Exception('No puedes aprobar en Gerencia hasta que Beratung haya aprobado.');
            }

            // Verificar el estado de Gerencia
            if ($solicitud->Estado_Gerencia === 'Pendiente') {
                // Aprobar en Gerencia
                $solicitud->Estado_Gerencia = 'Aprobado';
                $solicitud->Estado_Final = 'Aprobado';
                $solicitud->usuario_AprobadorGerencia_id = auth()->user()->id;
                $solicitud->save();

                // Agregar mensajes de depuración
                \Log::info('Solicitud aprobada en Gerencia');

                $nombreSolicitante = $solicitud->Nombre_Empresa_Persona;
                $numeroRadicado = $solicitud->radicado;
                $montoaprobado = $solicitud->Monto_Solicitado;
                $plazo = $solicitud->Plazo_Credito_Meses;

                $destinatarios = ['analista.cartera@doblamos.com', 'elkin.gutierrez@doblamos.com'];
                // Agregar mensajes de depuración
                \Log::info('Nombre: ' . $nombreSolicitante);
                \Log::info('Radicado: ' . $numeroRadicado);
                \Log::info('Monto Aprobado: ' . $montoaprobado);
                \Log::info('Plazo Aprobado: ' . $plazo);

                //Enviar notificacion de aprobacion de gerencia a cartera.
                Mail::to($destinatarios)->send(new NotificacionSoliCreditoaprobadapersoGerenciaMail(
                    $nombreSolicitante,
                    $numeroRadicado,
                    $montoaprobado,
                    $plazo
                ));

                return response()->json(['message' => 'Solicitud aprobada en Gerencia']);
            }

            return response()->json(['error' => 'La solicitud ya ha sido aprobada o rechazada en Gerencia'], 400);
        } catch (\Exception $e) {
            // Agregar mensaje de depuración
            \Log::error('Error al aprobar en Gerencia: ' . $e->getMessage());

            // Devolver un error HTTP 500
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }



    public function aprobarDesdeCorreogerenciasolicitud($id, $numeroRadicado, $usergerencia)
    {
        try {
            Log::info('ID recibido en el controlador: ' . $id);
            Log::info('Número de Radicado recibido en el controlador: ' . $numeroRadicado);
    
            // Verificar si la solicitud existe
            $solicitud = Solicitudes_Credito::find($id);
    
            if (!$solicitud) {
                Log::error('Solicitud no encontrada');
                return response()->json(['error' => 'Solicitud no encontrada'], 404);
            }
    
            Log::info('Solicitud encontrada: ' . json_encode($solicitud));
    
            // Verificar si Beratung ya ha aprobado
            if ($solicitud->Estado_Beratung !== 'Aprobado') {
                throw new \Exception('No puedes aprobar en Gerencia hasta que Beratung haya aprobado.');
            }
    
            // Obtener el ID del usuario que aprobó en Gerencia
            $aprobadorGerenciaId = $solicitud->usuario_Aprobadorgerencia_id;
    
            // Obtener el nombre del usuario directamente de la base de datos
            $aprobadorGerencia = User::find($aprobadorGerenciaId);
    
            // Obtener el nombre del usuario aprobador de Gerencia si existe
            $nombreAprobadorGerencia = $aprobadorGerencia ? $aprobadorGerencia->Nombre_Empleado : 'Usuario Desconocido';
    
            // Verificar si la solicitud ya ha sido aprobada por Gerencia
            if ($solicitud->Estado_Gerencia === 'Aprobado') {
                throw new \Exception('La solicitud ya ha sido aprobada por ' . $nombreAprobadorGerencia);
            }
    
            // Validar que el número de radicado enviado coincida con el de la solicitud
            if ($solicitud->radicado !== $numeroRadicado) {
                Log::error('El número de radicado no coincide con la solicitud.');
                return response()->json(['error' => 'El número de radicado no coincide con la solicitud.'], 400);
            }
    
            // Aprobar en Gerencia
            $solicitud->Estado_Gerencia = 'Aprobado';
            $solicitud->usuario_Aprobadorgerencia_id = $usergerencia;
            $solicitud->Estado_Final = 'Aprobado';
            $solicitud->save();
    
            // Agregar mensajes de depuración
            Log::info('Solicitud aprobada con éxito por ' . $nombreAprobadorGerencia);
    
            $nombreSolicitante = $solicitud->Nombre_Empresa_Persona;
            $montoaprobado = $solicitud->Monto_Solicitado;
            $plazo = $solicitud->Plazo_Credito_Meses;
            $destinatarios = ['analista.cartera@doblamos.com','elkin.gutierrez@doblamos.com'];
    
            // Enviar notificación de aprobación de gerencia a cartera.
            Mail::to($destinatarios)->send(new NotificacionSoliCreditoaprobadapersoGerenciaMail(
                $nombreSolicitante,
                $numeroRadicado,
                $montoaprobado,
                $plazo
            ));
    
            return view('emails.NotificacionSolicitudesCredito.NotificacionAprobacion')
                ->with([
                    'success_message' => 'Solicitud de compra aprobada con éxito',
                    'nombreAprobadorGerencia' => $nombreAprobadorGerencia
                ]);
    
        } catch (\Exception $e) {
            $nombreAprobadorGerencia = $aprobadorGerencia ? $aprobadorGerencia->Nombre_Empleado : 'Usuario Desconocido';
            Log::error('Error al aprobar en Gerencia desde el correo: ' . $e->getMessage());
            return view('emails.NotificacionSolicitudesCredito.NotificacionAprobacion')
                ->with([
                    'error_message' => $e->getMessage(),
                    'nombreAprobadorGerencia' => $nombreAprobadorGerencia
                ]);
        }
    }
    

 
    public function rechazarDesdeCorreoGerenciaSolicitud($id, $numeroRadicado, $userGerencia)
    {
        try {
            Log::info('ID recibido en el controlador: ' . $id);
            Log::info('Número de Radicado recibido en el controlador: ' . $numeroRadicado);
    
            // Verificar si la solicitud existe
            $solicitud = Solicitudes_Credito::find($id);
    
            if (!$solicitud) {
                Log::error('Solicitud no encontrada');
                return response()->json(['error' => 'Solicitud no encontrada'], 404);
            }
    
            Log::info('Solicitud encontrada: ' . json_encode($solicitud));
    
            // Verificar si Beratung ya ha aprobado
            if ($solicitud->Estado_Beratung !== 'Aprobado') {
                throw new \Exception('No puedes rechazar en gerencia hasta que Beratung apruebe.');
            }
    
            // Obtener el ID del usuario que aprobó en Gerencia
            $aprobadorGerenciaId = $solicitud->usuario_Aprobadorgerencia_id;
    
            // Obtener el nombre del usuario directamente de la base de datos
            $aprobadorGerencia = User::find($aprobadorGerenciaId);
    
            // Obtener el nombre del usuario
            $nombreAprobadorGerencia = $aprobadorGerencia->Nombre_Empleado;
    
            // Verificar el estado de Gerencia
            if ($solicitud->Estado_Gerencia === 'Pendiente') {
                // Validar que el número de radicado enviado coincida con el de la solicitud
                if ($solicitud->radicado !== $numeroRadicado) {
                    Log::error('El número de radicado no coincide con la solicitud.');
                    return response()->json(['error' => 'El número de radicado no coincide con la solicitud.'], 400);
                }
    
                // Rechazar en Gerencia
                $solicitud->Estado_Gerencia = 'Rechazado';
                $solicitud->Estado_Final = 'Rechazado';
                $solicitud->usuario_Aprobadorgerencia_id = $userGerencia;
                $solicitud->save();
    
                // Agregar mensajes de depuración
                Log::info('Solicitud rechazada en Gerencia desde el correo');
    
                $nombreSolicitante = $solicitud->Nombre_Empresa_Persona;
                $montoAprobado = $solicitud->Monto_Solicitado;
                $plazo = $solicitud->Plazo_Credito_Meses;
                $destinatarios = ['analista.cartera@doblamos.com', 'elkin.gutierrez@doblamos.com'];
    
                // Enviar notificación de rechazo de gerencia a cartera.
                Mail::to($destinatarios)->send(new NotificacionSoliCreditoreGerenciaRechazadaMail(
                    $nombreSolicitante,
                    $numeroRadicado,
                    $montoAprobado,
                    $plazo
                ));
    
                return View::make('emails.NotificacionSolicitudesCredito.NotificacionAprobacion')
                    ->with([
                        'error_message' => 'La solicitud ya ha sido aprobada o rechazada en Gerencia desde el correo',
                        'nombreAprobadorGerencia' => $nombreAprobadorGerencia
                    ]);
            } else {
                // La solicitud ya ha sido aprobada o rechazada en Gerencia
                $estadoGerencia = $solicitud->Estado_Gerencia;
                $nombreAprobador = $estadoGerencia === 'Aprobado' ? 'aprobada' : 'rechazada';
                return View::make('emails.NotificacionSolicitudesCredito.NotificacionAprobacion')
                    ->with([
                        'error_message' => 'La solicitud ya ha sido ' . $nombreAprobador . ' por ' . $nombreAprobadorGerencia,
                        'nombreAprobadorGerencia' => $nombreAprobadorGerencia
                    ]);
            }
        } catch (\Exception $e) {
            Log::error('Error al rechazar en Gerencia desde el correo: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    








    private function todasAprobadas($solicitud)
    {
        return $solicitud->Estado_Sagrilaft === 'Aprobado' &&
            $solicitud->Estado_Beratung === 'Aprobado' &&
            $solicitud->Estado_Cartera === 'Aprobado';
    }

    private function Solirechazadasagrilaf($solicitud)
    {

        return $solicitud->Estado_Sagrilaft === 'Rechazado';
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    public function rechazarSagrilaft($id)
    {
        // Lógica para rechazar en Sagrilaft
        $solicitud = Solicitudes_Credito::findOrFail($id);

        // Verifica que el estado de Sagrilaft esté pendiente
        if ($solicitud->Estado_Sagrilaft === 'Pendiente') {
            // Actualiza el estado de Sagrilaft a Rechazado
            $solicitud->Estado_Sagrilaft = 'Rechazado';
            $solicitud->Estado_Final = 'Rechazado';
            // Asigna el ID del usuario que rechaza en Sagrilaft
            $solicitud->usuario_AprobadorSagrilaft_id = auth()->user()->id;

            // Guarda los cambios en la base de datos
            $solicitud->save();

            $nombreSolicitante = $solicitud->Nombre_Empresa_Persona;
            $numeroRadicado = $solicitud->radicado;

            // Enviar la notificación de rechazo en Sagrilaft
            Mail::to($solicitud->correo)->send(new SolicitudCreditoRechazadoMail(
                $nombreSolicitante,
                $numeroRadicado
            ));



            // Redirige de regreso a la vista de solicitudes
            return response()->json(['message' => 'Solicitud rechazada en Sagrilaft']);
        }

        // Si el estado no estaba pendiente, muestra un mensaje de error
        return response()->json(['error' => 'La solicitud ya ha sido aprobada o rechazada en Sagrilaft']);
    }







    public function rechazarCartera($id)
    {
        // Encuentra la solicitud de crédito por su ID
        $solicitud = Solicitudes_Credito::findOrFail($id);

        // Verifica que el estado de cartera esté pendiente
        if ($solicitud->Estado_Cartera === 'Pendiente') {
            // Actualiza el estado de cartera a Rechazado
            $solicitud->Estado_Cartera = 'Rechazado';
            $solicitud->Estado_Final = 'Rechazado';
            // Asigna el ID del usuario que rechaza en cartera
            $solicitud->usuario_AprobadorSagrilaft_id = auth()->user()->id;

            // Guarda los cambios en la base de datos
            $solicitud->save();


            $nombreSolicitante = $solicitud->Nombre_Empresa_Persona;
            $numeroRadicado = $solicitud->radicado;

            // Enviar la notificación de rechazo en Sagrilaft


            // Redirige de regreso a la vista de solicitudes
            return response()->json(['message' => 'Solicitud rechazada en cartera']);
        }

        // Si el estado no estaba pendiente, muestra un mensaje de error
        return response()->json(['error' => 'La solicitud ya ha sido aprobada o rechazada en cartera']);
    }


    public function rechazarBeratung($id)
    {
        // Lógica para rechazar en Beratung
        $solicitud = Solicitudes_Credito::find($id);

        if ($solicitud) {
            if ($solicitud->Estado_Beratung === 'Pendiente') {
                // Actualiza el estado de Beratung a Rechazado
                $solicitud->Estado_Beratung = 'Rechazado';
                $solicitud->Estado_Final = 'Rechazado';
                // Asigna el ID del usuario que rechaza en Beratung
                $solicitud->usuario_AprobadorSagrilaft_id = auth()->user()->id;

                // Guarda los cambios en la base de datos
                $solicitud->save();


                $nombreSolicitante = $solicitud->Nombre_Empresa_Persona;
                $numeroRadicado = $solicitud->radicado;

                //enviar notificacion a cartera sobre el rechazo

                $mandatarioscartera = ['elkin.gutierrez@doblamos.com', 'analista.cartera@doblamos.com'];
                // Enviar la notificación de rechazo en Sagrilaft
                Mail::to($mandatarioscartera)->send(new NotificacionSoliCreditorechazadaberatungMail(
                    $nombreSolicitante,
                    $numeroRadicado
                ));

                // Redirige de regreso a la vista de solicitudes
                return response()->json(['message' => 'Solicitud rechazada en Beratung']);
            } else {
                return response()->json(['error' => 'La solicitud ya ha sido aprobada o rechazada en Beratung']);
            }
        } else {
            return response()->json(['error' => 'Solicitud no encontrada']);
        }
    }










    public function descargarArchivo($nombreArchivo)
    {
        $rutaArchivo = storage_path('app/public/documentos/' . $nombreArchivo);

        if (!File::exists($rutaArchivo)) {
            abort(404); // Archivo no encontrado
        }

        return response()->download($rutaArchivo);
    }

    public function verDocumento($nombreArchivo)
    {
        $rutaArchivo = storage_path('app/public/documentos/' . $nombreArchivo);

        if (!File::exists($rutaArchivo)) {
            abort(404); // Archivo no encontrado
        }

        return response()->file($rutaArchivo, [
            'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"',
        ]);
    }


    public function descargarArchivocartera($nombreArchivo)
    {
        $rutaArchivo = storage_path('app/public/AdjuntosCartera/' . $nombreArchivo);

        if (!File::exists($rutaArchivo)) {
            abort(404); // Archivo no encontrado
        }

        return response()->download($rutaArchivo);
    }

    public function verDocumentocartera($nombreArchivo)
    {
        $rutaArchivo = storage_path('app/public/AdjuntosCartera/' . $nombreArchivo);

        if (!File::exists($rutaArchivo)) {
            abort(404); // Archivo no encontrado
        }

        return response()->file($rutaArchivo, [
            'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"',
        ]);
    }





    public function seguimientosolicitudescomentarios(Request $request, $id_solicitud)
    {

        try {
            // Validar los datos del formulario
            $request->validate([
                'comentario' => 'required',
            ]);

            // Encuentra la solicitud de crédito por su ID
            $solicitud = Solicitudes_Credito::find($id_solicitud);

            if (!$solicitud) {
                return response()->json(['error' => 'La solicitud de crédito no existe.'], 404);
            }

            // Crea un nuevo comentario y asigna el contenido del formulario
            $comentario = new ComentariosSolicitudesCredito([
                'comentario' => $request->input('comentario'),
            ]);

            // Asigna manualmente el ID del usuario autenticado al comentario
            $comentario->user_id = auth()->user()->id;

            // Asocia la solicitud de crédito con el comentario
            $comentario->solicitudCredito()->associate($solicitud);

            // Guarda el comentario relacionado con la solicitud de crédito
            $comentario->save();

            // Devuelve una respuesta JSON con éxito solo cuando el comentario se guarda correctamente
            return response()->json(['message' => 'Comentario generado con éxito'], 200);
        } catch (\Exception $e) {
            // Manejo de excepciones: puedes registrar el error o devolver un mensaje de error genérico
            return response()->json(['error' => 'Error al agregar el comentario. Detalles: ' . $e->getMessage()], 500);
        }
    }


    public function obtenerComentarios($id_solicitud)
    {

        // Obtener la solicitud de crédito por su ID
        $solicitud = Solicitudes_Credito::find($id_solicitud);

        // Verificar si la solicitud de crédito existe
        if (!$solicitud) {
            return response()->json(['error' => 'La solicitud de crédito no existe.'], 404);
        }

        // Obtener los comentarios asociados a la solicitud de crédito con información del usuario
        $comentarios = ComentariosSolicitudesCredito::where('solicitud_credito_id', $id_solicitud)
            ->with('user') // Cargar la relación con el usuario
            ->get();

        // Devolver los comentarios en formato JSON
        return response()->json(['comentarios' => $comentarios], 200);
    }






    public function updatesolicitud(Request $request, $id_solicitud)
    {

        $solicitud = Solicitudes_Credito::findOrFail($id_solicitud);
        $solicitud->Monto_Solicitado = $request->input('monto');
        $solicitud->Plazo_Credito_Meses = $request->input('Plazo_Credito_Meses');
        $solicitud->Estado_Final = 'Aprobado';
        $solicitud->save();

        // Obtener el nombre del solicitante desde la base de datos
        $nombreSolicitante = $solicitud->Nombre_Empresa_Persona;
        // Obtener el número de radicado desde la base de datos
        $numeroRadicado = $solicitud->radicado;
        $Plazo_Credito_Meses = $solicitud->Plazo_Credito_Meses;

        // Obtener los valores adicionales que deseas mostrar en el correo
        $valorCreditoOtorgado = $solicitud->Monto_Solicitado;
        $diasPlazo = $solicitud->Plazo_Credito_Meses;

        $formaPago = "Transferencia electrónica"; // Reemplaza con el valor adecuado

        // Obtener el asesor asociado a la solicitud
        $asesor = Asesores::find($solicitud->asesor_id);

        if ($asesor) {
            // Si se encontró el asesor, envía la notificación específica al asesor
            Mail::to($asesor->correo_asesor)->send(new NotificacionSoliCreditoaprobadaasesorMail(
                $nombreSolicitante,
                $numeroRadicado,
                $valorCreditoOtorgado,
                $diasPlazo,



            ));
        }
        // Verificar si todas las aprobaciones están completadas
        if ($this->todasAprobadas($solicitud)) {
            // Enviar la notificación de aprobación
            Mail::to($solicitud->correo)->send(new EstadosSolicitudCreditoMail(
                $solicitud,
                $nombreSolicitante,
                $numeroRadicado,
                $valorCreditoOtorgado,
                $diasPlazo,
                $formaPago
            ));
        }


        return redirect()->back()->with('success', 'Monto actualizado exitosamente.');
    }


    public function updatesolicitudmonto(Request $request, $id_solicitud)
    {
        try {
            $request->validate([
                'monto' => 'required|numeric|min:0.01', 
            ]);
    
            $solicitud = Solicitudes_Credito::findOrFail($id_solicitud);
            $solicitud->Monto_Aprobado = $request->input('monto');
            $solicitud->update();
    
            return response()->json(['success' => true, 'message' => 'Monto actualizado exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar el monto.', 'error' => $e->getMessage()]);
        }
    }


    public function updatesolicitudrechazada(Request $request, $id_solicitud)
    {
        $solicitud = Solicitudes_Credito::findOrFail($id_solicitud);
        $solicitud->comentarioparacliente = $request->input('comentarioparacliente');
        $solicitud->Estado_Final = 'Rechazada';
        $solicitud->save();

        $nombreSolicitante = $solicitud->Nombre_Empresa_Persona;
        $numeroRadicado = $solicitud->radicado;
        $comentariocliente = $solicitud->comentarioparacliente;
        $noticarteramensaje = 'elkin.gutierrez@doblamos.com';
        $pruebastiven = 'stiven.madrid@doblamos.com';

        // Enviar la notificación de rechazo al cliente, noticarteramensaje y pruebastiven
        Mail::to([$solicitud->correo, $noticarteramensaje, $pruebastiven])->send(new NotificacionSoliCreditorechazadaporcarteraMail(
            $nombreSolicitante,
            $numeroRadicado,
            $comentariocliente
        ));

        // Obtener el asesor asociado a la solicitud
        $asesor = Asesores::find($solicitud->asesor_id);

        if ($asesor) {
            // Si se encontró el asesor, enviar la notificación al asesor
            Mail::to($asesor->correo_asesor)->send(new NotificacionSoliCreditorechazadaporcarteraMail(
                $nombreSolicitante,
                $numeroRadicado,
                $comentariocliente
            ));
        }

        return redirect()->back()->with('success', 'Monto actualizado exitosamente.');
    }



    public function adjuntarDocumentoscartera(Request $request, $id_solicitud)
    {
        // Validación de archivos
        $request->validate([
            'Documento_informa_Cartera' => 'required|mimes:pdf,doc,docx',
            'Documento_data_credito' => 'required|mimes:pdf,doc,docx',
        ]);

        // Obtener la solicitud de crédito por ID
        $solicitudCredito = Solicitudes_Credito::findOrFail($id_solicitud);

        // Manejar el archivo de Informe Informa
        $documentoInformeCartera = $request->file('Documento_informa_Cartera');
        $pathInformeCartera = $documentoInformeCartera->store('public/AdjuntosCartera');
        $solicitudCredito->Documento_informa_Cartera = Storage::url($pathInformeCartera);

        // Manejar el archivo de Informe Datacrédito
        $documentoDataCredito = $request->file('Documento_data_credito');
        $pathDataCredito = $documentoDataCredito->store('public/AdjuntosCartera');
        $solicitudCredito->Documento_data_credito = Storage::url($pathDataCredito);

        // Guardar los cambios en la base de datos
        $solicitudCredito->save();

        // Devolver una respuesta JSON según tus necesidades
        return response()->json(['message' => 'Documentos adjuntados correctamente']);
    }
}
