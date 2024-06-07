<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckList extends Model
{
    protected $fillable = [
        'sede',
        'campo',
        'estado_Campo',
        'comentarios',
    ];
}
