<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JuntasInformeLiquidosPenetrante
 *
 * @property $id
 * @property $elemento
 * @property $junta
 * @property $indicacion
 * @property $calificacion
 * @property $observaciones
 * @property $inf_liq_penetran_id
 * @property $created_at
 * @property $updated_at
 *
 * @property InformeLiquidosPenetrante $informeLiquidosPenetrante
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class JuntasInformeLiquidosPenetrante extends Model
{
    
    static $rules = [
		'elemento' => 'required',
		'junta' => 'required',
		// 'indicacion' => 'required',
		// 'calificacion' => 'required',
		// 'observaciones' => 'required',
    'inf_liq_penetran_id' => 'required',
    ];
	
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['elemento','junta','indicacion','calificacion','observaciones','inf_liq_penetran_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function informeLiquidosPenetrante()
    {
        return $this->hasOne('App\Models\InformeLiquidosPenetrante', 'id', 'inf_liq_penetran_id');
    }

    public function juntasImagenes()
    {
        return $this->hasMany('App\Models\JuntasLiqPenIma', 'junta_liq_penetran_id', 'id');
    }
}
