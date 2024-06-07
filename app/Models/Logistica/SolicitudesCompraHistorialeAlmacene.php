<?php

namespace App\Models\Logistica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudesCompraHistorialeAlmacene extends Model
{
    protected $fillable = ['doc_entry', 'doc_num','item_id', 'data','DocumentStatus','WarehouseCode','Fecha_contabilizacion','abastecimiento_almacenes'];
}
