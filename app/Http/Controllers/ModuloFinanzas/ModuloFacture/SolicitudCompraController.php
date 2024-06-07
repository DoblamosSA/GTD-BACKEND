<?php

namespace App\Http\Controllers\ModuloFinanzas\ModuloFacture;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SolicitudCompraController extends Controller
{
    public function index(){
        return view('ModuloFinanzas.ModuloFinanzas');
    }


    public function solicitudcompraindex(){
        return view('ModuloFinanzas.ModuloFacture.SolicitudesCompra');
    }
}
