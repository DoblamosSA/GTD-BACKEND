<?php

namespace App\Models\TransporteDoblamos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transporte extends Model
{
   
    protected $fillabled = [   'Codigo',
    'Descripcion',
    'valorTransporte'];
  
}


