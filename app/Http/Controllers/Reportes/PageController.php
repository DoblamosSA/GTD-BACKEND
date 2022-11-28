<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Models\DatosJuntasInformeUltrasonido;
use App\Models\InformeLiquidosPenetrante;
use App\Models\InformePartesMagnetica;
use App\Models\InformeUltrasonido;
use App\Models\InformeVertMetalica;
use App\Models\JuntasInformeLiquidosPenetrante;
use App\Models\JuntasInformePartesMagneticas;
use App\Models\LiquidosPenetrante;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function partes_magneticas($id)
    {
        $informePartesMagnetica = InformePartesMagnetica::find($id);
        $juntasInformePartesMagneticas = JuntasInformePartesMagneticas::where('inf_part_magneticas_id', $id)->get();
        $data = [
            'informePartesMagnetica'  => $informePartesMagnetica,
            'juntasInformePartesMagneticas'  => $juntasInformePartesMagneticas,
            'firmas' => [
                'review' => base64_encode(Storage::get($informePartesMagnetica->reviso)),
                'inspect' => base64_encode(Storage::get($informePartesMagnetica->inspeccionador))
            ]
        ];
        return view('reportes.informe_partes_magneticas', compact('data'));

    }

    public function liquidos_penetrante($id)
    {
        $informeLiquidosPenetrante = InformeLiquidosPenetrante::find($id);

        $data = [
            'informeLiquidosPenetrante'  => $informeLiquidosPenetrante,
        ];

        return view('reportes.informe_liquidos_penetrante', compact('data'));
    }

    public function ultrasonido($id)
    {
        $informeUltrasonido = InformeUltrasonido::find($id);


        $data = [
            'informeUltrasonido'  => $informeUltrasonido,
        ];

        return view('reportes.informe_ultrasonido', compact('data'));
    }

    public function ver_metalica($id)
    {
        $informeVertMetalica = InformeVertMetalica::find($id);

        $data = [
            'informeVertMetalica'  => $informeVertMetalica,
        ];

        return view('reportes.informe_vert_metalica', compact('data'));
    }
}
