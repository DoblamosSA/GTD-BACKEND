<?php

namespace App\Models\proyectosSAP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proyecto extends Model
{
    protected $fillable = [
        'Code',
        'Name',
        'ValidFrom',
        'ValidTo',
        'Active',
        'U_DOB_Tipo',
    ];
}
