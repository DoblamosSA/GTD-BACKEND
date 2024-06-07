<?php

namespace App\Models\Cotizaciones_Formaletas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hitorico_formaleta extends Model
{
    protected $table = 'historico_formaletas';

    protected $fillable = [
        'area',
        'numero_obra',
        'empresa',
        'fecha_recibido',
        'estado',
        'asesor',
        'observaciones',
        'seguimiento',
        'requiereing',
        'valorcotizado',
        'valoradjudicado',
        'numeroorden',
        'numerofactura',
        'fechafactura',
        'pesokg',
        'aream2',
        '/kg',
        'cantidadelementos',
    ];
}
