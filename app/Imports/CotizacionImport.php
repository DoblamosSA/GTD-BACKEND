<?php

namespace App\Imports;

use App\Models\CotizacionEstructuras;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CotizacionImport implements ToModel, WithHeadingRow
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
            'Nombre_Obra' => $row['nombre_de_la_obra'],
            'Numero_Obra' => $row['obra'],
            'Empresa_Cliente' => $row['empresa_o_cliente'],
            'Fecha_Recibido' => Date::excelToDateTimeObject($row['fecha_de_recibo']),
            'Descripcion' => $row['descripcion'],
            'Estado' => $row['estado'],
            'Fecha_Cotizada' => Date::excelToDateTimeObject($row['fecha_cotizada']),
            'Valor_Antes_Iva' => $row['valor_antes_iva'],
            'Contacto' => $row['contacto'],
            'AreaM2' => $row['aream2'],
            'm2' => $row['m2'],
            'Incluye_Montaje' => $row['incluye_montaje'],
        ]);
    }

}