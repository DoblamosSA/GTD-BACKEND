<?php

namespace App\Imports;

use App\Models\EstructuraMelalica;
use Maatwebsite\Excel\Concerns\ToModel;

class EstruMetalicasImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new EstructuraMelalica([
            'Numero_Obra'          => $row[0],
            'Empresa_Cliente'      => $row[1],
            'Nombre_Obra '         => $row[2],
            'Descripcion'          => $row[3],
            'Estado'               => $row[4],
            'Valor_Antes_Iva'      => $row[5],
            'Contacto'             => $row[6],
            'AreaM2'               => $row[7],
            'm2'                   => $row[8],
            'Incluye_Montaje'      => $row[9],
        ]);
    }
}
