<?php

namespace App\Models\MaterialesSAP;

use App\Models\BodegasSAP\BodegasSAP;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiales extends Model
{
    use HasFactory;

    protected $fillable = ['ItemCode','ItemName','StandardAveragePrice','SalesUnitWeight','warehouse_id'];

    public function BodegasSAP()
    {
        return $this->belongsTo('App\Models\BodegasSAP', 'warehouse_id');
    }
}
