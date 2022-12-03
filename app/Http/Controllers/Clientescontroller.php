<?php

namespace App\Http\Controllers;
use App\Models\Cliente;
use Illuminate\Http\Request;

class Clientescontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cliente = Cliente::all();
        return view('clientes.index',compact('cliente'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Empresa' => 'required',
            'Nit' => 'required',
            'Contacto' => 'required',
            'Correo' => 'required',
            'Telefono' => 'required'
        ]);
        $cliente = new Cliente();
        $cliente->Empresa = $request->Empresa;
        $cliente->Nit = $request->Nit;
        $cliente->Contacto = $request->Contacto;
        $cliente->Correo = $request->Correo;
        $cliente->Telefono = $request->Telefono;
        $cliente->save();
       
        return redirect()->route('clientes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        $cliente= Cliente::findOrFail($id);

        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->Empresa = $request->Empresa;
        $cliente->Nit = $request->Nit;
        $cliente->Contacto = $request->Contacto;
        $cliente->Correo = $request->Correo;
        $cliente->Telefono = $request->Telefono;
     
        $cliente->save();
        return redirect()->route('clientes.index')
            ->with('eliminar', 'actual');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id)->delete();

        return redirect()->route('clientes.index')
            ->with('eliminar', 'ok');
    }
}
