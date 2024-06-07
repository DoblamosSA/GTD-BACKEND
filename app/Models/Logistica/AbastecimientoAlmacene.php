<?php

namespace App\Models\Logistica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbastecimientoAlmacene extends Model
{
    use HasFactory;

    protected $fillable = ['ItemCode','Dscription','SWeight1','SubGrupo','Almacen','Stock','Comprometido','Pedido','Disponible','Sugerido','Cantidad','id__','existencia_arti_historial'];

    public $timestamps = false;
}
