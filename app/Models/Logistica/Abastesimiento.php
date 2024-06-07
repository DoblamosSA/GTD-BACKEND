<?php

namespace App\Models\Logistica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abastesimiento extends Model
{
    use HasFactory;

    protected $fillable = ['ItemCode','Dscription','SWeight1','SubGrupo','Almacen','Stock','Comprometido','Pedido','Disponible','Sugerido','Pventa','id__','existencia_arti_historial'];
}
