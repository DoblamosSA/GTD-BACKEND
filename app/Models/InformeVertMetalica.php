<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InformeVertMetalica
 *
 * @property $id
 * @property $proyecto
 * @property $fecha_verificacion
 * @property $estructuras
 * @property $planta_area
 * @property $contratista
 * @property $equipo_medicion
 * @property $torque_1
 * @property $torque_2
 * @property $resultado_inspeccion
 * @property $observaciones
 * @property $adjuntos
 * @property $contratisca_nombre
 * @property $contratisca_firma
 * @property $contratisca_cargo
 * @property $residente_nombre
 * @property $residente_firma
 * @property $residente_cargo
 * @property $inspector_nombre
 * @property $inspector_firma
 * @property $inspector_cargo
 * @property $representante_nombre
 * @property $representante_firma
 * @property $representante_cargo
 * @property $created_at
 * @property $updated_at
 *
 * @property JuntasInformeVertMetalica[] $juntasInformeVertMetalicas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class InformeVertMetalica extends Model
{
    
    static $rules = [
		'proyecto' => 'required',
		'fecha_verificacion' => 'required',
		// 'estructuras' => 'required',
		// 'planta_area' => 'required',
		// 'contratista' => 'required',
		// 'equipo_medicion' => 'required',
		// 'torque' => 'required',
		// 'resultado_inspeccion' => 'required',
		// 'observaciones' => 'required',
		// 'adjuntos' => 'required',
		'contratisca_nombre' => 'required',
		'contratisca_firma' => 'required',
		'contratisca_cargo' => 'required',
		'residente_nombre' => 'required',
		'residente_firma' => 'required',
		'residente_cargo' => 'required',
		'inspector_nombre' => 'required',
		'inspector_firma' => 'required',
		'inspector_cargo' => 'required',
		'representante_nombre' => 'required',
		'representante_firma' => 'required',
		'representante_cargo' => 'required',
    ];
	
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['proyecto','fecha_verificacion','estructuras','planta_area','contratista','equipo_medicion','torque','resultado_inspeccion','observaciones','adjuntos','contratisca_nombre','contratisca_firma','contratisca_cargo','residente_nombre','residente_firma','residente_cargo','inspector_nombre','inspector_firma','inspector_cargo','representante_nombre','representante_firma','representante_cargo'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function juntasInformeVertMetalicas()
    {
        return $this->hasMany('App\Models\JuntasInformeVertMetalica', 'inf_vert_met_id', 'id');
    }
    

}
