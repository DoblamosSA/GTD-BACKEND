<?php

namespace App\Models\CarteraDoblamos\Creditos;

use App\Models\Asesores;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitudes_Credito extends Model
{
    protected $fillable = [
        'Nombre_Empresa_Persona',
        'Nit',
        'correo',
        'Monto_Solicitado',
        'Plazo_Credito_Meses',
        'Aceptacion_Politica_Datos_Personales',
        'Documento_Consentimiento_inf',
        'Documento_Certificado_Bancario',
        'Documento_Referencia_Comercial',
        'Documento_Cedula',
        'Documento_Rut',
        'Documento_Camara_Comercio',
        'Documento_Declaracion_Renta',
        'Documento_pagare',
        'Estado_Cartera',
        'Estado_Beratung',
        'Estado_Sagrilaft',
        'usuario_Aprobadorcartera_id',
        'usuario_Aprobadorberatung_id',
        'usuario_AprobadorSagrilaft_id',
        'radicado',
        'Estado_Final',
        'asesor_id',
        'comentarioparacliente',
        'Documento_informa_Cartera',
        'Documento_data_credito',
        'Estado_Gerencia',
        'usuario_Aprobadorgerencia_id',
        'Monto_Aprobado'

       

      
    ];



   


    public function aprobadorCartera()
    {
        return $this->belongsTo(User::class, 'usuario_Aprobadorcartera_id');
    }

    public function aprobadorBeratung()
    {
        return $this->belongsTo(User::class, 'usuario_Aprobadorberatung_id');
    }

    public function aprobadorSagrilaft()
    {
        return $this->belongsTo(User::class, 'usuario_AprobadorSagrilaft_id');
    }  

   // Relación con los comentarios de la solicitud de crédito
   public function comentarios()
    {
        return $this->hasMany(ComentariosSolicitudesCredito::class, 'solicitud_credito_id');
    }

    public function asesor()
    {
        return $this->belongsTo(Asesores::class, 'asesor_id');
    }
}
