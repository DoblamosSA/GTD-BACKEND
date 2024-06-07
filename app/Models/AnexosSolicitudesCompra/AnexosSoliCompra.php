<?php

namespace App\Models\AnexosSolicitudesCompra;

use App\Models\SolicitudesCreditoAprobaciones;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnexosSoliCompra extends Model
{
   

    protected $fillable = [
        'Ruta_documento_Adjunto',
        'id_solicitud_compra',
    ];

    public function solicitud()
    {
        return $this->belongsTo(SolicitudesCreditoAprobaciones::class, 'id_solicitud_compra');
    }


    public function getRutaCompletaDocumentoAttribute()
    {
        return storage_path('app/' . $this->Ruta_documento_Adjunto);
    }
}
