<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InformePartesMagnetica
 *
 * @property $id
 * @property $proyecto
 * @property $fecha
 * @property $sitio_inspeccion
 * @property $cod_acep_rechazo
 * @property $calidad_material_b
 * @property $proceso_soldadura
 * @property $espesor_material_b
 * @property $inspeccionador
 * @property $nivel
 * @property $reviso
 * @property $nivelreviso
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class InformePartesMagnetica extends Model
{
    
    static $rules = [
		'proyecto' => 'required',
		'fecha' => 'required',
		// 'sitio_inspeccion' => 'required',
		// 'cod_acep_rechazo' => 'required',
		// 'calidad_material_b' => 'required',
		// 'proceso_soldadura' => 'required',
		// 'espesor_material_b' => 'required',
		'inspeccionador' => 'required',
		'nivel' => 'required',
		'reviso' => 'required',
		'nivelreviso' => 'required',
    ];
	

    protected $perPage = 20;
	
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['proyecto','fecha','sitio_inspeccion','cod_acep_rechazo','calidad_material_b','proceso_soldadura','espesor_material_b','inspeccionador','nivel','reviso','nivelreviso'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function juntasInformePartesMagneticas()
    {
        return $this->hasMany('App\Models\JuntasInformePartesMagneticas', 'inf_part_magneticas_id', 'id');
    }

}
