<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InformeAntiguedad;

class ConexionBDHannaSAPController extends Controller
{
    public function prueba()
    {
        // Configuración de las variables de entorno para ODBC
        putenv("DYLD_LIBRARY_PATH=/usr/sap/hdbclient/libodbcHDB.so");
        putenv("ODBCINI=/etc/odbc.ini"); // o la ruta correcta de tu archivo odbc.ini

        // Definición de constantes
        define("DSN", "HANA");
        define("USER", "UDOBLAMOS");
        define("PASSWORD", "D06l43D9A57$");

        // Intentar la conexión ODBC
        $conector = odbc_connect("DRIVER={HDBODBC};ServerNode=52.252.0.194:30015;DATABASE=HBT_DOBLAMOS;", USER, PASSWORD);
        if ($conector) {
            echo "Conexion exitosa";

            $consulta = 'SELECT * FROM "HBT_DOBLAMOS"."INFORME_ANTIGUEDAD"';
            $resultado = odbc_exec($conector, $consulta);

            $data = []; // Array para almacenar los resultados

            // Obtener los resultados en un array asociativo
            while ($fila = odbc_fetch_array($resultado)) {
                $data[] = $fila;
            }

            odbc_close($conector);

            // Cambiar la codificación después de obtener los resultados
            $data = array_map(function ($fila) {
                return array_map('utf8_encode', $fila);
            }, $data);

            // Verificar los datos antes de convertir a JSON
            echo "<pre>";
            print_r($data);
            echo "</pre>";

            // Llamar a la función para guardar en la base de datos local
            $this->guardarEnBaseLocal($data);

            return "Datos almacenados en la base de datos local.";
        } else {
            echo "Error en la conexión: " . odbc_errormsg();
        }
    }

    private function guardarEnBaseLocal($data)
    {
        // Almacenar en la base de datos local
        foreach ($data as $item) {
            // Eliminar claves con espacios en los nombres y limpiar cadenas
            $item = array_map(function ($value) {
                return is_array($value) ? $this->eliminarEspaciosClaves($value) : $this->limpiarCadena($value);
            }, $item);

            // Verificar si la cadena tiene caracteres no permitidos
            if ($this->cadenaEsValida($item)) {
                // Mapear los campos de la base de datos local
                $informeAntiguedad = new InformeAntiguedad();
                foreach ($item as $clave => $valor) {
                    $informeAntiguedad->{$clave} = $valor;
                }

                // Guardar el registro en la base de datos local
                $informeAntiguedad->save();
            } else {
                // Log o manejo de datos no válidos
                echo "Datos descartados: ";
                print_r($item);
            }
        }
    }

    private function limpiarCadena($cadena)
    {
        // Eliminar caracteres no permitidos y convertir a UTF-16
        return mb_convert_encoding(preg_replace('/[^\p{L}\p{N}\p{Zs}]/u', '', $cadena), 'UTF-16');
    }
    
    private function cadenaEsValida($item)
    {
        // Verificar si alguna cadena tiene caracteres no permitidos
        foreach ($item as $valor) {
            if ($this->contieneCaracteresNoPermitidos($valor)) {
                return false;
            }
        }
        return true;
    }

    private function contieneCaracteresNoPermitidos($cadena)
    {
        // Verificar si la cadena contiene caracteres no permitidos
        return preg_match('/[^\p{L}\p{N}\p{Zs}\p{P}\p{S}]/u', $cadena);
    }
}
