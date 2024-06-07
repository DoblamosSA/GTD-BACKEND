<?php

namespace App\Models\MaterialesSAP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumibles_sap extends Model
{
    use HasFactory;

    protected $fillable = ['ItemCode','ItemName'];
    
}
