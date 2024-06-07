<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpledoSAP extends Model
{
    protected $fillable=['CardCode','CardName','CardType','Phone1','Currency','Cellular'];

public function costonocalidad()
    {
        return $this->hasMany(CostoNocalidad::class);
    }
}

