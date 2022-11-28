<?php

namespace App\Http\Controllers\InformePartesMagnetica;

use App\Http\Controllers\Controller;
use App\MenusOpciones\MenusOpciones;
use App\Models\InformePartesMagnetica;
use App\Models\Utilidades;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2(Request $request)
    {
       
        $informePartesMagneticas = InformePartesMagnetica::paginate();

        return view('informe-partes-magnetica.index', compact('informePartesMagneticas'))
            ->with('i', (request()->input('page', 1) - 1) * $informePartesMagneticas->perPage());
    }

    public function index(Request $request)
    {

        $busqueda = $request->busqueda;
        $informePartesMagneticas =  InformePartesMagnetica::where('proyecto','LIKE','%'.$busqueda.'%')
        ->orWhere('created_at','LIKE','%'.$busqueda.'%')
        ->latest('id')->
        paginate(10);
        $data=[
            'informePartesMagneticas'=> $informePartesMagneticas,
        ];
        return view('informe-partes-magnetica.index',$data);
       
        // $fecha_inicio = $request->get('fecha_inicio');
        // $fecha_final = $request->get('fecha_final');
        // $informePartesMagneticas = [];

        // try {
        //     $informePartesMagneticas = InformePartesMagnetica::whereBetween('fecha', [
        //             (new Utilidades())->convertirFechaFormatoBaseDatos($fecha_inicio),
        //             (new Utilidades())->convertirFechaFormatoBaseDatos($fecha_final)
        //         ])
        //         ->get();
        // } catch (Exception $ex) {
        // }

        // $data = [
        //     'informePartesMagneticas'  => $informePartesMagneticas,
        //     'fecha_inicio'  => $fecha_inicio,
        //     'fecha_final'  => $fecha_final,
        // ];

        // return view('informe-partes-magnetica.index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $informePartesMagnetica = new InformePartesMagnetica();
        return view('informe-partes-magnetica.create', compact('informePartesMagnetica'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(InformePartesMagnetica::$rules);
        $regex = "/^data:(.+);base64,/i";
        $currentTime = time();

        $content = [
            'review' => preg_replace($regex, '', $request->input('reviso')),
            'inspect' => preg_replace($regex, '', $request->input('inspeccionador'))
        ];
        $filenames = [
            'review' => "informes/reviso-{$currentTime}.png",
            'inspect' => "informes/inspeccionador-{$currentTime}.png"
        ];

        Storage::put($filenames['review'], base64_decode($content['review']));
        Storage::put($filenames['inspect'], base64_decode($content['inspect']));

        $informePartesMagnetica = InformePartesMagnetica::create([
            'proyecto' => $request->input('proyecto'),
            'fecha' => $request->input('fecha'),
            'sitio_inspeccion' => $request->input('sitio_inspeccion'),
            'cod_acep_rechazo' => $request->input('cod_acep_rechazo'),
            'calidad_material_b' => $request->input('calidad_material_b'),
            'proceso_soldadura' => $request->input('proceso_soldadura'),
            'espesor_material_b' => $request->input('espesor_material_b'),
            'inspeccionador' => $filenames['inspect'],
            'nivel' => $request->input('nivel'),
            'reviso' => $filenames['review'],
            'nivelreviso' => $request->input('nivelreviso')
        ]);

        return redirect('informe-partes-magneticas/edit/' . $informePartesMagnetica->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {        
        // $dato=\App\MenusOpciones\MenusOpciones::$sitioInspeccion;

        // MenusOpciones

        $informePartesMagnetica = InformePartesMagnetica::find($id);

        return view('informe-partes-magnetica.show', compact('informePartesMagnetica'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $informePartesMagnetica = InformePartesMagnetica::find($id);

        return view('informe-partes-magnetica.edit', compact('informePartesMagnetica'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  InformePartesMagnetica $informePartesMagnetica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        
         //actualiza los datos en la bd
         $informePartesMagnetica=InformePartesMagnetica::findOrFail($id);
         $informePartesMagnetica->proyecto=$request->input('proyecto');
         $informePartesMagnetica->fecha=$request->input('fecha');
         $informePartesMagnetica->sitio_inspeccion=$request->input('sitio_inspeccion');
         $informePartesMagnetica->cod_acep_rechazo=$request->input('cod_acep_rechazo');
         $informePartesMagnetica->calidad_material_b=$request->input('calidad_material_b');
         $informePartesMagnetica->proceso_soldadura=$request->input('proceso_soldadura');
         $informePartesMagnetica->espesor_material_b=$request->input('espesor_material_b');
         $informePartesMagnetica->nivel=$request->input('nivel');
         $informePartesMagnetica->nivelreviso=$request->input('nivelreviso');
         $informePartesMagnetica->save();
         return redirect('informe-partes-magneticas/edit/' . $informePartesMagnetica->id);


    //     request()->validate(InformePartesMagnetica::$rules);
    //     $data = InformePartesMagnetica::find($id);
    //     $data->update($request->all());

    //    // return redirect()->route('informe-ultrasonido.index')
    //    return redirect()->back()
    //         ->with('success', 'informeUltrasonido updated successfully');

    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $informePartesMagnetica = InformePartesMagnetica::find($id)->delete();

        return redirect()->route('informe-partes-magneticas.index')
            ->with('success', 'InformePartesMagnetica deleted successfully');
    }
}
