<?php

namespace App\Models\Lamina;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamina extends Model
{
    use HasFactory;



    protected $fillable = ['Codigo','Descripcion'];


    public function calibres()
    {
        return $this->belongsToMany(Calibre::class)->withPivot('precio');
    }
    

}
