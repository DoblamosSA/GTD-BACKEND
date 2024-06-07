<?php

namespace App\Models\InventarioLiencias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Licencias extends Model
{
    use HasFactory;


    protected $fillable = ['Tipo_licencia','correo_asociado','key','Estado'];


}
