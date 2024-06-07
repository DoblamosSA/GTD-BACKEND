<?php

namespace App\Models\Cotizaciones_Formaletas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizaciones_Formaleta extends Model
{
    use HasFactory;

    protected $cotizaciones__formaleta;

    protected $fillable = ['Nombre_Obra', 'Lugar_Obra' ,'Fecha_Recibido','Fecha_Cotizada','Valor_Antes_Iva','Estado','Tipologia',
    'Valor_Adjudicado','Valor_Kilogramo','Metros_Cuadrados','Kilogramos','Asesor_id','Origen','Incluye_Montaje','clientes_id','pais_id','Departamento','Fecha_Venta'];

    public function clientes()
    {
        return $this->belongsTo(ClientesSAP::class, 'clientes_id');
    }
    
}
