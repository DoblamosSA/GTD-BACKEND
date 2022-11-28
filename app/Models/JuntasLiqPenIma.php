<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JuntasLiqPenIma
 *
 * @property $id
 * @property $file_path
 * @property $junta_liq_penetran_id
 * @property $created_at
 * @property $updated_at
 *
 * @property JuntasInformeLiquidosPenetrante $juntasInformeLiquidosPenetrante
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class JuntasLiqPenIma extends Model
{
  protected $table = 'juntas_liq_pen_ima';
  static $rules = [
    'file_path' => 'required',
  ];

  protected $perPage = 20;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = ['file_path', 'junta_liq_penetran_id'];


  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function juntasInformeLiquidosPenetrante()
  {
    return $this->hasOne('App\Models\JuntasInformeLiquidosPenetrante', 'id', 'junta_liq_penetran_id');
  }
}
