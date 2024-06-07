<?php

namespace App\Models\Pais;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vorte;

class PaisCordenadas extends Model
{
    use HasFactory;
    
    protected $table = 'pais_cordenadas';
    protected $fillable = ['countryName', 'latitude', 'longitude'];

    public function Vortes()
    {
        return $this->hasMany(Vorte::class, 'Pais');
    }
}


