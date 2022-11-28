<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InformeUltrasonido
 *
 * @property $id
 * @property $proyecto
 * @property $codigo_norma_aplicable
 * @property $procedimiento_ut_no
 * @property $metodo_ensayo
 * @property $grado_calibracion
 * @property $Angulos_grados
 * @property $bloquereferencia_tipo
 * @property $bloque_referencia_serial
 * @property $calidad_material_base
 * @property $espesor
 * @property $metal_aporte
 * @property $acoplante
 * @property $proceso
 * @property $tipo_junta
 * @property $paso
 * @property $medio_paso
 * @property $rango
 * @property $elaboro
 * @property $reviso
 * @property $created_at
 * @property $updated_at
 *
 * @property JuntasInformeUltrasonido[] $juntasInformeUltrasonidos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class InformeUltrasonido extends Model
{
    
    static $rules = [
		'proyecto' => 'required',
		// 'metodo_ensayo' => 'required',
		// 'grado_calibracion' => 'required',
		// 'bloquereferencia_tipo' => 'required',
		// 'bloque_referencia_serial' => 'required',
		// 'calidad_material_base' => 'required',
		// 'espesor' => 'required',
		// 'metal_aporte' => 'required',
		// 'acoplante' => 'required',
		// 'proceso' => 'required',
		// 'tipo_junta' => 'required',
		// 'paso' => 'required',
		// 'medio_paso' => 'required',
		// 'rango' => 'required',
		'elaboro' => 'required',
		'reviso' => 'required',
    ];
	

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['proyecto','grado_calibracion','angulos_grados','bloquereferencia_tipo','bloque_referencia_serial','calidad_material_base','espesor','metal_aporte','acoplante','proceso','tipo_junta','paso','medio_paso','rango','elaboro','reviso'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function juntasInformeUltrasonidos()
    {
        return $this->hasMany('App\Models\JuntasInformeUltrasonido', 'inf_ultrasonido_id', 'id');
    }
    

}
