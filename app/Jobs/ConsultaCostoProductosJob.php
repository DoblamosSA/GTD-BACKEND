<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ConsultaCostoProductosJob implements ShouldQueue
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
        $controller = new \App\Http\Controllers\Logistica\CostoProductosController();
        $request = new \Illuminate\Http\Request(); // Puedes ajustar esto según lo que necesites en tu función
        $response = $controller->ConsultaCostoProductosSAP($request);
        
        // Aquí puedes realizar acciones adicionales con la respuesta si es necesario
    }
    
}
