<?php

namespace App\Models;

use App\Models\MaterialesSAP\Consumibles_sap;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleSolicitudesCreditoAprobaciones extends Model
{
    protected $table = 'detalle_solicitud_compra';
    protected $fillable = [
        'id_solicitud_compra',
        'Materiales_id',
        'Descripcion',
        'TextoLibre',
        'Cantidad',
        'Proyecto',
        'Almacen',
        'CentroOperaciones',
        'CentroCostos',
        'Departamento',
        'Fecha_Requesrida',
        'U_DOB_DescripcionAdicional',
        'TaxCode',
        'LineVendor'
    ];
    
    
    // Relación con la solicitud de compra
    public function solicitudCompra()
    {
        return $this->belongsTo(SolicitudesCreditoAprobaciones::class, 'id_solicitud_compra');
    }

    // Relación con el material
    public function material()
    {
        return $this->belongsTo(Consumibles_sap::class, 'Materiales_id', 'id')->select('id', 'ItemCode');
    }
    

    public function detalles()
    {
        return $this->hasMany(DetalleSolicitudesCreditoAprobaciones::class, 'id_solicitud_compra');
    }
}
