<?php

namespace App\Models\BodegasSAP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodegasSAP extends Model
{
    use HasFactory;

    protected $fillable =['WarehouseCode','WarehouseName'];
   
    public function materiales()
    {
        return $this->hasMany('App\Models\Material', 'warehouse_id');
    }
}




