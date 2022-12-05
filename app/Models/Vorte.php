<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vorte extends Model
{
    
    protected $perPage = 20;
    protected $fillable=['Numero_Obra','Nombre_Obra','Lugar_Obra','Fecha_Recibido','Fecha_Cotizada', 'Valor_Antes_Iva','Valor_Adjudicado','Tipologia','Estado','m2',
    'Incluye_Montaje','Origen'
];

}