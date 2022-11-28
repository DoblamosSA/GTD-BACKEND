<?php

namespace App\Http\Controllers\InformeLiquidoPenetrante;

use App\Http\Controllers\Controller;
use App\Models\InformeLiquidosPenetrante;
use App\Models\Utilidades;
use Exception;
// use App\Models\LiquidosPenetrante;
use Illuminate\Http\Request;

class PageController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2()
    {
        $liquidosPenetrantes = InformeLiquidosPenetrante::paginate();

        return view('informe-liquidos-penetrante.index', compact('liquidosPenetrantes'))
            ->with('i', (request()->input('page', 1) - 1) * $liquidosPenetrantes->perPage());
    }

    public function index(Request $request)
    {
        $busqueda = $request->busqueda;
        $liquidosPenetrantes =  InformeLiquidosPenetrante::where('nombre_proyecto','LIKE','%'.$busqueda.'%')
        ->orWhere('fecha','LIKE','%'.$busqueda.'%')
        ->latest('id')->
        paginate(10);
        $data=[
            'liquidosPenetrantes'=>$liquidosPenetrantes,
        ];
        return view('informe-liquidos-penetrante.index',$data);
       
        // $liquidosPenetrantes = InformeLiquidosPenetrante::paginate();

        // return view('informe-liquidos-penetrante.index', compact('liquidosPenetrantes'))
        //     ->with('i', (request()->input('page', 1) - 1) * $liquidosPenetrantes->perPage());

        // $fecha_inicio = $request->get('fecha_inicio');
        // $fecha_final = $request->get('fecha_final');
        // $liquidosPenetrantes = [];

        // try {
        //     $liquidosPenetrantes = InformeLiquidosPenetrante::whereBetween('fecha', [
        //             (new Utilidades())->convertirFechaFormatoBaseDatos($fecha_inicio),
        //             (new Utilidades())->convertirFechaFormatoBaseDatos($fecha_final)
        //         ])
        //         ->get();
        // } catch (Exception $ex) {
        // }

        // $data = [
        //     'liquidosPenetrantes'  => $liquidosPenetrantes,
        //     'fecha_inicio'  => $fecha_inicio,
        //     'fecha_final'  => $fecha_final,
        // ];

        // return view('informe-liquidos-penetrante.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $liquidosPenetrante = new InformeLiquidosPenetrante();
        return view('informe-liquidos-penetrante.create', compact('liquidosPenetrante'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input=$request->all();
        request()->validate(InformeLiquidosPenetrante::$rules);
  
        $liquidosPenetrante = InformeLiquidosPenetrante::create($request->all());

        return redirect('informe-liquidos-penetrante/edit/' . $liquidosPenetrante->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $liquidosPenetrante = InformeLiquidosPenetrante::find($id);

        return view('informe-liquidos-penetrante.show', compact('liquidosPenetrante'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $liquidosPenetrante = InformeLiquidosPenetrante::find($id);

        return view('informe-liquidos-penetrante.edit', compact('liquidosPenetrante'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  LiquidosPenetrante $liquidosPenetrante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate(InformeLiquidosPenetrante::$rules);
        $data = InformeLiquidosPenetrante::find($id);
        $data->update($request->all());

        return redirect()->back()
        ->with('success', 'InformePartesMagnetica updated successfully');

        // return redirect()->route('informe-liquidos-penetrantes.index')
        //     ->with('success', 'LiquidosPenetrante updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $liquidosPenetrante = InformeLiquidosPenetrante::find($id)->delete();

        return redirect()->route('informe-liquidos-penetrante.index')
            ->with('success', 'LiquidosPenetrante deleted successfully');
    }
}
