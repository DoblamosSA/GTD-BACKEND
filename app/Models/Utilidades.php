<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class Utilidades
{
    public function convertirFechaFormatoNormal($fecha)
    {
        $res = null;

        if ($fecha != null) {
            $res = date('d-m-Y', strtotime(str_replace('/', '-', $fecha)));
        }

        return $res;
    }

    public function convertirFechaFormatoBaseDatos($fecha)
    {
        $res = null;

        if ($fecha != null) {
            $res = date('Y-m-d', strtotime(str_replace('/', '-', $fecha)));
        }

        return $res;
    }

    public function convertirFormatoFechaHoraBaseDatos($fecha)
    {
        $res = null;

        if ($fecha != null) {
            $res = date('Y-m-d h:i', strtotime(str_replace('/', '-', $fecha)));
        }

        return $res;
    }


    public function guardarImagen(Request $request)
    {
        //    request()->validate([
        //      'file'  => 'required|mimes:doc,docx,pdf,txt|max:2048',
        //    ]);

        if ($files = $request->file('file')) {

            //store file into document folder
            $file = $request->file->store('public/documents');
            $path_parts = pathinfo($file);
            $res = $path_parts['basename'];
        }

        return  $res;
    }

    public function eliminarImagen($filename)
    {
        try {
            $res = false;
            if (!empty($filename)) {
             
                if (Storage::exists('public/documents/' . $filename)) {
                    Storage::delete('public/documents/' . $filename);
                    $res = true;
                }
        
                return  $res;
            }
        } catch (Throwable $e) {
        }
    }
}
