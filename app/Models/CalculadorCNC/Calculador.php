<?php

namespace App\Models\CalculadorCNC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculador extends Model
{
    use HasFactory;

    protected  $fillable = 
    ['Articulo_id','calibres_id','Recurso_id','costo_nocalidad_id','user_costea_id','Cantidad_Piezas','Espesor_Material','Ancho_Platina','Longitud','Total'];
}

