<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JuntasInformeVertMetalica
 *
 * @property $id
 * @property $id_columna
 * @property $teorica
 * @property $real
 * @property $desviacion
 * @property $altura_Columna
 * @property $tolerancia
 * @property $norte_1
 * @property $norte_2
 * @property $sur_1
 * @property $sur_2
 * @property $oriente_1
 * @property $oriente_2
 * @property $occidente_1
 * @property $occidente_2
 * @property $resultado_inspeccion
 * @property $inf_vert_met_id
 * @property $created_at
 * @property $updated_at
 *
 * @property InformeVertMetalica $informeVertMetalica
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class JuntasInformeVertMetalica extends Model
{
    
    static $rules = [
		'id_columna' => 'required',
		// 'teorica' => 'required',
		// 'real' => 'required',
		// 'desviacion' => 'required',
		// 'altura_Columna' => 'required',
		// 'tolerancia' => 'required',
		// 'norte_1' => 'required',
		// 'norte_2' => 'required',
		// 'sur_1' => 'required',
		// 'sur_2' => 'required',
		// 'oriente_1' => 'required',
		// 'oriente_2' => 'required',
		// 'occidente_1' => 'required',
		// 'occidente_2' => 'required',
		// 'resultado_inspeccion' => 'required',
    ];
	
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_columna','teorica','real','desviacion','altura_Columna','tolerancia','norte_1','norte_2','sur_1','sur_2','oriente_1','oriente_2','occidente_1','occidente_2','resultado_inspeccion','inf_vert_met_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function informeVertMetalica()
    {
        return $this->hasOne('App\Models\InformeVertMetalica', 'id', 'inf_vert_met_id');
    }
    

}
