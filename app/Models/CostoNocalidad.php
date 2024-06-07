<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostoNocalidad extends Model
{
    
    protected $fillable=[
        'sede','FechaCNC','Descripcion','Ccop','AreaResponsableCNC','SubprocesoCNC','causa_raiz',
        'Porque1','Porque2','Porque3','IdResponsablecnc','ProcesoReporta','ProcesoDetecta','CostoCNC',
        'SaldoRecuperado','SaldoFinalCNC','DescripcionOP','CorreccionEvento','TipoAccion','IdAnalistaReporto','EstadoCNC','QuienCostea','Cantidadpiezasdanadas','confirmacion_asistencia'
    ];

 public function empleado()
    {
        return $this->belongsTo(EmpledoSAP::class, 'IdResponsablecnc');
    }
 public function analista()
    {
        return $this->belongsTo(EmpledoSAP::class, 'IdAnalistaReporto','id');
    }

}