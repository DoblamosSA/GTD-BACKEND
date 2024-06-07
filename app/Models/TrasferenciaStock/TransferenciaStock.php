<?php

namespace App\Models\TrasferenciaStock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferenciaStock extends Model
{
 
protected $fillable = ['SOLICITUD_TRASLADO','COD_ARTI','BODEGA_ORIGEN','BODEGA_TRANSITO','ALMACEN_FINAL','CANTIDAD_TRASLADO','id_articulo_abastecimiento'];

}


