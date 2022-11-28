<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JuntasInformePartesMagneticas
 *
 * @property $id
 * @property $elemento
 * @property $junta
 * @property $indicacion
 * @property $calificacion
 * @property $observaciones
 * @property $inf_part_magneticas_id
 * @property $created_at
 * @property $updated_at
 *
 * @property InformePartesMagneticas $informePartesMagneticas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class JuntasInformePartesMagneticas extends Model
{
    
    static $rules = [
		'elemento' => 'required',
		'junta' => 'required',
		// 'indicacion' => 'required',
		// 'calificacion' => 'required',
		'observaciones' => 'required',
    ];
	
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['elemento','junta','indicacion','calificacion','observaciones','inf_part_magneticas_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function informePartesMagneticas()
    {
        return $this->hasOne('App\Models\InformePartesMagnetica', 'id', 'inf_part_magneticas_id');
    }

    public function juntasImagenes()
    {
        return $this->hasMany('App\Models\JuntasPartesMagneticasImagenes', 'junta_id', 'id');
    }
    

}
