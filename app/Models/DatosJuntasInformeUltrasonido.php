<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DatosJuntasInformeUltrasonido
 *
 * @property $id
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
 * @property $jun_inf_ult_id
 * @property $created_at
 * @property $updated_at
 *
 * @property JuntasInformeUltrasonido $juntasInformeUltrasonido
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class DatosJuntasInformeUltrasonido extends Model
{
    
    static $rules = [
		'ubicacion_junta' => 'required',
		'indicacion_numero' => 'required',
		'desde_cara' => 'required',
		'pierna' => 'required',
		'nivel_indicacion' => 'required',
		'nivel_referencia' => 'required',
		'factor_atenuacion' => 'required',
		'valoracion_indicacion' => 'required',
		'longitud_defecto' => 'required',
		'distancia_angular' => 'required',
		'profundidad_desde' => 'required',
		'evaluacion_discontinuidad_1' => 'required',
		'evaluacion_discontinuidad_2' => 'required',
		'evaluacion_discontinuidad_3' => 'required',
		'distancia_desde_x' => 'required',
		'distancia_desde_y' => 'required',
		'estampe_soldador' => 'required',
		'observaciones' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['ubicacion_junta','indicacion_numero','desde_cara','pierna','nivel_indicacion','nivel_referencia','factor_atenuacion','valoracion_indicacion','longitud_defecto','distancia_angular','profundidad_desde','evaluacion_discontinuidad_1','evaluacion_discontinuidad_2','evaluacion_discontinuidad_3','distancia_desde_x','distancia_desde_y','estampe_soldador','observaciones','jun_inf_ult_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function juntasInformeUltrasonido()
    {
        return $this->hasOne('App\Models\JuntasInformeUltrasonido', 'id', 'jun_inf_ult_id');
    }
    

}
