<?php

namespace App\Models\CarteraDoblamos\Creditos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\CarteraDoblamos\Creditos\Solicitudes_Credito; // Asegúrate de importar el modelo correcto

class ComentariosSolicitudesCredito extends Model
{
    use HasFactory;

    protected $table = 'comentarios__solicitudes__creditos';

    protected $fillable = ['comentario'];

    // Relación con el usuario que dejó el comentario
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con la solicitud de crédito a la que pertenece el comentario
    public function solicitudCredito()
    {
        return $this->belongsTo(Solicitudes_Credito::class, 'solicitud_credito_id');
    }
}
