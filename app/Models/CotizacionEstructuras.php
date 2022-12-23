<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionEstructuras extends Model
{

    protected $perPage = 20;
    use  HasFactory;
    protected $fillable=['Numero_Obra','Nombre_Obra','Lugar_Obra','Fecha_Recibido','Fecha_Cotizada', 'Valor_Antes_Iva','Valor_Adjudicado','Tipologia','Estado','clientes_id'
];



public function clientes()
{
    return $this->belongsTo(ClientesSAP::class, 'clientes_id');
}


}