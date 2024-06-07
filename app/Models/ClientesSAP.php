<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientesSAP extends Model
{
    protected $fillable=['CardCode','CardName','CardType','Phone1','Currency','Cellular'];

    public function Vorte()
    {
        return $this->hasMany(Vorte::class);
    }
    public function EstructuraMelalica()
    {
        return $this->hasMany(EstructuraMelalica::class);
    }
    public function CotizacionEstructuras()
    {
        return $this->hasMany(CotizacionEstructuras::class);
    }
 public function Asesor()
    {
        return $this->hasMany(Vorte::class);
    }
}
