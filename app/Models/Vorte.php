<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vorte extends Model
{
    
    protected $perPage = 20;
    protected $fillable=['Numero_Obra','Empresa_Cliente','Fecha_Recibido','Nombre_Obra','Descripcion','Estado','Fecha_Cotizada',
    'Valor_Antes_Iva','Contacto','AreaM2','m2','Incluye_Montaje'
];
}