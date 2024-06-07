<?php

namespace App\Models\Calibre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calibre extends Model
{
    use HasFactory;
    protected $fillable = ['Calibre'];
    
    public function calibres()
{
    return $this->belongsToMany(Calibre::class, 'calibres_id');
}
}
