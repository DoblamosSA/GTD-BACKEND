<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JuntasInformeUltrasonido
 *
 * @property $id
 * @property $fecha
 * @property $identificacion_elemento
 * @property $junta
 * @property $ubicacion_junta
 * @property $indicacion_numero
 * @property $desde_cara
 * @property $pierna
 * @property $nivel_indicacion
 * @property $nivel_referencia
 * @property $factor_atenuacion
 * @property $valoracion_indicacion
 * @property $longitud_defecto
 * @property $distancia_angular
 * @property $profundidad_desde
 * @property $evaluacion_discontinuidad_1
 * @property $evaluacion_discontinuidad_2
 * @property $evaluacion_discontinuidad_3
 * @property $distancia_desde_x
 * @property $distancia_desde_y
 * @property $estampe_soldador
 * @property $observaciones
 * @property $inf_ultrasonido_id
 * @property $created_at
 * @property $updated_at
 *
 * @property InformeUltrasonido $informeUltrasonido
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class JuntasInformeUltrasonido extends Model
{
    
    static $rules = [
		'fecha' => 'required',
		'identificacion_elemento' => 'required',
		'junta' => 'required',
    'inf_ultrasonido_id' => 'required',
    ];
	
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['fecha','identificacion_elemento','junta','inf_ultrasonido_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function informeUltrasonido()
    {
        return $this->hasOne('App\Models\InformeUltrasonido', 'id', 'inf_ultrasonido_id');
    }

        /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function datosJuntasInformeUltrasonido()
    {
        return $this->hasMany('App\Models\DatosJuntasInformeUltrasonido', 'jun_inf_ult_id', 'id');
    }
    

}
