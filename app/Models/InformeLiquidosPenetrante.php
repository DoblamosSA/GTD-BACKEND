<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InformeLiquidosPenetrante
 *
 * @property $id
 * @property $nombre_proyecto
 * @property $fecha
 * @property $lugar_inspeccion
 * @property $metodologia_aplicada
 * @property $procedimiento_pt
 * @property $codigo_aceptacion_rechazo
 * @property $calidad_material_base
 * @property $proceso_soldadura
 * @property $espesor_material_base
 * @property $elemento
 * @property $inspeccionado_por
 * @property $nivel
 * @property $revisado_por
 * @property $nivel2
 * @property $mensaje_doblamos
 * @property $created_at
 * @property $updated_at
 *
 * @property JuntasInformeLiquidosPenetrante[] $juntasInformeLiquidosPenetrantes
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class InformeLiquidosPenetrante extends Model
{
    
    static $rules = [
		'nombre_proyecto' => 'required',
		'fecha' => 'required',
		// 'sitio_inspeccion' => 'required',
		// 'calidad_material_base' => 'required',
		// 'proceso_soldadura' => 'required',
		// 'espesor_material_base' => 'required',
		// 'elemento' => 'required',
		'inspeccionado_por' => 'required',
		'nivel' => 'required',
		'revisado_por' => 'required',
    'nivel2' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre_proyecto','fecha','sitio_inspeccion','calidad_material_base','proceso_soldadura','espesor_material_base','elemento','observaciones','inspeccionado_por','nivel','revisado_por','nivel2'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function juntasInformeLiquidosPenetrantes()
    {
        return $this->hasMany('App\Models\JuntasInformeLiquidosPenetrante', 'inf_liq_penetran_id', 'id');
    }


    

}
