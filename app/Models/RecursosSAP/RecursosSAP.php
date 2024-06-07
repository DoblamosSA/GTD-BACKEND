<?php

namespace App\Models\RecursosSAP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecursosSAP extends Model
{
    use HasFactory;

    protected $fillable = ['Code','Name','Cost1','UnitOfMeasure'];
}
