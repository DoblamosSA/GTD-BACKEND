<?php

namespace App\Models\CarteraDoblamos\GestionCartera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Seguimientocuentasporpagar extends Model
{
    protected $table = 'seguimientos_cuentasporpagar';

    protected $fillable = ['comentario', 'cuentasporpagar_id', 'Fecha_Seguimiento', 'Fecha_compromiso_pago'];

    public function cuentasporpagar()
    {
        return $this->belongsTo(Cuentasporpagar::class);
    }
}
