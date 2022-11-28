<?php

namespace App\Exports;

use App\Models\CotizacionEstructuras;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class CotizacionSeguimientoExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('Ingenieria.CotizacionesEstructura.export',[
            'cotizacionEstructuras' =>CotizacionEstructuras::all()
        ]);
    }

  
}
