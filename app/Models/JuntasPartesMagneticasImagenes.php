<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JuntasPartesMagneticasImagenes
 *
 * @property $id
 * @property $file_path
 * @property $junta_id
 * @property $created_at
 * @property $updated_at
 *
 * @property JuntasInformePartesMagnetica $juntasInformePartesMagnetica
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class JuntasPartesMagneticasImagenes extends Model
{
    protected $table = 'juntas_partes_magneticas_imagenes';
    static $rules = [
    ];
	
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['file_path','junta_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function juntasInformePartesMagnetica()
    {
        return $this->hasOne('App\Models\JuntasInformePartesMagnetica', 'id', 'junta_id');
    }
    

}
