<?php

namespace App\Imports;

use App\Models\CotizacionEstructuras;

use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;

class CotizacionImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    use Importable;

    
    public function model(array $row)
    {
        return new CotizacionEstructuras([
          
            'Numero_Obra'          => $row[0],
            'Empresa_Cliente'      => $row[1],
            'Fecha_Recibido'       =>  Carbon::createFromFormat('d/m/Y',$row[2]),
            'Nombre_Obra '         => $row[3],
            'Descripcion'          => $row[4],
            'Estado'               => $row['5'],
            'Fecha_Cotizada'       => Carbon::createFromFormat('d/m/Y',$row[6]),
            'Valor_Antes_Iva'      => $row[7],
            'Contacto'             => $row[8],
            'AreaM2'               => $row[9],
            'm2'                   => $row[10],
            'Incluye_Montaje'      => $row[11],
        ]);
    }
}
