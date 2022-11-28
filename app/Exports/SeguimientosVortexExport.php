<?php

namespace App\Exports;

use App\Models\Vorte;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Illuminate\Contracts\View\View;

class SeguimientosVortexExport implements  FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
   
        public function view(): View
        {
            return view('vortexDoblamos.export',[
                'vorte' =>Vorte::all()
            ]);
        }
    
}
