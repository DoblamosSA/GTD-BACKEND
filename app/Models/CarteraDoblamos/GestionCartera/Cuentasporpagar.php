<?php

namespace App\Models\CarteraDoblamos\GestionCartera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuentasporpagar extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'documento', 'Numero_Tarjeta', 'Estado_Documento', 'Fecha_Documento', 'Fecha_Vencimiento', 'Codigo_cliente', 'Nombre_Cliente', 'Vendedor', 'Total_Documento',
        'pagado_hasta_la_fecha', 'Saldo_Pendiente', 'id','E_Mail','Dias_Vencidos',' EnvioCorreo'
    ];

    public function seguimientos()
    {
        return $this->hasMany(Seguimientocuentasporpagar::class);
    }

}
