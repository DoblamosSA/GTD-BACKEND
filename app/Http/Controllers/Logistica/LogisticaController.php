<?php

namespace App\Http\Controllers\Logistica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogisticaController extends Controller
{


    public function index(){

        return view('Logistica.index');
    }
  
}
