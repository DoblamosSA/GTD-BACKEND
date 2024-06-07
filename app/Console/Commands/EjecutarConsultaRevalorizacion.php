<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ConsultaRevalorizacion; 

class EjecutarConsultaRevalorizacion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ejecutarconsultarevalorizacioncommand'; 


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta la consulta de revalorización';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controller = new \App\Http\Controllers\Logistica\CostoProductosController();
        $request = new \Illuminate\Http\Request();
        $response = $controller->ConsultaCostoProductosSAP($request);
    }
    
}
