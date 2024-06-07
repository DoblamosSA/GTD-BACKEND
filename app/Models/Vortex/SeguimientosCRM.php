<?php

namespace App\Models\Vortex;

use App\Models\Vorte;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientosCRM extends Model
{

    protected $table = 'seguimiento_c_r_m_vortexes';
   protected $fillable = ['vorte_id','Fecha_Seguimiento','Evento','Observacion','Fecha_Nuevo_Seguimiento'];


   public function vortex(){
   return $this->belongsTo(Vorte::class,'vorte_id');
   }
}
