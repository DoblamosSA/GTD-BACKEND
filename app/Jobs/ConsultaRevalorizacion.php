<?php

namespace App\Jobs;

use App\Http\Controllers\Logistica\CostoProductosController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ConsultaRevalorizacion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $controller = new CostoProductosController(); // Crear instancia del controlador
        $request = new \Illuminate\Http\Request();
        $response = $controller->ConsultaCostoProductosSAP($request);
        
        // Puedes realizar acciones adicionales con la respuesta si es necesario
    }
}
