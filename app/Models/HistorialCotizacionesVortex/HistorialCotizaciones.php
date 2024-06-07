<?php

namespace App\Models\HistorialCotizacionesVortex;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialCotizaciones extends Model
{
    use HasFactory;

    protected $fillable = ['Numero_Obra','Empresa_Cliente','Fecha_Recibido','Nombre_Obra','Descripcion','Estado','Fecha_Cotizada','Valor_Antes_Iva',
    'Contacto','Area_M2','M2','Incluye_Montaje','Origen'];
}
