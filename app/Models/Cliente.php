<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model

{   
    
    protected $perPage = 20;
    use HasFactory;



    protected $fillable =[
        'Empresa','Nit','Contacto','Correo','Telefono'
    ];

    public function EstructuraMelalica()
    {
        return $this->hasMany(EstructuraMelalica::class);
    }
}
