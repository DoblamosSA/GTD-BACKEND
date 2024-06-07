<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pais\PaisCordenadas;

class Vorte extends Model
{
    
    protected $perPage = 20;
    protected $fillable=['Numero_Obra','Nombre_Obra','Lugar_Obra','Fecha_Recibido','Fecha_Cotizada', 'Valor_Antes_Iva','Valor_Adjudicado','Tipologia','Estado','m2',
    'Incluye_Montaje','Origen','clientes_id','Asesor_id','Metros_Cuadrados','Total_Asesor','Pais','Fecha_Venta'
];


public function clientes()
{
    
    return $this->belongsTo(ClientesSAP::class, 'clientes_id');

}

public function Asesor()
{
    
    return $this->belongsTo(Asesores::class, 'Asesor_id');

}

public static function boot() {
    parent::boot();

    static::creating(function ($vortex) {
        $vortex->Numero_Obra = self::generateObraNumber();
    });
}

public static function generateObraNumber() {
    $year = date('Y');
    $ultimaRegistro = self::where('Numero_Obra', 'like', "$year-%")->latest()->first();
    if ($ultimaRegistro) {
        $lastSequence = explode('-', $ultimaRegistro->Numero_Obra)[1];
        return "$year-" . ($lastSequence + 1);
    }
    return "$year-1";
}


public function PaisesCordenadas()
{
    return $this->belongsTo(PaisCordenadas::class, 'Pais');
}

public function seguimientosCRM()
{
    return $this->hasMany(SeguimientosCRM::class, 'vorte_id');
}
}