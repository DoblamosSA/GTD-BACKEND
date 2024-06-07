<?php

namespace App\Models\ClientesFerias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientesFeria extends Model
{
    use HasFactory;

    protected $table = 'clientes_ferias';

    protected $fillable = [
        'empresa',
        'contacto',
        'apellido',
        'pais',
        'region',
        'telefono',
        'correo',
        'vortex',
        'formaletas',
        'estructuras',
        'servicios',
        'venta_acero',
        'observaciones',
        'tipo_bd',
    ];
}