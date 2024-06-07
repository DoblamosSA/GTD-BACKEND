<?php

namespace App\Models\Estructuras;

use App\Models\EstructuraMelalica;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstructurasSeguimientosCRM extends Model
{
    protected $fillable = ['estructuras_id','Fecha_Seguimiento','Evento','Observacion','Fecha_Nuevo_Seguimiento'];


    public function estructuras(){
    return $this->belongsTo(EstructuraMelalica::class,'vorte_id');
    }

    
}
