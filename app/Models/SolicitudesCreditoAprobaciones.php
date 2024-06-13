<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnexosSolicitudesCompra\AnexosSoliCompra;
class SolicitudesCreditoAprobaciones extends Model
{
    use HasFactory;
    protected $table = 'solicitudes_compra_aprobaciones';
    protected $fillable = [
        'RequriedDate',
        'RequesterName',
        'U_HBT_AproComp',
        'Comments',
        'estado',
        'UsuarioSolicitante_id',
        'UsuarioModifico_id',
        'DocNum',
        'DocEntry',
        'RefDocNumOrder',
        'DocEntryOrdenVenta',
        'Price'
    ];

    // Relación con el usuario solicitante
    public function usuarioSolicitante()
    {
        return $this->belongsTo(User::class, 'UsuarioSolicitante_id');
    }

    // Relación con el usuario que modificó
    public function usuarioModifico()
    {
        return $this->belongsTo(User::class, 'UsuarioModifico_id');
    }

    public function detalleSolicitudes()
    {
        return $this->hasMany(DetalleSolicitudesCreditoAprobaciones::class, 'id_solicitud_compra');
    }

    public function solicitante()
    {
        return $this->belongsTo(User::class, 'UsuarioSolicitante_id');
    }
    public function usuarioAprobador()
    {
        return $this->belongsTo(User::class, 'usuarioaprobador');
    }


    public function anexos()
    {
        return $this->hasMany(AnexosSoliCompra::class, 'id_solicitud_compra');
    }
}
