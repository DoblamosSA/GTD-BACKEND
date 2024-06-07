<?php

namespace App\Models\Lamina;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calibre extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion'];

    public function laminas()
    {
        return $this->belongsToMany(Lamina::class);
    }
}
