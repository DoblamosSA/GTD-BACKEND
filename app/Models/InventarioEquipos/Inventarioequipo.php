<?php

namespace App\Models\InventarioEquipos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventarioequipo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre_equipo','modelo','marca','estado','serial','sistema_operativo','procesador','memoria_ram',
    'hdd','sede','piso','area','fecha_garantia','fecha_compra','numero_facturasap','codigo_Activosap','codigoactivoSaG','Asignado_A'];
}



